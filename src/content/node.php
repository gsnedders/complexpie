<?php
namespace ComplexPie\Content;

class Node extends \ComplexPie\Content
{
    public static $replaceURLAttributes = array(
        'a' => array('href'),
        'area' => array('href'),
        'blockquote' => array('cite'),
        'del' => array('cite'),
        'form' => array('action'),
        'img' => array('longdesc', 'src'),
        'input' => array('src'),
        'ins' => array('cite'),
        'q' => array('cite')
    );
    
    protected $nodes = array();
    protected $document;
    
    public function __construct($nodes)
    {
        if ($nodes instanceof \DOMNodeList)
        {
            foreach ($nodes as $node)
                $this->nodes[] = $node;
        }
        elseif (is_array($nodes))
        {
            $this->nodes = $nodes;
        }
        else
        {
            $this->nodes = array($nodes);
        }
        $this->document = $this->nodes[0] instanceof \DOMDocument ? $this->nodes[0] : $this->nodes[0]->ownerDocument;
        $this->replaceURLs();
    }
    
    protected function replaceURLs()
    {
        $replaceURLAttributes = self::$replaceURLAttributes;
        foreach ($this->nodes as $node)
        {
            if ($node->nodeType === XML_ELEMENT_NODE)
            {
                $children = $node->getElementsByTagName('*');
                foreach ($children as $child)
                {
                    if (isset($replaceURLAttributes[$child->tagName]))
                    {
                        foreach ($replaceURLAttributes[$child->tagName] as $attribute)
                        {
                            if ($child->hasAttribute($attribute))
                            {
                                $newValue = \ComplexPie\IRI::absolutize($child->baseURI, $child->getAttribute($attribute));
                                if ($newValue)
                                {
                                    $child->setAttribute($attribute, $newValue->iri);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    
    public function get_node()
    {
        return $this->nodes;
    }
    
    public function to_text()
    {
        $text = '';
        foreach ($this->nodes as $node)
        {
            $text .= $node->textContent;
        }
        return $text;
    }
    
    public function to_xml()
    {
        $xml = '';
        foreach ($this->nodes as $node)
        {
            $xml .= $this->document->saveXML($node);
        }
        return $xml;
    }
    
    public function to_html()
    {
        $html = '';
        foreach ($this->nodes as $node)
        {
            $html .= \ComplexPie\nodeToHTML($node);
            // If http://pastebin.ca/1792855 makes it in, we can just do:
            // $html .= $this->document->saveHTML($node);
        }
        return $html;
    }
}
