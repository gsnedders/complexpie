<?php
namespace ComplexPie;

class Category
{
    private $term;
    private $scheme;
    private $label;

    // Constructor, used to input the data
    public function __construct($term = null, $scheme = null, $label = null)
    {
        $this->term = $term;
        $this->scheme = $scheme;
        $this->label = $label;
    }

    public function __toString()
    {
        // There is no $this->data here
        return md5(serialize($this));
    }

    public function get_term()
    {
        if ($this->term !== null)
        {
            return $this->term;
        }
        else
        {
            return null;
        }
    }

    public function get_scheme()
    {
        if ($this->scheme !== null)
        {
            return $this->scheme;
        }
        else
        {
            return null;
        }
    }

    public function get_label()
    {
        if ($this->label !== null)
        {
            return $this->label;
        }
        else
        {
            return $this->get_term();
        }
    }
    
    public function __get($name)
    {
        if (method_exists($this, "get_$name"))
        {
            return $this->{"get_$name"}();
        }
    }
}
