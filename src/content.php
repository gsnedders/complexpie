<?php
namespace ComplexPie;

abstract class Content
{
    public static function from_textcontent($root)
    {
        return new Content\String($root->textContent);
    }
    
    public static function from_escaped_html($escaped_node)
    {
        $parser = new HTMLParser('<div>' . $escaped_node->textContent);
        $dom = $parser->parse();
        $dom->documentURI = $escaped_node->baseURI;
        $node = $dom->getElementsByTagName('div');
        $node = $node->item(0);
        return new Content\Node($node->childNodes);
    }
    
    abstract public function to_text();
    abstract public function to_xml();
    abstract public function to_html();
}
