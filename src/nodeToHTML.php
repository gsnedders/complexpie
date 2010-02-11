<?php
namespace ComplexPie;

function nodeToHTML($root)
{
    // Work out whether to treat null as the HTML namespace
    if (isset($root->ownerDocument))
    {
        $documentElement = $root->ownerDocument->documentElement;
    }
    else
    {
        $documentElement = $root->documentElement;
    }
    if ($documentElement->namespaceURI === null && $documentElement->localName === 'html')
    {
        $htmlns = null;
    }
    else
    {
        $htmlns = 'http://www.w3.org/1999/xhtml';
    }
    
    // Output var
    $html = '';
    
    // Serializer state
    $iterator = new DOMIterator($root);
    $stack = array();
    $raw_text = false;
    $rcdata = false;
    $void = false;
    foreach ($iterator as $node)
    {
        if ($stack)
        {
            while (end($stack) !== $node->parentNode)
            {
                $end = array_pop($stack);
                if ($end->namespaceURI === $htmlns &&
                    isset(Constants::$voidElements[$end->localName]))
                {
                    $void = false;
                }
                else
                {
                    $raw_text = false;
                    $rcdata = false;
                    $html .= '</' . $end->localName . '>';
                }
            }
        }
        switch ($node->nodeType)
        {
            case XML_ELEMENT_NODE:
                $stack[] = $node;
                if ($raw_text || $rcdata || $void)
                {
                    throw new SerializerError('Raw text, RCDATA, and void elements cannot contain other tags');
                }
                if ($node->namespaceURI === $htmlns)
                {
                    if (isset(Constants::$rawTextElements[$node->localName]))
                    {
                        $raw_text = true;
                    }
                    elseif (isset(Constants::$rcdataElements[$node->localName]))
                    {
                        $rcdata = true;
                    }
                    elseif (isset(Constants::$voidElements[$node->localName]))
                    {
                        $void = true;
                    }
                }
                $html .= '<' . $node->tagName;
                foreach ($node->attributes as $attribute)
                {
                    $html .= sprintf(' %s="%s"', $attribute->name, htmlspecialchars($attribute->value, ENT_QUOTES, 'UTF-8'));
                }
                $html .= '>';
                break;
            
            case XML_TEXT_NODE:
                if ($void)
                {
                    throw new SerializerError('Void elements cannot contain text');
                }
                elseif ($raw_text && preg_match('/<' . $stack[count($stack) - 1]->tagName . '[\x09\x0A\x0C\x0D\x20>\/]/i', $node->data))
                {
                    throw new SerializerError('Raw text elements cannot contain their own closing tags');
                }
                $html .= htmlspecialchars($node->data, ENT_QUOTES, 'UTF-8');
                break;
            
            case XML_COMMENT_NODE:
                if ($raw_text || $rcdata || $void)
                {
                    throw new SerializerError('Raw text, RCDATA, and void elements cannot contain comments');
                }
                elseif (strpos($node->data, '--') !== false)
                {
                    throw new SerializerError('Comments cannot contain --');
                }
                elseif (isset($node->data[0]) && $node->data[0] === '>')
                {
                    throw new SerializerError('Comments cannot start with >');
                }
                $html .= sprintf('<!--%s-->', $node->data);
                break;
        }
    }
    while ($end = array_pop($stack))
    {
        if ($end->namespaceURI === $htmlns &&
            isset(Constants::$voidElements[$end->localName]))
        {
            $void = false;
        }
        else
        {
            $raw_text = false;
            $rcdata = false;
            $html .= '</' . $end->localName . '>';
        }
    }
    return $html;
}
