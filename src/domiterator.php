<?php
namespace ComplexPie;

class DOMIterator implements \Iterator
{
    private $root;
    private $node;
    private $position = 0;
    
    public function __construct(\DOMNode $root)
    {
        $this->root = $root;
        $this->rewind();
    }
    
    public function rewind()
    {
        $this->position = 0;
        $this->node = $this->root;
    }
    
    public function current()
    {
        return $this->node;
    }
    
    public function key()
    {
        return $this->position;
    }
    
    public function next()
    {
        $this->position++;
        if ($this->node->firstChild)
        {
            $this->node = $this->node->firstChild;
        }
        elseif ($this->node->nextSibling)
        {
            $this->node = $this->node->nextSibling;
        }
        else
        {
            $parent = $this->node;
            while (($parent = $parent->parentNode) &&
                   $parent !== $this->root)
            {
                if ($parent->nextSibling)
                {
                    $this->node = $parent->nextSibling;
                    return;
                }
            }
            $this->node = null;
        }
    }
    
    public function valid()
    {
        return $this->node;
    }
}
