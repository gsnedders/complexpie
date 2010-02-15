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
        'links' => array(
            'element' => 'atom:link',
            'contentConstructor' => 'ComplexPie\\Atom10\\Content\\Link',
            'single' => false
        ),
    );
    
    public function __invoke($dom, $name)
    {
        if (isset(self::$elements[$name]))
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
