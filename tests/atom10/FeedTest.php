<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../src/complexpie.php';

class FeedTest extends PHPUnit_Framework_TestCase
{
    public function testNoTitle()
    {
        $input = '<feed xmlns="http://www.w3.org/2005/Atom"></feed>';
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame(null, $feed->title);
    }
    
    public function basicTitleData()
    {
        return array(
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title>PASS</title>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title>PASS</title>
    <foo xmlns="http://example.com">
        <title>FAIL</title>
    </foo>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <foo xmlns="http://example.com">
        <title>FAIL</title>
    </foo>
    <title>PASS</title>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title>PASS</title>
    <foo:bar xmlns:foo="http://example.com">
        <title>FAIL</title>
    </foo:bar>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <foo:bar xmlns:foo="http://example.com">
        <title>FAIL</title>
    </foo:bar>
    <title>PASS</title>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title>PASS</title>
    <title xmlns="http://purl.org/atom/ns#">FAIL</title>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title xmlns="http://purl.org/atom/ns#">FAIL</title>
    <title>PASS</title>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title>PASS</title>
    <title xmlns="http://purl.org/rss/1.0/">FAIL</title>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title xmlns="http://purl.org/rss/1.0/">FAIL</title>
    <title>PASS</title>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title>PASS</title>
    <title xmlns="http://my.netscape.com/rdf/simple/0.9/">FAIL</title>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title xmlns="http://my.netscape.com/rdf/simple/0.9/">FAIL</title>
    <title>PASS</title>
</feed>
EOF
            ),
        );
    }
    
    /**
     * @dataProvider basicTitleData
     */
    public function testBasicTitle($input)
    {
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame('PASS', $feed->title->to_text());
    }
    
    public function looksLikeHtmlTitleData()
    {
        return array(
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title>&lt;a href="http://example.com">Test&lt;/a></title>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title>&#x3C;a href="http://example.com">Test&#x3C;/a></title>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title><![CDATA[<a href="http://example.com">Test</a>]]></title>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title type="HTML">&lt;a href="http://example.com">Test&lt;/a></title>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title type="htMl">&lt;a href="http://example.com">Test&lt;/a></title>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title type=" html ">&lt;a href="http://example.com">Test&lt;/a></title>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title type="htm">&lt;a href="http://example.com">Test&lt;/a></title>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title type="totallybogus">&lt;a href="http://example.com">Test&lt;/a></title>
</feed>
EOF
            ),
        );
    }
    
    /**
     * @dataProvider looksLikeHtmlTitleData
     */
    public function testLooksLikeHtmlTitle($input)
    {
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame('<a href="http://example.com">Test</a>', $feed->title->to_text());
    }
    
    public function htmlTitleData()
    {
        return array(
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title type="html">&lt;a href="http://example.com">Test&lt;/a></title>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title type="html">&#x3C;a href="http://example.com">Test&#x3C;/a></title>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title type="html"><![CDATA[<a href="http://example.com">Test</a>]]></title>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title type="html" xml:base="http://example.com">&lt;a href="/">Test&lt;/a></title>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom" xml:base="http://example.com">
    <title type="html">&lt;a href="/">Test&lt;/a></title>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <link href="http://example.com"/>
    <title type="html">&lt;a href="/">Test&lt;/a></title>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title type="html">&lt;a href="/">Test&lt;/a></title>
    <link href="http://example.com"/>
</feed>
EOF
            ),
        );
    }
    
    /**
     * @dataProvider htmlTitleData
     */
    public function testHtmlTitle($input)
    {
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame('<a href="http://example.com">Test</a>', $feed->title->to_html());
    }
    
    public function testHtmlInDivTitle()
    {
        $input = <<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title type="html" xml:base="http://example.com">&lt;div>&lt;a href="/">Test&lt;/a>&lt;/div></title>
</feed>
EOF;
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame('<div><a href="http://example.com">Test</a></div>', $feed->title->to_html());
    }
}

?>
