<?php

require_once 'PHPUnit/Framework.php';
require_once '../src/simplepie.php';

class ContentTest extends PHPUnit_Framework_TestCase
{
    public function testFromChildTextContentBasicToText()
    {
        $dom = new \DOMDocument;
        $dom->loadXML('<foo>This is a test</foo>');
        $element = $dom->documentElement;
        $content = \ComplexPie\Content::from_textcontent($element);
        $this->assertSame('This is a test', $content->to_text());
    }
    
    public function testFromChildTextContentLessThanToText()
    {
        $dom = new \DOMDocument;
        $dom->loadXML('<foo>This is &lt;a&gt; test</foo>');
        $element = $dom->documentElement;
        $content = \ComplexPie\Content::from_textcontent($element);
        $this->assertSame('This is <a> test', $content->to_text());
    }
    
    public function testFromChildTextContentEntityToText()
    {
        $dom = new \DOMDocument;
        $dom->loadXML('<foo>This is a &amp;amp; test</foo>');
        $element = $dom->documentElement;
        $content = \ComplexPie\Content::from_textcontent($element);
        $this->assertSame('This is a &amp; test', $content->to_text());
    }
    
    public function testFromChildTextContentUFFFFToText()
    {
        $dom = new \DOMDocument;
        $dom->loadXML('<foo>This is a test</foo>');
        $element = $dom->documentElement;
        $element->firstChild->data = "This is a \xEF\xBF\xBF test";
        $content = \ComplexPie\Content::from_textcontent($element);
        $this->assertSame("This is a \xEF\xBF\xBD test", $content->to_text());
    }
    
    public function testFromChildTextContentBasicToXML()
    {
        $dom = new \DOMDocument;
        $dom2 = new \DOMDocument;
        $dom->loadXML('<foo>This is a test</foo>');
        $element = $dom->documentElement;
        $content = \ComplexPie\Content::from_textcontent($element);
        $xml = $content->to_xml();
        $this->assertTrue($dom2->loadXML("<foo>$xml</foo>"));
        $this->assertSame('This is a test', $xml);
    }
    
    public function testFromChildTextContentLessThanToXML()
    {
        $dom = new \DOMDocument;
        $dom2 = new \DOMDocument;
        $dom->loadXML('<foo>This is &lt;a&gt; test</foo>');
        $element = $dom->documentElement;
        $content = \ComplexPie\Content::from_textcontent($element);
        $xml = $content->to_xml();
        $this->assertTrue($dom2->loadXML("<foo>$xml</foo>"));
        $this->assertSame('This is &lt;a&gt; test', $xml);
    }
    
    public function testFromChildTextContentEntityToXML()
    {
        $dom = new \DOMDocument;
        $dom2 = new \DOMDocument;
        $dom->loadXML('<foo>This is a &amp;amp; test</foo>');
        $element = $dom->documentElement;
        $content = \ComplexPie\Content::from_textcontent($element);
        $xml = $content->to_xml();
        $this->assertTrue($dom2->loadXML("<foo>$xml</foo>"));
        $this->assertSame('This is a &amp;amp; test', $xml);
    }
    
    public function testFromChildTextContentUFFFFToXML()
    {
        $dom = new \DOMDocument;
        $dom2 = new \DOMDocument;
        $dom->loadXML('<foo>This is a test</foo>');
        $element = $dom->documentElement;
        $element->firstChild->data = "This is a \xEF\xBF\xBF test";
        $content = \ComplexPie\Content::from_textcontent($element);
        $xml = $content->to_xml();
        $this->assertTrue($dom2->loadXML("<foo>$xml</foo>"));
        $this->assertSame("This is a \xEF\xBF\xBD test", $xml);
    }
    
    public function testFromEscapedHTMLBasicToText()
    {
        $dom = new \DOMDocument;
        $dom->loadXML('<foo>This is a test</foo>');
        $element = $dom->documentElement;
        $content = \ComplexPie\Content::from_escaped_html($element);
        $this->assertSame('This is a test', $content->to_text());
    }
    
    public function testFromEscapedHTMLLessThanToText()
    {
        $dom = new \DOMDocument;
        $dom->loadXML('<foo>This is &lt;a&gt; test</foo>');
        $element = $dom->documentElement;
        $content = \ComplexPie\Content::from_escaped_html($element);
        $this->assertSame('This is  test', $content->to_text());
    }
    
    public function testFromEscapedHTMLAElementToText()
    {
        $dom = new \DOMDocument;
        $dom->loadXML('<foo>This is &lt;a href="http://example.com">test&lt;/a></foo>');
        $element = $dom->documentElement;
        $content = \ComplexPie\Content::from_escaped_html($element);
        $this->assertSame('This is test', $content->to_text());
    }
    
    public function testFromEscapedHTMLEntityToText()
    {
        $dom = new \DOMDocument;
        $dom->loadXML('<foo>This is a &amp;amp; test</foo>');
        $element = $dom->documentElement;
        $content = \ComplexPie\Content::from_escaped_html($element);
        $this->assertSame('This is a & test', $content->to_text());
    }
    
    public function testFromEscapedHTMLUFFFFToText()
    {
        $dom = new \DOMDocument;
        $dom->loadXML('<foo>This is a test</foo>');
        $element = $dom->documentElement;
        $element->firstChild->data = "This is a \xEF\xBF\xBF test";
        $content = \ComplexPie\Content::from_escaped_html($element);
        $this->assertSame("This is a \xEF\xBF\xBD test", $content->to_text());
    }
    
    public function testFromEscapedHTMLBasicToXML()
    {
        $dom = new \DOMDocument;
        $dom2 = new \DOMDocument;
        $dom->loadXML('<foo>This is a test</foo>');
        $element = $dom->documentElement;
        $content = \ComplexPie\Content::from_escaped_html($element);
        $xml = $content->to_xml();
        $this->assertTrue($dom2->loadXML("<foo>$xml</foo>"));
        $this->assertSame('This is a test', $xml);
    }
    
    public function testFromEscapedHTMLLessThanToXML()
    {
        $dom = new \DOMDocument;
        $dom2 = new \DOMDocument;
        $dom->loadXML('<foo>This is &lt;a&gt; test</foo>');
        $element = $dom->documentElement;
        $content = \ComplexPie\Content::from_escaped_html($element);
        $xml = $content->to_xml();
        $this->assertTrue($dom2->loadXML("<foo>$xml</foo>"));
        $this->assertSame('This is <a> test</a>', $xml);
    }
    
    public function testFromEscapedHTMLAElementToXML()
    {
        $dom = new \DOMDocument;
        $dom2 = new \DOMDocument;
        $dom->loadXML('<foo>This is &lt;a href="http://example.com">test&lt;/a></foo>');
        $element = $dom->documentElement;
        $content = \ComplexPie\Content::from_escaped_html($element);
        $xml = $content->to_xml();
        $this->assertTrue($dom2->loadXML("<foo>$xml</foo>"));
        $this->assertSame('This is <a href="http://example.com">test</a>', $xml);
    }
    
    public function testFromEscapedHTMLEntityToXML()
    {
        $dom = new \DOMDocument;
        $dom2 = new \DOMDocument;
        $dom->loadXML('<foo>This is a &amp;amp; test</foo>');
        $element = $dom->documentElement;
        $content = \ComplexPie\Content::from_escaped_html($element);
        $xml = $content->to_xml();
        $this->assertTrue($dom2->loadXML("<foo>$xml</foo>"));
        $this->assertSame('This is a &amp; test', $xml);
    }
    
    public function testFromEscapedHTMLUFFFFToXML()
    {
        $dom = new \DOMDocument;
        $dom2 = new \DOMDocument;
        $dom->loadXML('<foo>This is a test</foo>');
        $element = $dom->documentElement;
        $element->firstChild->data = "This is a \xEF\xBF\xBF test";
        $content = \ComplexPie\Content::from_escaped_html($element);
        $xml = $content->to_xml();
        $this->assertTrue($dom2->loadXML("<foo>$xml</foo>"));
        $this->assertSame("This is a \xEF\xBF\xBD test", $xml);
    }
}

?>