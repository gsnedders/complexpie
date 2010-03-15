<?php
namespace ComplexPie\RSS20\Content;

class Category extends \ComplexPie\Content\Node
{
    protected $domain;
    
    public function __construct($node)
    {
        parent::__construct($node);
        
        if ($node->hasAttribute('domain'))
        {
            $this->domain = \ComplexPie\Content::from_textcontent($node->getAttributeNode('domain'));
        }
    }
    
    public function __get($term)
    {
        if ($term === 'domain')
        {
            return $this->domain;
        }
    }
}
