<?php
namespace ComplexPie\XML;

class Data extends \ComplexPie\Data
{
    public function __construct()
    {
        parent::__construct();
        $this->add_extension('get', get_class($this) . '::get', ~PHP_INT_MAX);
    }
    
    protected static function get($data, $dom, $name)
    {
        if (isset(static::$elements[$name]))
        {
            return static::elements_table($dom, $name);
        }
        elseif (isset(static::$aliases[$name]))
        {
            return static::get($data, $dom, static::$aliases[$name]);
        }
        elseif (is_callable("static::getter_$name"))
        {
            return call_user_func("static::getter_$name", $data, $dom);
        }
    }
    
    private static function elements_table($dom, $name)
    {
        $element = static::$elements[$name];
        $nodes = \ComplexPie\Misc::xpath($dom, $element['element'], static::$element_namespaces);
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