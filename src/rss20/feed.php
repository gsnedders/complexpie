<?php
namespace ComplexPie\RSS20;

class Feed extends \ComplexPie\XML\Feed
{
    protected static $static_ext = array();

    protected static $aliases = array(
        'rights' => 'copyright',
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
        'categories' => array(
            'element' => 'category',
            'contentConstructor' => 'ComplexPie\\RSS20\\Content\\Category',
            'single' => false
        ),
        // XXX: cloud
        'copyright' => array(
            'element' => 'copyright',
            'contentConstructor' => 'ComplexPie\\Content::from_textcontent',
            'single' => true
        ),
        'docs' => array(
            'element' => 'docs',
            'contentConstructor' => 'ComplexPie\\Content\\IRINode',
            'single' => true
        ),
        'generator' => array(
            'element' => 'generator',
            'contentConstructor' => 'ComplexPie\\Content::from_textcontent',
            'single' => true
        ),
        'image' => array(
            'element' => 'image',
            'contentConstructor' => 'ComplexPie\\RSS20\\Content\\Image',
            'single' => true
        ),
        'language' => array(
            'element' => 'language',
            'contentConstructor' => 'ComplexPie\\Content::from_textcontent',
            'single' => true
        ),
        'lastBuildDate' => array(
            'element' => 'lastBuildDate',
            'contentConstructor' => 'ComplexPie\\Content::from_date_in_textcontent',
            'single' => true
        ),
        'managingEditor' => array(
            'element' => 'managingEditor',
            'contentConstructor' => 'ComplexPie\\Content::from_textcontent',
            'single' => true
        ),
        'pubDate' => array(
            'element' => 'pubDate',
            'contentConstructor' => 'ComplexPie\\Content::from_date_in_textcontent',
            'single' => true
        ),
        // XXX: rating
        // skipDays and skipHours are getters below
        // XXX: textInput
        // XXX: ttl
        'webMaster' => array(
            'element' => 'webMaster',
            'contentConstructor' => 'ComplexPie\\Content::from_textcontent',
            'single' => true
        ),
        // item is a getter below
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
    
    protected static function getter_skipDays($feed, $dom)
    {
        $nodes = \ComplexPie\Misc::xpath($dom, 'skipDays');
        if ($nodes->length !== 0)
        {
            $node = $nodes->item(0);
            $skip = array();
            $dayNodes = \ComplexPie\Misc::xpath($node, 'day');
            foreach ($dayNodes as $dayNode)
            {
                $content = strtolower($dayNode->textContent);
                if (
                    $content === 'monday' ||
                    $content === 'tuesday' ||
                    $content === 'wednesday' ||
                    $content === 'thursday' ||
                    $content === 'friday' ||
                    $content === 'saturday' ||
                    $content === 'sunday'
                )
                {
                    $skip[] = $content;
                }
            }
            $skip = array_unique($skip);
            array_walk($skip, 'ucfirst');
            return $skip;
        }
    }
    
    protected static function getter_skipHours($feed, $dom)
    {
        $nodes = \ComplexPie\Misc::xpath($dom, 'skipHours');
        if ($nodes->length !== 0)
        {
            $node = $nodes->item(0);
            $skip = array();
            $hourNodes = \ComplexPie\Misc::xpath($node, 'hour');
            foreach ($hourNodes as $hourNode)
            {
                $content = (int) $hourNode->textContent;
                if (0 <= $content && $content <= 24)
                {
                    $skip[] = $content;
                }
            }
            return array_unique($skip);
        }
    }
}

Feed::add_static_extension('get', '\\ComplexPie\\RSS20\\links', ~PHP_INT_MAX);
