<?php
namespace ComplexPie\Atom10;

abstract class Content extends \ComplexPie\Content
{
    public static function from_text_construct($text_construct)
    {
        switch ($text_construct->getAttribute('type'))
        {
            case 'html':
                return self::from_escaped_html($text_construct);
            
            case 'xhtml':
                $can_use_div = true;
                foreach ($text_construct->childNodes as $child)
                {
                    switch ($child->nodeType)
                    {
                        case XML_COMMENT_NODE:
                            break;
                        
                        case XML_TEXT_NODE:
                            if (strspn($child->data, "\x09\x0A\x0D\x20") === strlen($child->data))
                                break;
                        
                        case XML_ELEMENT_NODE:
                            if ($child->namespaceURI === 'http://www.w3.org/1999/xhtml' &&
                                $child->localName === 'div' &&
                                !isset($the_div))
                            {
                                $the_div = $child;
                                break;
                            }
                        
                        default:
                            $can_use_div = false;
                            break 2;
                    }
                }
                $element = $can_use_div && isset($the_div) ? $the_div : $text_construct;
                return new \ComplexPie\Content\Node($element->childNodes);
                
            default:
                return self::from_textcontent($text_construct);
        }
    }
    
    /**
     * @todo Cope with @src somehow
     */
    public static function from_content($content)
    {
        if (!$content->hasAttribute('type'))
        {
            return self::from_textcontent($content);
        }
        else
        {
            $type = $content->getAttribute('type');
            $lowerType = strtolower($type);
            
            if ($type === 'text' || $lowerType === 'text/plain')
            {
                return self::from_textcontent($content);
            }
            elseif ($type === 'html' || $lowerType === 'text/html')
            {
                return self::from_escaped_html($content);
            }
            elseif ($type === 'xhtml' || $lowerType === 'application/xhtml+xml')
            {
                $can_use_div = true;
                foreach ($content->childNodes as $child)
                {
                    switch ($child->nodeType)
                    {
                        case XML_COMMENT_NODE:
                            break;
                        
                        case XML_TEXT_NODE:
                            if (strspn($child->data, "\x09\x0A\x0D\x20") === strlen($child->data))
                                break;
                        
                        case XML_ELEMENT_NODE:
                            if ($child->namespaceURI === 'http://www.w3.org/1999/xhtml' &&
                                $child->localName === 'div' &&
                                !isset($the_div))
                            {
                                $the_div = $child;
                                break;
                            }
                        
                        default:
                            $can_use_div = false;
                            break 2;
                    }
                }
                $element = $can_use_div && isset($the_div) ? $the_div : $content;
                return new \ComplexPie\Content\Node($element->childNodes);
            }
            elseif (!preg_match('/^[A-Za-z0-9!#$&.+\-^_]{1,127}\/[A-Za-z0-9!#$&.+\-^_]{1,127}$/', $type))
            {
               return false;
            }
            elseif (
                $lowerType === 'text/xml' ||
                $lowerType === 'application/xml' ||
                $lowerType === 'text/xml-external-parsed-entity' ||
                $lowerType === 'application/xml-external-parsed-entity' ||
                $lowerType === 'application/xml-dtd' ||
                substr($lowerType, -3) === 'xml' && strspn($lowerType, '+/', -4, 1) === 1
            )
            {    
                return new \ComplexPie\Content\Node($content->childNodes);
            }
            elseif (substr($lowerType, 0, 5) === 'text/')
            {
                return new \ComplexPie\Content\Binary($content->textContent, $lowerType);
            }
            else
            {
                $data = base64_decode(trim($content->textContent, "\x09\x0A\x0C\x0D\x20"), true);
                if ($data)
                {
                    return new \ComplexPie\Content\Binary($data, $lowerType);
                }
                else
                {
                    return false;
                }
            }
        }
    }
}
