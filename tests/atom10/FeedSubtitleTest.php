<?php

require_once dirname(__FILE__) . '/TextConstructTest.php';
require_once dirname(__FILE__) . '/../../src/complexpie.php';

class FeedSubtitleTest extends TextConstructTest
{
    protected function getContent($input)
    {
        $input = sprintf("<feed xmlns='http://www.w3.org/2005/Atom'>$input</feed>", 'subtitle');
        $feed = \ComplexPie\ComplexPie($input);
        return $feed->subtitle;
    }
    
    public function testNoSubtitle()
    {
        $input = '<feed xmlns="http://www.w3.org/2005/Atom"></feed>';
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame(null, $feed->subtitle);
    }
    
    public function subtitlePriorityData()
    {
        return array(
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <subtitle>PASS</subtitle>
    <subtitle>FAIL</subtitle>
</feed>
EOF
            ),
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <subtitle>PASS</subtitle>
    <subtitle xmlns="http://purl.org/atom/ns#">FAIL</subtitle>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <subtitle xmlns="http://purl.org/atom/ns#">FAIL</subtitle>
    <subtitle>PASS</subtitle>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <subtitle>PASS</subtitle>
    <subtitle xmlns="http://purl.org/rss/1.0/">FAIL</subtitle>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <subtitle xmlns="http://purl.org/rss/1.0/">FAIL</subtitle>
    <subtitle>PASS</subtitle>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <subtitle>PASS</subtitle>
    <subtitle xmlns="http://my.netscape.com/rdf/simple/0.9/">FAIL</subtitle>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <subtitle xmlns="http://my.netscape.com/rdf/simple/0.9/">FAIL</subtitle>
    <subtitle>PASS</subtitle>
</feed>
EOF
            ),
        );
    }
    
    /**
     * @dataProvider subtitlePriorityData
     */
    public function testSubtitlePriority($input)
    {
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame('PASS', $feed->subtitle->to_text());
    }
        
    public function htmlSubtitleData()
    {
        return array(
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom" xml:base="http://example.com">
    <subtitle type="html">&lt;a href="/">Test&lt;/a></subtitle>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <link href="http://example.com"/>
    <subtitle type="html">&lt;a href="/">Test&lt;/a></subtitle>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <subtitle type="html">&lt;a href="/">Test&lt;/a></subtitle>
    <link href="http://example.com"/>
</feed>
EOF
            ),
        );
    }
    
    /**
     * @dataProvider htmlSubtitleData
     */
    public function testHtmlSubtitle($input)
    {
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame('<a href="http://example.com">Test</a>', $feed->subtitle->to_html());
    }
        
    public function xhtmlSubtitleData()
    {
        return array(
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom" xml:base="http://example.com">
    <subtitle type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></subtitle>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <link href="http://example.com"/>
    <subtitle type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></subtitle>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <subtitle type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></subtitle>
    <link href="http://example.com"/>
</feed>
EOF
            ),
        );
    }
    
    /**
     * @dataProvider xhtmlSubtitleData
     */
    public function testXhtmlSubtitle($input)
    {
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame('<a href="http://example.com">Test</a>', $feed->subtitle->to_html());
    }
}

?>
