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
        $elements = $dom->getElementsByTagName('*');
        foreach ($elements as $element)
        {
            $namespace = $element->namespaceURI ?: 'http://www.w3.org/1999/xhtml';
            $newElement = $dom->createElementNS($namespace, $element->localName);
            $element->parentNode->insertBefore($newElement, $element);
            $element->parentNode->removeChild($element);
            while ($element->firstChild)
            {
                $newElement->appendChild($element->firstChild);
            }
            foreach ($element->attributes as $attribute)
            {
                $newElement->setAttributeNode($attribute);
            }
        }
        return $dom;
    }
}
