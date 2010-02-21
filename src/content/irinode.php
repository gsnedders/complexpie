<?php
namespace ComplexPie\Content;

class IRINode extends \ComplexPie\Content
{
    protected $node;
    protected $iri;
    
    public function __construct($node)
    {
        $this->node = $node;
        
        $iriref = new \ComplexPie\IRI($node->textContent);
        if ($iri = \ComplexPie\IRI::absolutize($node->baseURI, $iriref))
            $iriref = $iri;
        $this->iri = $iriref;
    }
    
    public function get_node()
    {
        return $this->node;
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
