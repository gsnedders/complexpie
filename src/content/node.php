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
    protected $node;
    
    public function __construct($node)
    {
        if ($node instanceof \DOMNodeList)
        {
            $new_node = array();
            foreach ($node as $n)
                $new_node[] = $n;
            $node = $new_node;
        }
        if (is_array($node) && count($node) === 1)
        {
            $node = $node[0];
        }
        $this->node = $node;
        $this->replaceURLs();
    }
    
    protected function replaceURLs()
    {
        $nodes = (is_array($this->node)) ? $this->node : array($this->node);
        $replaceURLAttributes = self::$replaceURLAttributes;
        foreach ($nodes as $node)
        {
            if ($node->nodeType === XML_ELEMENT_NODE)
            {
                $children = $node->getElementsByTagName('*');
                foreach ($children as $child)
                {
                    if (isset($replaceURLAttributes[$child->tagName]))
                    {
                        $attributes = $replaceURLAttributes[$child->tagName];
                        foreach ($attributes as $attribute)
                        {
                            if ($child->hasAttribute($attribute))
                            {
                                $newValue = \ComplexPie\IRI::absolutize($child->baseURI, $child->getAttribute($attribute));
                                if ($newValue)
                                {
                                    //var_dump($newValue->iri);
                                    $child->setAttribute($attribute, $newValue->iri);
                                }
                                /*else
                                {
                                    var_dump(1);
                                    var_dump($document->documentURI);
                                    var_dump($e->baseURI);
                                    var_dump($document->saveXML());
                                }*/
                            }
                        }
                    }
                }
            }
        }
    }
    
    public function get_node()
    {
        return $this->node;
    }
    
    public function to_text()
    {
        if (is_array($this->node))
        {
            $text = '';
            foreach ($this->node as $node)
            {
                $text .= $node->textContent;
            }
            return $text;
        }
        else
        {
            return $this->node->textContent;
        }
    }
    
    public function to_xml()
    {
        if (is_array($this->node))
        {
            $xml = '';
            foreach ($this->node as $node)
            {
                $document = $node instanceof \DOMDocument ? $node : $node->ownerDocument;
                $xml .= $document->saveXML($node);
            }
            return $xml;
        }
        else
        {
            $document = $this->node instanceof \DOMDocument ? $this->node : $this->node->ownerDocument;
            return $document->saveXML($this->node);
        }
    }
    
    public function to_html()
    {
        $nodes = (is_array($this->node)) ? $this->node : array($this->node);
        $html = '';
        foreach ($nodes as $node)
        {
            $html .= \ComplexPie\nodeToHTML($node);
        }
        return $html;
    }
}
