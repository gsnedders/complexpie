<?php
namespace ComplexPie\Atom10;

class Feed
{
    private static $elements = array(
        'title' => array(
            'atom:title',
            'atomTextConstruct',
            true
        ),
        'subtitle' => array(
            'atom:subtitle',
            'atomTextConstruct',
            true
        ),
    );
    
    public function __invoke($dom, $name)
    {
        if (isset(self::$elements[$name]))
        {
            return $this->elements_table($dom, $name);
        }
    }
    
    private function elements_table($dom, $name)
    {
        $element = self::$elements[$name];
        if ($return = \ComplexPie\Misc::get_descendant($dom, $element[0], array('atom' => XMLNS), $element[2]))
        {
            switch ($element[1])
            {
                case 'atomTextConstruct':
                    return Content::from_text_construct($return);
                
                default:
                    throw new \Exception('Um, this shouldn\'t happen');
            }
        }
    }
}
