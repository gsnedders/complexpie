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
    protected $nodes;
    
    public function __construct($nodes)
    {
        if ($nodes instanceof \DOMNodeList)
        {
            $new_node = array();
            foreach ($nodes as $n)
                $new_node[] = $n;
            $nodes = $new_node;
        }
        if (!is_array($nodes))
        {
            $nodes = array($nodes);
        }
        $this->nodes = $nodes;
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
            $document = $node instanceof \DOMDocument ? $node : $node->ownerDocument;
            $xml .= $document->saveXML($node);
        }
        return $xml;
    }
    
    public function to_html()
    {
        $html = '';
        foreach ($this->nodes as $node)
        {
            $html .= \ComplexPie\nodeToHTML($node);
        }
        return $html;
    }
}
