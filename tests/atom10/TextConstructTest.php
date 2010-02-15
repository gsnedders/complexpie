<?php

require_once 'PHPUnit/Framework.php';

abstract class TextConstructTest extends PHPUnit_Framework_TestCase
{
    abstract protected function getContent($input);
    
    public function basicData()
    {
        return array(
            array('<%1$s>PASS</%1$s>'),
            array('<%1$s type="image/gif">PASS</%1$s>'),
            array(
<<<EOF
<%1\$s>PASS</%1\$s>
<foo xmlns="http://example.com">
    <%1\$s>FAIL</%1\$s>
</foo>
EOF
            ),
            array(
<<<EOF
<foo xmlns="http://example.com">
    <%1\$s>FAIL</%1\$s>
</foo>
<%1\$s>PASS</%1\$s>
EOF
            ),
            array(
<<<EOF
<%1\$s>PASS</%1\$s>
<foo:bar xmlns:foo="http://example.com">
    <%1\$s>FAIL</%1\$s>
</foo:bar>
EOF
            ),
            array(
<<<EOF
<foo:bar xmlns:foo="http://example.com">
    <%1\$s>FAIL</%1\$s>
</foo:bar>
<%1\$s>PASS</%1\$s>
EOF
            ),
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
        $this->assertSame('', $this->getContent('<%1$s/>')->to_text());
    }
    
    public function looksLikeHtmlData()
    {
        return array(
            array('<%1$s>&lt;a href="http://example.com">Test&lt;/a></%1$s>'),
            array('<%1$s>&#x3C;a href="http://example.com">Test&#x3C;/a></%1$s>'),
            array('<%1$s><![CDATA[<a href="http://example.com">Test</a>]]></%1$s>'),
            array('<%1$s type="HTML">&lt;a href="http://example.com">Test&lt;/a></%1$s>'),
            array('<%1$s type="htMl">&lt;a href="http://example.com">Test&lt;/a></%1$s>'),
            array('<%1$s type=" html ">&lt;a href="http://example.com">Test&lt;/a></%1$s>'),
            array('<%1$s type="htm">&lt;a href="http://example.com">Test&lt;/a></%1$s>'),
            array('<%1$s type="text/html">&lt;a href="http://example.com">Test&lt;/a></%1$s>'),
            array('<%1$s type="totallybogus">&lt;a href="http://example.com">Test&lt;/a></%1$s>'),
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
            array('<%1$s type="html">&lt;a href="http://example.com">Test&lt;/a></%1$s>'),
            array('<%1$s type="html">&#x3C;a href="http://example.com">Test&#x3C;/a></%1$s>'),
            array('<%1$s type="html"><![CDATA[<a href="http://example.com">Test</a>]]></%1$s>'),
            array('<%1$s type="html" xml:base="http://example.com">&lt;a href="/">Test&lt;/a></%1$s>'),
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
        $input = '<%1$s type="html" xml:base="http://example.com">&lt;div>&lt;a href="/">Test&lt;/a>&lt;/div></%1$s>';
        $this->assertSame('<div><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_html());
    }
    
    public function looksLikeXhtmlData()
    {
        return array(
            array('<%1$s><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></%1$s>'),
            array('<%1$s type="XHTML"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></%1$s>'),
            array('<%1$s type="xhtMl"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></%1$s>'),
            array('<%1$s type=" xhtml "><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></%1$s>'),
            array('<%1$s type="xht"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></%1$s>'),
            array('<%1$s type="application/xml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></%1$s>'),
            array('<%1$s type="text/xml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></%1$s>'),
            array('<%1$s type="image/xml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></%1$s>'),
            array('<%1$s type="application/xhtml+xml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></%1$s>'),
            array('<%1$s type="image/svg+xml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></%1$s>'),
            array('<%1$s type="x-foo/bar+xml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></%1$s>'),
            array('<%1$s type="totallybogus"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></%1$s>'),
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
            array('<%1$s type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></%1$s>'),
            array('<%1$s type="xhtml" xml:base="http://example.com"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></%1$s>'),
            array(
<<<EOF
<%1\$s type="xhtml">
    <div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>
</%1\$s>
EOF
            ),
            array(
<<<EOF
<%1\$s type="xhtml">
    <div xmlns="http://www.w3.org/1999/xhtml">
        <a href="http://example.com">Test</a>
    </div>
</%1\$s>
EOF
            ),
            array('<%1$s type="xhtml">&#x20;<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>&#x20;</%1$s>'),
            array('<%1$s type="xhtml"><!--foo--><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></%1$s>'),
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
            array('<%1$s type="xhtml">&lt;div xmlns="http://www.w3.org/1999/xhtml">&lt;a href="http://example.com">Test&lt;/a>&lt;/div></%1$s>'),
            array('<%1$s type="xhtml">&#x3C;div xmlns="http://www.w3.org/1999/xhtml">&#x3C;a href="http://example.com">Test&#x3C;/a>&#x3C;/div></%1$s>'),
            array('<%1$s type="xhtml"><![CDATA[<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>]]></%1$s>'),
        );
    }
    
    /**
     * @dataProvider escapedXhtmlData
     */
    public function testEscapedXhtml($input)
    {
        $this->assertSame('<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_text());
    }
    
    public function testXhtmlOnlyWhitespace()
    {
        $input = '<%1$s type="xhtml"> </%1$s>';
        $this->assertSame('', $this->getContent($input)->to_html());
    }
    
    public function testXhtmlOnlyComment()
    {
        $input = '<%1$s type="xhtml"><!--foo--></%1$s>';
        $this->assertSame('<!--foo-->', $this->getContent($input)->to_html());
    }
    
    public function testXhtmlMultipleDiv()
    {
        $input = '<%1$s type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></%1$s>';
        $this->assertSame('<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_html());
    }
    
    public function testXhtmlDivAfterText()
    {
        $input = '<%1$s type="xhtml">foobar<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></%1$s>';
        $this->assertSame('foobar<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_html());
    }
    
    public function testXhtmlDivBeforeText()
    {
        $input = '<%1$s type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>foobar</%1$s>';
        $this->assertSame('<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>foobar', $this->getContent($input)->to_html());
    }
    
    public function testXhtmlDivAfterTextStartingWithWhitespace()
    {
        $input = '<%1$s type="xhtml">foobar<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></%1$s>';
        $this->assertSame('foobar<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_html());
    }
    
    public function testXhtmlDivBeforeTextStartingWithWhitespace()
    {
        $input = '<%1$s type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div> foobar</%1$s>';
        $this->assertSame('<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div> foobar', $this->getContent($input)->to_html());
    }
    
    public function testXhtmlDivAfterCDATA()
    {
        $input = '<%1$s type="xhtml"><![CDATA[foobar]]><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></%1$s>';
        $this->assertSame('<![CDATA[foobar]]><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_xml());
    }
    
    public function testXhtmlDivBeforeCDATA()
    {
        $input = '<%1$s type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><![CDATA[foobar]]></%1$s>';
        $this->assertSame('<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><![CDATA[foobar]]>', $this->getContent($input)->to_xml());
    }
    
    public function testXhtmlDivAfterCDATAStartingWithWhitespace()
    {
        $input = '<%1$s type="xhtml"><![CDATA[foobar]]><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></%1$s>';
        $this->assertSame('<![CDATA[foobar]]><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_xml());
    }
    
    public function testXhtmlDivBeforeCDATAStartingWithWhitespace()
    {
        $input = '<%1$s type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><![CDATA[ foobar]]></%1$s>';
        $this->assertSame('<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><![CDATA[ foobar]]>', $this->getContent($input)->to_xml());
    }
    
    public function testXhtmlDivAfterPI()
    {
        $input = '<%1$s type="xhtml"><?foo?><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></%1$s>';
        $this->assertSame('<?foo?><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_xml());
    }
    
    public function testXhtmlDivBeforePI()
    {
        $input = '<%1$s type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><?foo?></%1$s>';
        $this->assertSame('<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><?foo?>', $this->getContent($input)->to_xml());
    }
}

?>
