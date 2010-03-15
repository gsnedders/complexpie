<?php
namespace ComplexPie\RSS20\Content;

class Image extends \ComplexPie\XML\Data
{
    protected $dom;
    
    protected static $static_ext = array();

    protected static $aliases = array();
    
    protected static $elements = array(
        'link' => array(
            'element' => 'link',
            'contentConstructor' => 'ComplexPie\\Content\\IRINode',
            'single' => true
        ),
        'title' => array(
            'element' => 'title',
            'contentConstructor' => 'ComplexPie\\Content::from_textcontent',
            'single' => true
        ),
        'url' => array(
            'element' => 'url',
            'contentConstructor' => 'ComplexPie\\Content\\IRINode',
            'single' => true
        ),
        'description' => array(
            'element' => 'description',
            'contentConstructor' => 'ComplexPie\\Content::from_textcontent',
            'single' => true
        ),
    );
    
    protected static $element_namespaces = array();
    
    protected static function getter_height($feed, $dom)
    {
        $nodes = \ComplexPie\Misc::xpath($dom, 'height');
        if ($nodes->length !== 0)
        {
            return (double) $nodes->item(0)->textContent;
        }
        else
        {
            return 31.0;
        }
    }
    
    protected static function getter_width($feed, $dom)
    {
        $nodes = \ComplexPie\Misc::xpath($dom, 'width');
        if ($nodes->length !== 0)
        {
            return (double) $nodes->item(0)->textContent;
        }
        else
        {
            return 88.0;
        }
    }
    
    public function __construct($dom)
    {
        $this->dom = $dom;
        parent::__construct();
    }
}