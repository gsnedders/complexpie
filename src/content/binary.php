<?php
namespace ComplexPie\Content;

class Binary extends \ComplexPie\Content
{
    protected $data;
    
    public function __construct($data)
    {
        $this->data = $data;
    }
    
    public function get_data()
    {
        return $this->data;
    }
    
    public function to_text()
    {
        throw new \Exception('Binary data cannot be serialized');
    }
    
    public function to_xml()
    {
        throw new \Exception('Binary data cannot be serialized');
    }
    
    public function to_html()
    {
        throw new \Exception('Binary data cannot be serialized');
    }
}
