<?php

require_once dirname(__FILE__) . '/TextConstructTest.php';
require_once dirname(__FILE__) . '/../../src/complexpie.php';

class Atom10_FeedEntrySummaryTest extends TextConstructTest
{
    protected function getContent($input)
    {
        $input = sprintf("<feed xmlns='http://www.w3.org/2005/Atom'><entry>$input</entry></feed>", 'summary');
        $feed = \ComplexPie\ComplexPie($input);
        return $feed->entries[0]->summary;
    }
    
    public function testNoSummary()
    {
        $input = '<feed xmlns="http://www.w3.org/2005/Atom"><entry/></feed>';
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame(null, $feed->entries[0]->summary);
    }
    
    public function summaryPriorityData()
    {
        return array(
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <summary>PASS</summary>
        <summary>FAIL</summary>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <summary>PASS</summary>
        <summary xmlns="http://purl.org/atom/ns#">FAIL</summary>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <summary xmlns="http://purl.org/atom/ns#">FAIL</summary>
        <summary>PASS</summary>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <summary>PASS</summary>
        <description xmlns="http://purl.org/rss/1.0/">FAIL</description>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <description xmlns="http://purl.org/rss/1.0/">FAIL</description>
        <summary>PASS</summary>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <summary>PASS</summary>
        <description xmlns="http://my.netscape.com/rdf/simple/0.9/">FAIL</description>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <description xmlns="http://my.netscape.com/rdf/simple/0.9/">FAIL</description>
        <summary>PASS</summary>
    </entry>
</feed>
EOF
            ),
        );
    }
    
    /**
     * @dataProvider summaryPriorityData
     */
    public function testSummaryPriority($input)
    {
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame('PASS', $feed->entries[0]->summary->to_text());
    }
        
    public function htmlSummaryData()
    {
        return array(
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom" xml:base="http://example.com">
    <entry>
        <summary type="html">&lt;a href="/">Test&lt;/a></summary>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry xml:base="http://example.com">
        <summary type="html">&lt;a href="/">Test&lt;/a></summary>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <link href="http://example.com"/>
    <entry>
        <summary type="html">&lt;a href="/">Test&lt;/a></summary>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <summary type="html">&lt;a href="/">Test&lt;/a></summary>
    </entry>
    <link href="http://example.com"/>
</feed>
EOF
            ),
        );
    }
    
    /**
     * @dataProvider htmlSummaryData
     */
    public function testHtmlSummary($input)
    {
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame('<a href="http://example.com">Test</a>', $feed->entries[0]->summary->to_html());
    }
        
    public function xhtmlSummaryData()
    {
        return array(
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom" xml:base="http://example.com">
    <entry>
        <summary type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></summary>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry xml:base="http://example.com">
        <summary type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></summary>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <link href="http://example.com"/>
    <entry>
        <summary type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></summary>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <summary type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></summary>
    </entry>
    <link href="http://example.com"/>
</feed>
EOF
            ),
        );
    }
    
    /**
     * @dataProvider xhtmlSummaryData
     */
    public function testXhtmlSummary($input)
    {
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame('<a href="http://example.com">Test</a>', $feed->entries[0]->summary->to_html());
    }
}

?>
