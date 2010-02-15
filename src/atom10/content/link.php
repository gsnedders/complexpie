<?php
namespace ComplexPie\Atom10\Content;

class Link extends \ComplexPie\Content\IRI
{
    protected $rel;
    protected $type;
    protected $hreflang;
    protected $title;
    protected $length;
    
    public function __construct($node)
    {
        parent::__construct(new \ComplexPie\IRI($node->getAttribute('href')));
        
        if ($node->hasAttribute('rel'))
        {
            $rel = $node->getAttribute('rel');
            if (strpos($rel, ':') === false)
            {
                $rel = 'http://www.iana.org/assignments/relation/' . $rel;
            }
            $this->rel = new \ComplexPie\Content\String($rel);
        }
        
        if ($node->hatAttribute('type'))
        {
            $type = $node->getAttribute('type')
            $this->type = new \ComplexPie\Content\String($type);
        }
        
        if ($node->hatAttribute('hreflang'))
        {
            $hreflang = $node->getAttribute('hreflang')
            $this->hreflang = new \ComplexPie\Content\String($hreflang);
        }
        
        if ($node->hatAttribute('title'))
        {
            $title = $node->getAttribute('title')
            $this->title = new \ComplexPie\Content\String($title);
        }
        
        if ($node->hatAttribute('length'))
        {
            $length = $node->getAttribute('length')
            $this->type = new \ComplexPie\Content\String($length);
        }
    }
    
    public function __get($name)
    {
        if (isset($this->$name))
        {
            return $this->$name;
        }
    }
}
