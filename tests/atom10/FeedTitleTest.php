<?php

require_once dirname(__FILE__) . '/TextConstructTest.php';
require_once dirname(__FILE__) . '/../../src/complexpie.php';

class FeedTitleTest extends TextConstructTest
{
    protected function getContent($input)
    {
        $input = sprintf("<feed xmlns='http://www.w3.org/2005/Atom'>$input</feed>", 'title');
        $feed = \ComplexPie\ComplexPie($input);
        return $feed->title;
    }
    
    public function testNoTitle()
    {
        $input = '<feed xmlns="http://www.w3.org/2005/Atom"></feed>';
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame(null, $feed->title);
    }
    
    public function titlePriorityData()
    {
        return array(
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title>PASS</title>
    <title>FAIL</title>
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
     * @dataProvider titlePriorityData
     */
    public function testTitlePriority($input)
    {
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame('PASS', $feed->title->to_text());
    }
        
    public function htmlTitleData()
    {
        return array(
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
        
    public function xhtmlTitleData()
    {
        return array(
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom" xml:base="http://example.com">
    <title type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></title>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <link href="http://example.com"/>
    <title type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></title>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <title type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></title>
    <link href="http://example.com"/>
</feed>
EOF
            ),
        );
    }
    
    /**
     * @dataProvider xhtmlTitleData
     */
    public function testXhtmlTitle($input)
    {
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame('<a href="http://example.com">Test</a>', $feed->title->to_html());
    }
}

?>
