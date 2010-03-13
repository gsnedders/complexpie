<?php
namespace ComplexPie\Atom10;

class Feed extends \ComplexPie\Feed
{
    private static $aliases = array(
        'description' => 'subtitle',
        'tagline' => 'subtitle',
        'copyright' => 'rights',
    );
    
    private static $elements = array(
        'authors' => array(
            'element' => 'atom:author',
            'contentConstructor' => 'ComplexPie\\Atom10\\Content\\Person',
            'single' => false
        ),
        'categories' => array(
            'element' => 'atom:category',
            'contentConstructor' => 'ComplexPie\\Atom10\\Content\\Category',
            'single' => false
        ),
        'contributors' => array(
            'element' => 'atom:contributor',
            'contentConstructor' => 'ComplexPie\\Atom10\\Content\\Person',
            'single' => false
        ),
        // XXX: generator
        'icon' => array(
            'element' => 'atom:icon',
            'contentConstructor' => 'ComplexPie\\Content\\IRINode',
            'single' => true
        ),
        'id' => array(
            'element' => 'atom:id',
            // Yes, not an IRI. atom:id is an opaque non-normalizable IRI,
            // which is nothing more than an opaque string.
            'contentConstructor' => 'ComplexPie\\Content::from_textcontent',
            'single' => true
        ),
        // link is special cased, see below in __invoke.
        'logo' => array(
            'element' => 'atom:logo',
            'contentConstructor' => 'ComplexPie\\Content\\IRINode',
            'single' => true
        ),
        'rights' => array(
            'element' => 'atom:rights',
            'contentConstructor' => 'ComplexPie\\Atom10\\Content::from_text_construct',
            'single' => true
        ),
        'subtitle' => array(
            'element' => 'atom:subtitle',
            'contentConstructor' => 'ComplexPie\\Atom10\\Content::from_text_construct',
            'single' => true
        ),
        'title' => array(
            'element' => 'atom:title',
            'contentConstructor' => 'ComplexPie\\Atom10\\Content::from_text_construct',
            'single' => true
        ),
        'updated' => array(
            'element' => 'atom:updated',
            'contentConstructor' => 'ComplexPie\\Content::from_date_in_textcontent',
            'single' => true
        ),
        // XXX: entry
    );
    
    public static function getter_links($dom)
    {
        $nodes = \ComplexPie\Misc::xpath($dom,'atom:link[@href]', array('atom' => XMLNS));
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
    
    public function __construct()
    {
        $this->add_extension('get', get_class($this) . '::get', 0);
        $args = func_get_args();
        call_user_func_array(array($this, 'parent::__construct'), $args);
    }
    
    public static function get($dom, $name)
    {
        if (isset(self::$elements[$name]))
        {
            return self::elements_table($dom, $name);
        }
        elseif (isset(self::$aliases[$name]))
        {
            return self::get($dom, self::$aliases[$name]);
        }
        elseif (is_callable("static::getter_$name"))
        {
            return call_user_func("static::getter_$name", $dom);
        }
    }
    
    private static function elements_table($dom, $name)
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
