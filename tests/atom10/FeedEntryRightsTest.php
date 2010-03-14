<?php

require_once dirname(__FILE__) . '/TextConstructTest.php';
require_once dirname(__FILE__) . '/../../src/complexpie.php';

class Atom10_FeedEntryRightsTest extends TextConstructTest
{
    protected function getContent($input)
    {
        $input = sprintf("<feed xmlns='http://www.w3.org/2005/Atom'><entry>$input</entry></feed>", 'rights');
        $feed = \ComplexPie\ComplexPie($input);
        return $feed->entries[0]->rights;
    }
    
    public function testNoRights()
    {
        $input = '<feed xmlns="http://www.w3.org/2005/Atom"><entry/></feed>';
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame(null, $feed->entries[0]->rights);
    }
    
    public function rightsPriorityData()
    {
        return array(
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <rights>PASS</rights>
        <rights>FAIL</rights>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <rights>PASS</rights>
        <rights xmlns="http://purl.org/atom/ns#">FAIL</rights>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <rights xmlns="http://purl.org/atom/ns#">FAIL</rights>
        <rights>PASS</rights>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <rights>PASS</rights>
        <rights xmlns="http://purl.org/rss/1.0/">FAIL</rights>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <rights xmlns="http://purl.org/rss/1.0/">FAIL</rights>
        <rights>PASS</rights>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <rights>PASS</rights>
        <rights xmlns="http://my.netscape.com/rdf/simple/0.9/">FAIL</rights>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <rights xmlns="http://my.netscape.com/rdf/simple/0.9/">FAIL</rights>
        <rights>PASS</rights>
    </entry>
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
        $this->assertSame('PASS', $feed->entries[0]->rights->to_text());
    }
        
    public function htmlRightsData()
    {
        return array(
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom" xml:base="http://example.com">
    <entry>
        <rights type="html">&lt;a href="/">Test&lt;/a></rights>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry xml:base="http://example.com">
        <rights type="html">&lt;a href="/">Test&lt;/a></rights>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <link href="http://example.com"/>
    <entry>
        <rights type="html">&lt;a href="/">Test&lt;/a></rights>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <rights type="html">&lt;a href="/">Test&lt;/a></rights>
    </entry>
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
        $this->assertSame('<a href="http://example.com">Test</a>', $feed->entries[0]->rights->to_html());
    }
        
    public function xhtmlRightsData()
    {
        return array(
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom" xml:base="http://example.com">
    <entry>
        <rights type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></rights>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry xml:base="http://example.com">
        <rights type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></rights>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <link href="http://example.com"/>
    <entry>
        <rights type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></rights>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <rights type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></rights>
    </entry>
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
        $this->assertSame('<a href="http://example.com">Test</a>', $feed->entries[0]->rights->to_html());
    }
    
    public function testInheritsFromFeed()
    {
        $input = <<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <rights>PASS</rights>
    <entry>
        <title>Foobar</title>
    </entry>
</feed>
EOF;
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame('PASS', $feed->entries[0]->rights->to_html());
    }
}

?>
