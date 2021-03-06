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
        $content = $escaped_node->textContent;
        if (strcspn($content, '<&') === strlen($content))
        {
            return new Content\String($content);
        }
        else
        {
            $data = sprintf('<meta http-equiv="content-type" content="text/html;charset=utf-8"><base href="%s"><div>%s', htmlspecialchars($escaped_node->baseURI, ENT_QUOTES, 'UTF-8'), $content);
            $parser = new HTMLParser($data);
            $dom = $parser->parse();
            $node = $dom->getElementsByTagName('div')->item(0);
            return new Content\Node($node->childNodes);
        }
    }
    
    public static function from_date_in_textcontent($node)
    {
        return Parse_Date::parse($node->textContent);
    }
    
    abstract public function to_text();
    abstract public function to_xml();
    abstract public function to_html();
}
