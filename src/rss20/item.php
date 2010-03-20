<?php
namespace ComplexPie\RSS20;

class Item extends \ComplexPie\XML\Entry
{
    protected static $static_ext = array();

    protected static $aliases = array(
        'summary' => 'description',
        'published' => 'pubDate',
    );
    
    protected static $elements = array(
        // XXX: author
        // XXX: category
        // XXX: comments
        'description' => array(
            'element' => 'description',
            'contentConstructor' => 'ComplexPie\\Content::from_escaped_html',
            'single' => true
        ),
        // XXX: enclosure
        // XXX: guid
        'link' => array(
            'element' => 'link',
            'contentConstructor' => 'ComplexPie\\Content\\IRINode',
            'single' => true
        ),
        'pubDate' => array(
            'element' => 'pubDate',
            'contentConstructor' => 'ComplexPie\\Content::from_date_in_textcontent',
            'single' => true
        ),
        // XXX: source
        'title' => array(
            'element' => 'title',
            'contentConstructor' => 'ComplexPie\\Content::from_escaped_html',
            'single' => true
        ),
    );
    
    protected static $element_namespaces = array(
    );
}

Item::add_static_extension('get', '\\ComplexPie\\RSS20\\links', ~PHP_INT_MAX);
