<?php
namespace ComplexPie\Content;

class Binary extends String
{
    protected $type;
    
    public function __construct($string, $type)
    {
        parent::__construct($string);
        $this->type = $type;
    }
    
    public function getType()
    {
        return $this->type;
    }
}
