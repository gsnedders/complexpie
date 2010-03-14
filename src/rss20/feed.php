<?php
namespace ComplexPie\RSS20;

class Feed extends \ComplexPie\XML\Feed
{
    protected static $static_ext = array();

    protected static $aliases = array(
        'entries' => 'items',
    );
    
    protected static $elements = array(
        'description' => array(
            'element' => 'description',
            'contentConstructor' => 'ComplexPie\\Content::from_escaped_html',
            'single' => true
        ),
        'link' => array(
            'element' => 'link',
            'contentConstructor' => 'ComplexPie\\Content\\IRINode',
            'single' => true
        ),
        'title' => array(
            'element' => 'title',
            'contentConstructor' => 'ComplexPie\\Content::from_escaped_html',
            'single' => true
        ),
    );
    
    protected static $element_namespaces = array(
    );
    
    protected static function getter_items($feed, $dom)
    {
        $nodes = \ComplexPie\Misc::xpath($dom, 'item');
        if ($nodes->length !== 0)
        {
            $return = array();
            foreach ($nodes as $node)
            {
                $tree = $feed->data['child']['']['rss'][0]['child']['']['channel'][0]['child']['']['item'][count($return)];
                $return[] = new Item($feed, $tree, $node);
            }
            return $return;
        }
    }
}

Feed::add_static_extension('get', '\\ComplexPie\\RSS20\\links', ~PHP_INT_MAX);
