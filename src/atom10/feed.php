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
        if ($return = \ComplexPie\Misc::get_descendant($dom, $element['element'], array('atom' => XMLNS), $element['single']))
        {
            return call_user_func($element['contentConstructor'], $return);
        }
    }
}
