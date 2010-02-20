<?php
namespace ComplexPie\Atom10;

class Feed
{
    private static $aliases = array(
        'description' => 'subtitle',
        'tagline' => 'subtitle',
        'copyright' => 'rights',
    );
    
    private static $elements = array(
        'title' => array(
            'element' => 'atom:title',
            'contentConstructor' => 'ComplexPie\\Atom10\\Content::from_text_construct',
            'single' => true
        ),
        'subtitle' => array(
            'element' => 'atom:subtitle',
            'contentConstructor' => 'ComplexPie\\Atom10\\Content::from_text_construct',
            'single' => true
        ),
        'rights' => array(
            'element' => 'atom:rights',
            'contentConstructor' => 'ComplexPie\\Atom10\\Content::from_text_construct',
            'single' => true
        ),
        'updated' => array(
            'element' => 'atom:updated',
            'contentConstructor' => 'ComplexPie\\Content::from_date_in_textcontent',
            'single' => true
        ),
    );
    
    public function __invoke($dom, $name)
    {
        if ($name === 'links')
        {
            $nodes = \ComplexPie\Misc::xpath($dom,'atom:link', array('atom' => XMLNS));
            if ($nodes->length !== 0)
            {
                $return = array();
                foreach ($nodes as $node)
                {
                    $link = new Content\Link($node);
                    $rel = $link->rel->to_text();
                    if (!isset($return[$rel]))
                    {
                        $return[$rel] = array();
                        if (substr($rel, 0, 41) === 'http://www.iana.org/assignments/relation/')
                        {
                            $return[substr($rel, 41)] =& $return[$rel];
                        }
                    }
                    $return[$rel][] = $link;
                }
                return $return;
            }
        }
        elseif (isset(self::$elements[$name]))
        {
            return $this->elements_table($dom, $name);
        }
        elseif (isset(self::$aliases[$name]))
        {
            return $this->__invoke($dom, self::$aliases[$name]);
        }
    }
    
    private function elements_table($dom, $name)
    {
        $element = self::$elements[$name];
        $nodes = \ComplexPie\Misc::xpath($dom, $element['element'], array('atom' => XMLNS));
        if ($nodes->length !== 0)
        {
            if ($element['single'])
            {
                if (class_exists($element['contentConstructor']))
                {
                    return new $element['contentConstructor']($nodes->item(0));
                }
                else
                {
                    return call_user_func($element['contentConstructor'], $nodes->item(0));
                }
            }
            else
            {
                $return = array();
                if (class_exists($element['contentConstructor']))
                {
                    foreach ($nodes as $node)
                    {
                        $return[] = new $element['contentConstructor']($node);
                    }
                }
                else
                {
                    foreach ($nodes as $node)
                    {
                        $return[] = call_user_func($element['contentConstructor'], $node);
                    }
                }
                return $return;
            }
        }
    }
}
