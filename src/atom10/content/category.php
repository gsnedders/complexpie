<?php
namespace ComplexPie\Atom10\Content;

class Category
{
    protected $node;
    
    protected $term;
    protected $scheme;
    protected $label;
    
    public function __construct($node)
    {
        $this->node = $node;
        
        $terms = \ComplexPie\Misc::xpath($node, 'atom:term', array('atom' => \ComplexPie\Atom10\XMLNS));
        if ($terms->length)
        {
            $this->term = \ComplexPie\Content::from_textcontent($terms->item(0));
        }
        
        $schemes = \ComplexPie\Misc::xpath($node, 'atom:scheme', array('atom' => \ComplexPie\Atom10\XMLNS));
        if ($schemes->length)
        {
            $this->scheme = new \ComplexPie\Content\IRINode($schemes->item(0));
        }
        
        $labels = \ComplexPie\Misc::xpath($node, 'atom:label', array('atom' => \ComplexPie\Atom10\XMLNS));
        if ($labels->length)
        {
            $this->label = \ComplexPie\Content::from_textcontent($labels->item(0));
        }
    }
    
    public function __get($term)
    {
        if (
            $term === 'term' ||
            $term === 'scheme' ||
            $term === 'label'
        )
        {
            return $this->$term;
        }
    }
}
