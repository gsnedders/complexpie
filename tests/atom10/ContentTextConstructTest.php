<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../src/complexpie.php';

class Atom10_ContentTextConstructTest extends PHPUnit_Framework_TestCase
{
    protected function getContent($input)
    {
        $dom = new \DOMDocument;
        $dom->loadXML($input);
        $element = $dom->documentElement;
        return \ComplexPie\Atom10\Content::from_text_construct($element);
    }

    public function basicData()
    {
        return array(
            array('<foobar>PASS</foobar>'),
            array('<foobar type="image/gif">PASS</foobar>'),
        );
    }
    
    /**
     * @dataProvider basicData
     */
    public function testBasic($input)
    {
        $this->assertSame('PASS', $this->getContent($input)->to_text());
    }
    
    public function testEmpty()
    {
        $this->assertSame('', $this->getContent('<foobar/>')->to_text());
    }
    
    public function looksLikeHtmlData()
    {
        return array(
            array('<foobar>&lt;a href="http://example.com">Test&lt;/a></foobar>'),
            array('<foobar>&#x3C;a href="http://example.com">Test&#x3C;/a></foobar>'),
            array('<foobar><![CDATA[<a href="http://example.com">Test</a>]]></foobar>'),
            array('<foobar type="HTML">&lt;a href="http://example.com">Test&lt;/a></foobar>'),
            array('<foobar type="htMl">&lt;a href="http://example.com">Test&lt;/a></foobar>'),
            array('<foobar type=" html ">&lt;a href="http://example.com">Test&lt;/a></foobar>'),
            array('<foobar type="htm">&lt;a href="http://example.com">Test&lt;/a></foobar>'),
            array('<foobar type="text/html">&lt;a href="http://example.com">Test&lt;/a></foobar>'),
            array('<foobar type="totallybogus">&lt;a href="http://example.com">Test&lt;/a></foobar>'),
        );
    }
    
    /**
     * @dataProvider looksLikeHtmlData
     */
    public function testLooksLikeHtml($input)
    {
        $this->assertSame('<a href="http://example.com">Test</a>', $this->getContent($input)->to_text());
    }
    
    public function htmlData()
    {
        return array(
            array('<foobar type="html">&lt;a href="http://example.com">Test&lt;/a></foobar>'),
            array('<foobar type="html">&#x3C;a href="http://example.com">Test&#x3C;/a></foobar>'),
            array('<foobar type="html"><![CDATA[<a href="http://example.com">Test</a>]]></foobar>'),
            array('<foobar type="html" xml:base="http://example.com">&lt;a href="/">Test&lt;/a></foobar>'),
        );
    }
    
    /**
     * @dataProvider htmlData
     */
    public function testHtml($input)
    {
        $this->assertSame('<a href="http://example.com">Test</a>', $this->getContent($input)->to_html());
    }
    
    public function testHtmlInDiv()
    {
        $input = '<foobar type="html" xml:base="http://example.com">&lt;div>&lt;a href="/">Test&lt;/a>&lt;/div></foobar>';
        $this->assertSame('<div><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_html());
    }
    
    public function looksLikeXhtmlData()
    {
        return array(
            array('<foobar><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
            array('<foobar type="XHTML"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
            array('<foobar type="xhtMl"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
            array('<foobar type=" xhtml "><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
            array('<foobar type="xht"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
            array('<foobar type="application/xml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
            array('<foobar type="text/xml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
            array('<foobar type="image/xml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
            array('<foobar type="application/xhtml+xml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
            array('<foobar type="image/svg+xml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
            array('<foobar type="x-foo/bar+xml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
            array('<foobar type="totallybogus"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
        );
    }
    
    /**
     * @dataProvider looksLikeXhtmlData
     */
    public function testLooksLikeXhtml($input)
    {
        $this->assertSame('Test', $this->getContent($input)->to_xml());
    }

    public function xhtmlData()
    {
        return array(
            array('<foobar type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
            array('<foobar type="xhtml" xml:base="http://example.com"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></foobar>'),
            array(
<<<EOF
<foobar type="xhtml">
    <div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>
</foobar>
EOF
            ),
            array(
<<<EOF
<foobar type="xhtml">
    <div xmlns="http://www.w3.org/1999/xhtml">
        <a href="http://example.com">Test</a>
    </div>
</foobar>
EOF
            ),
            array('<foobar type="xhtml">&#x20;<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>&#x20;</foobar>'),
            array('<foobar type="xhtml"><!--foo--><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
        );
    }
    
    /**
     * @dataProvider xhtmlData
     */
    public function testXhtml($input)
    {
        $this->assertSame('<a href="http://example.com">Test</a>', $this->getContent($input)->to_html());
    }

    public function escapedXhtmlData()
    {
        return array(
            array('<foobar type="xhtml">&lt;div xmlns="http://www.w3.org/1999/xhtml">&lt;a href="http://example.com">Test&lt;/a>&lt;/div></foobar>'),
            array('<foobar type="xhtml">&#x3C;div xmlns="http://www.w3.org/1999/xhtml">&#x3C;a href="http://example.com">Test&#x3C;/a>&#x3C;/div></foobar>'),
            array('<foobar type="xhtml"><![CDATA[<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>]]></foobar>'),
        );
    }
    
    /**
     * @dataProvider escapedXhtmlData
     */
    public function testEscapedXhtml($input)
    {
        $this->assertSame('<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_text());
    }
    
    public function testXhtmlImportantWhitespace()
    {
        $input = '<foobar type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><span>Hello,</span> <span>world!</span></div></foobar>';
        $this->assertSame('<span>Hello,</span> <span>world!</span>', $this->getContent($input)->to_html());
    }
    
    public function testXhtmlOnlyWhitespace()
    {
        $input = '<foobar type="xhtml"> </foobar>';
        $this->assertSame('', $this->getContent($input)->to_html());
    }
    
    public function testXhtmlOnlyComment()
    {
        $input = '<foobar type="xhtml"><!--foo--></foobar>';
        $this->assertSame('<!--foo-->', $this->getContent($input)->to_html());
    }
    
    public function testXhtmlMultipleDiv()
    {
        $input = '<foobar type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>';
        $this->assertSame('<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_html());
    }
    
    public function testXhtmlDivAfterText()
    {
        $input = '<foobar type="xhtml">foobar<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>';
        $this->assertSame('foobar<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_html());
    }
    
    public function testXhtmlDivBeforeText()
    {
        $input = '<foobar type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>foobar</foobar>';
        $this->assertSame('<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>foobar', $this->getContent($input)->to_html());
    }
    
    public function testXhtmlDivAfterTextStartingWithWhitespace()
    {
        $input = '<foobar type="xhtml">foobar<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>';
        $this->assertSame('foobar<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_html());
    }
    
    public function testXhtmlDivBeforeTextStartingWithWhitespace()
    {
        $input = '<foobar type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div> foobar</foobar>';
        $this->assertSame('<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div> foobar', $this->getContent($input)->to_html());
    }
    
    public function testXhtmlDivAfterCDATA()
    {
        $input = '<foobar type="xhtml"><![CDATA[foobar]]><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>';
        $this->assertSame('<![CDATA[foobar]]><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_xml());
    }
    
    public function testXhtmlDivBeforeCDATA()
    {
        $input = '<foobar type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><![CDATA[foobar]]></foobar>';
        $this->assertSame('<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><![CDATA[foobar]]>', $this->getContent($input)->to_xml());
    }
    
    public function testXhtmlDivAfterCDATAStartingWithWhitespace()
    {
        $input = '<foobar type="xhtml"><![CDATA[foobar]]><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>';
        $this->assertSame('<![CDATA[foobar]]><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_xml());
    }
    
    public function testXhtmlDivBeforeCDATAStartingWithWhitespace()
    {
        $input = '<foobar type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><![CDATA[ foobar]]></foobar>';
        $this->assertSame('<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><![CDATA[ foobar]]>', $this->getContent($input)->to_xml());
    }
    
    public function testXhtmlDivAfterPI()
    {
        $input = '<foobar type="xhtml"><?foo?><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>';
        $this->assertSame('<?foo?><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_xml());
    }
    
    public function testXhtmlDivBeforePI()
    {
        $input = '<foobar type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><?foo?></foobar>';
        $this->assertSame('<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><?foo?>', $this->getContent($input)->to_xml());
    }
}

?>
