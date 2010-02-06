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
        elseif ($this->node->parentNode &&
                $this->node->parentNode !== $this->root &&
                $this->node->parentNode->nextSibling)
        {
            $this->node = $this->node->parentNode->nextSibling;
        }
        else
        {
            $this->node = null;
        }
    }
    
    public function valid()
    {
        return $this->node;
    }
}
