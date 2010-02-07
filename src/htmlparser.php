<?php
namespace ComplexPie;

class HTMLParser
{
    private $data;
    
    public function __construct($data)
    {
        $this->data = (string) $data;
    }
    
    public function parse()
    {
        $dom = new \DOMDocument;
        @$dom->loadHTML($this->data);
        return $dom;
    }
}
