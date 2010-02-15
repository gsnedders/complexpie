<?php
namespace ComplexPie\Content;

class IRI extends \ComplexPie\Content
{
    protected $iri;
    
    public function __construct(\ComplexPie\IRI $iri)
    {
        $this->iri = $iri;
    }
    
    public function get_iri()
    {
        return $this->iri;
    }
    
    public function to_text()
    {
        return $this->iri->iri;
    }
    
    public function to_xml()
    {
        return htmlspecialchars($this->iri->iri, ENT_QUOTES, 'UTF-8');
    }
    
    public function to_html()
    {
        return htmlspecialchars($this->iri->iri, ENT_QUOTES, 'UTF-8');
    }
}
