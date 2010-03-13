<?php
namespace ComplexPie\Atom10;

class Entry extends \ComplexPie\XML\Entry
{
    protected static $static_ext = array();

    protected static $aliases = array(
        'description' => 'summary',
    );
    
    protected static $elements = array(
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
        // XXX: content
        'contributors' => array(
            'element' => 'atom:contributor',
            'contentConstructor' => 'ComplexPie\\Atom10\\Content\\Person',
            'single' => false
        ),
        'id' => array(
            'element' => 'atom:id',
            // Yes, not an IRI. atom:id is an opaque non-normalizable IRI,
            // which is nothing more than an opaque string.
            'contentConstructor' => 'ComplexPie\\Content::from_textcontent',
            'single' => true
        ),
        // link is special cased, added as an extension below
        'published' => array(
            'element' => 'atom:published',
            'contentConstructor' => 'ComplexPie\\Content::from_date_in_textcontent',
            'single' => true
        ),
        'rights' => array(
            'element' => 'atom:rights',
            'contentConstructor' => 'ComplexPie\\Atom10\\Content::from_text_construct',
            'single' => true
        ),
        // XXX: source
        'summary' => array(
            'element' => 'atom:summary',
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
    );
    
    protected static $element_namespaces = array(
        'atom' => XMLNS,
    );
}

Entry::add_static_extension('get', '\\ComplexPie\\Atom10\\links', ~PHP_INT_MAX);
