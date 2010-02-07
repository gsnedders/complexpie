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
                $use_div = (bool) $text_construct->childNodes->length;
                foreach ($text_construct->childNodes as $child)
                {
                    switch ($child->nodeType)
                    {
                        case XML_COMMENT_NODE:
                            break;
                        
                        case XML_TEXT_NODE:
                            if (strspn("\x09\x0A\x0D\x20", $child->data) === strlen($child->data))
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
                            $use_div = false;
                            break 2;
                    }
                }
                $element = $use_div ? $the_div : $text_construct;
                return new \ComplexPie\Content\Node($element->childNodes);
                
            default:
                return self::from_textcontent($text_construct);
        }
    }
    
    public static function from_content($content)
    {
        switch ($content->getAttribute('type'))
        {
            case 'text':
                return self::from_textcontent($text_construct);
            
            case 'html':
                return self::from_escaped_html($content);
            
            case 'xhtml':
                $use_div = (bool) $content->childNodes->length;
                foreach ($content->childNodes as $child)
                {
                    switch ($child->nodeType)
                    {
                        case XML_COMMENT_NODE:
                            break;
                        
                        case XML_TEXT_NODE:
                            if (strspn("\x09\x0A\x0D\x20", $child->data) === strlen($child->data))
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
                            $use_div = false;
                            break 2;
                    }
                }
                $element = $use_div ? $the_div : $content;
                return new \ComplexPie\Content\Node($element->childNodes);
            
            default:
                $type = strtolower($content->getAttribute('type'));
                switch ($type)
                {
                    case 'text/xml':
                    case 'application/xml':
                    case 'text/xml-external-parsed-entity':
                    case 'application/xml-external-parsed-entity':
                    case 'application/xml-dtd':
                        return new \ComplexPie\Content\Node($content->childNodes);
                    
                    default:
                        $end = substr($type, -4);
                        if ($end === '+xml' || $end === '/xml')
                        {
                            return new \ComplexPie\Content\Node($content->childNodes);
                        }
                        elseif (substr($type, 0, 5) === 'text/')
                        {
                            return new \ComplexPie\Content\Binary($content->textContent, $type);
                        }
                        else
                        {
                            return new \ComplexPie\Content\Binary(base64_decode(trim($content->textContent, "\x09\x0A\x0C\x0D\x20")), $type);
                        }
                }
        }
    }
}
