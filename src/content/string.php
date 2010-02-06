<?php
namespace ComplexPie\Content;

class String extends \ComplexPie\Content
{
    protected $string;
    
    public function __construct($string)
    {
        $this->string = $string;
    }
    
    public function to_text()
    {
        return $this->string;
    }
    
    public function to_xml()
    {
        return htmlspecialchars($this->string, ENT_QUOTES, 'UTF-8');
    }
    
    public function to_html()
    {
        return htmlspecialchars($this->string, ENT_QUOTES, 'UTF-8');
    }
}
