<?php

require_once dirname(__FILE__) . '/TextConstructTest.php';
require_once dirname(__FILE__) . '/../../src/complexpie.php';

class FeedRightsTest extends TextConstructTest
{
    protected function getContent($input)
    {
        $input = sprintf("<feed xmlns='http://www.w3.org/2005/Atom'>$input</feed>", 'rights');
        $feed = \ComplexPie\ComplexPie($input);
        return $feed->rights;
    }
    
    public function testNoRights()
    {
        $input = '<feed xmlns="http://www.w3.org/2005/Atom"></feed>';
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame(null, $feed->rights);
    }
    
    public function rightsPriorityData()
    {
        return array(
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <rights>PASS</rights>
    <rights xmlns="http://purl.org/atom/ns#">FAIL</rights>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <rights xmlns="http://purl.org/atom/ns#">FAIL</rights>
    <rights>PASS</rights>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <rights>PASS</rights>
    <rights xmlns="http://purl.org/rss/1.0/">FAIL</rights>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <rights xmlns="http://purl.org/rss/1.0/">FAIL</rights>
    <rights>PASS</rights>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <rights>PASS</rights>
    <rights xmlns="http://my.netscape.com/rdf/simple/0.9/">FAIL</rights>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <rights xmlns="http://my.netscape.com/rdf/simple/0.9/">FAIL</rights>
    <rights>PASS</rights>
</feed>
EOF
            ),
        );
    }
    
    /**
     * @dataProvider rightsPriorityData
     */
    public function testRightsPriority($input)
    {
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame('PASS', $feed->rights->to_text());
    }
        
    public function htmlRightsData()
    {
        return array(
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom" xml:base="http://example.com">
    <rights type="html">&lt;a href="/">Test&lt;/a></rights>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <link href="http://example.com"/>
    <rights type="html">&lt;a href="/">Test&lt;/a></rights>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <rights type="html">&lt;a href="/">Test&lt;/a></rights>
    <link href="http://example.com"/>
</feed>
EOF
            ),
        );
    }
    
    /**
     * @dataProvider htmlRightsData
     */
    public function testHtmlRights($input)
    {
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame('<a href="http://example.com">Test</a>', $feed->rights->to_html());
    }
        
    public function xhtmlRightsData()
    {
        return array(
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom" xml:base="http://example.com">
    <rights type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></rights>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <link href="http://example.com"/>
    <rights type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></rights>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <rights type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></rights>
    <link href="http://example.com"/>
</feed>
EOF
            ),
        );
    }
    
    /**
     * @dataProvider xhtmlRightsData
     */
    public function testXhtmlRights($input)
    {
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame('<a href="http://example.com">Test</a>', $feed->rights->to_html());
    }
}

?>
