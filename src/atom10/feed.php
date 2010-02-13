<?php
namespace ComplexPie\Atom10;

class Feed
{
    private static $aliases = array(
        'description' => 'subtitle',
        'tagline' => 'subtitle'
    );
    
    private static $elements = array(
        'title' => array(
            'element' => 'atom:title',
            'type' => 'atomTextConstruct',
            'single' => true
        ),
        'subtitle' => array(
            'element' => 'atom:subtitle',
            'type' => 'atomTextConstruct',
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
            switch ($element['type'])
            {
                case 'atomTextConstruct':
                    return Content::from_text_construct($return);
                
                default:
                    throw new \Exception('Um, this shouldn\'t happen');
            }
        }
    }
}
