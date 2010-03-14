<?php
namespace ComplexPie\Atom10;

class Entry extends \ComplexPie\XML\Entry
{
    protected static $static_ext = array();

    protected static $aliases = array(
        'description' => 'summary',
    );
    
    protected static $elements = array(
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
    
    protected static function getter_authors($entry, $dom)
    {
        $nodes = \ComplexPie\Misc::xpath($dom, 'atom:author', self::$element_namespaces);
        if ($nodes->length !== 0)
        {
            $return = array();
            foreach ($nodes as $node)
            {
                $return[] = new Content\Person($node);
            }
            return $return;
        }
        elseif ($entry->source && $entry->source->authors)
        {
            return $entry->source->authors;
        }
        elseif ($entry->feed && $entry->feed->authors)
        {
            return $entry->feed->authors;
        }
    }
    
    protected static function getter_rights($entry, $dom)
    {
        $nodes = \ComplexPie\Misc::xpath($dom, 'atom:rights', self::$element_namespaces);
        if ($nodes->length !== 0)
        {
            return \ComplexPie\Atom10\Content::from_text_construct($nodes->item(0));
        }
        elseif ($entry->feed && $entry->feed->rights)
        {
            return $entry->feed->rights;
        }
    }
}

Entry::add_static_extension('get', '\\ComplexPie\\Atom10\\links', ~PHP_INT_MAX);
