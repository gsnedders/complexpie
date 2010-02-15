<?php
namespace ComplexPie\Content;

class Node extends \ComplexPie\Content
{
    public static $replaceURLAttributes = array(
        'a' => array('href'),
        'area' => array('href'),
        'blockquote' => array('cite'),
        'del' => array('cite'),
        'form' => array('action'),
        'img' => array('longdesc', 'src'),
        'input' => array('src'),
        'ins' => array('cite'),
        'q' => array('cite')
    );
    
    protected $nodes = array();
    protected $document;
    
    public function __construct($nodes)
    {
        // Iterate over the traversable $nodes, adding all nodes apart from
        // leading whitespace to $this->nodes.
        $seen_non_whitespace = false;
        foreach ($nodes as $node)
        {
            if (
                $seen_non_whitespace ||
                $node->nodeType !== XML_TEXT_NODE ||
                strspn($node->data, "\x09\x0A\x0D\x20") !== strlen($node->data)
            )
            {
                $seen_non_whitespace = true;
                $this->nodes[] = $node;
            }
        }
        
        // Remove trailing whitespace nodes (yes, this is horribly big for).
        for (
            $i = count($this->nodes) - 1;
                $i >= 0 && $this->nodes[$i]->nodeType === XML_TEXT_NODE &&
                strspn($this->nodes[$i]->data, "\x09\x0A\x0D\x20") === strlen($this->nodes[$i]->data);
            $i--
        )
        {
            unset($this->nodes[$i]);
        }
        
        // Now we have the final nodes array, do the init dance if it is not
        // empty.
        if ($this->nodes)
        {
            $this->document = $this->nodes[0] instanceof \DOMDocument ? $this->nodes[0] : $this->nodes[0]->ownerDocument;
            $this->replaceURLs();
        }
    }
    
    protected function replaceURLs()
    {
        $replaceURLAttributes = self::$replaceURLAttributes;
        $xpath = new \DOMXPath($this->document);
        foreach ($this->nodes as $node)
        {
            // Although this is implied by the XPath query, it's quicker to
            // check this explicitly here.
            if ($node->nodeType === XML_ELEMENT_NODE)
            {
                $children = $xpath->query('descendant-or-self::*', $node);
                foreach ($children as $child)
                {
                    if (isset($replaceURLAttributes[$child->tagName]))
                    {
                        foreach ($replaceURLAttributes[$child->tagName] as $attribute)
                        {
                            if ($child->hasAttribute($attribute))
                            {
                                $newValue = \ComplexPie\IRI::absolutize($child->baseURI, $child->getAttribute($attribute));
                                if ($newValue)
                                {
                                    $child->setAttribute($attribute, $newValue->iri);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    
    public function get_node()
    {
        return $this->nodes;
    }
    
    public function to_text()
    {
        $text = '';
        foreach ($this->nodes as $node)
        {
            $text .= $node->textContent;
        }
        return $text;
    }
    
    public function to_xml()
    {
        $xml = '';
        foreach ($this->nodes as $node)
        {
            $xml .= $this->document->saveXML($node);
        }
        return $xml;
    }
    
    public function to_html()
    {
        // Check if http://bugs.php.net/?id=50973 is fixed
        static $usefulSaveHTML;
        if ($usefulSaveHTML === null)
        {
            $dom = new \DOMDocument;
            $el = $dom->createElement('div');
            $usefulSaveHTML = substr(@$dom->saveHTML($el), 0, 4) === '<div';
        }
        
        $html = '';
        
        if ($usefulSaveHTML)
        {
            foreach ($this->nodes as $node)
            {
                $html .= $this->document->saveHTML($node);
            }
        }
        else
        {
            foreach ($this->nodes as $node)
            {
                $html .= \ComplexPie\nodeToHTML($node);
            }
        }
        
        return $html;
    }
}
