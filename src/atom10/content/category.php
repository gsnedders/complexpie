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
        
        if ($node->hasAttribute('term'))
        {
            $this->term = \ComplexPie\Content::from_textcontent($node->getAttributeNode('term'));
            // And default the label to the term
            $this->label = $this->term;
        }
        
        if ($node->hasAttribute('scheme'))
        {
            $this->scheme = new \ComplexPie\Content\IRINode($node->getAttributeNode('scheme'));
        }
        
        if ($node->hasAttribute('label'))
        {
            $this->label = \ComplexPie\Content::from_textcontent($node->getAttributeNode('label'));
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
