<?php

require_once dirname(__FILE__) . '/TextConstructTest.php';
require_once dirname(__FILE__) . '/../../src/complexpie.php';

class Atom10_FeedEntryTitleTest extends TextConstructTest
{
    protected function getContent($input)
    {
        $input = sprintf("<feed xmlns='http://www.w3.org/2005/Atom'><entry>$input</entry></feed>", 'title');
        $feed = \ComplexPie\ComplexPie($input);
        return $feed->entries[0]->title;
    }
    
    public function testNoTitle()
    {
        $input = '<feed xmlns="http://www.w3.org/2005/Atom"><entry/></feed>';
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame(null, $feed->entries[0]->title);
    }
    
    public function titlePriorityData()
    {
        return array(
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <title>PASS</title>
        <title>FAIL</title>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <title>PASS</title>
        <title xmlns="http://purl.org/atom/ns#">FAIL</title>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <title xmlns="http://purl.org/atom/ns#">FAIL</title>
        <title>PASS</title>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <title>PASS</title>
        <title xmlns="http://purl.org/rss/1.0/">FAIL</title>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <title xmlns="http://purl.org/rss/1.0/">FAIL</title>
        <title>PASS</title>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <title>PASS</title>
        <title xmlns="http://my.netscape.com/rdf/simple/0.9/">FAIL</title>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <title xmlns="http://my.netscape.com/rdf/simple/0.9/">FAIL</title>
        <title>PASS</title>
    </entry>
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
        $this->assertSame('PASS', $feed->entries[0]->title->to_text());
    }
        
    public function htmlTitleData()
    {
        return array(
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom" xml:base="http://example.com">
    <entry>
        <title type="html">&lt;a href="/">Test&lt;/a></title>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry xml:base="http://example.com">
        <title type="html">&lt;a href="/">Test&lt;/a></title>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <link href="http://example.com"/>
    <entry>
        <title type="html">&lt;a href="/">Test&lt;/a></title>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <title type="html">&lt;a href="/">Test&lt;/a></title>
    </entry>
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
        $this->assertSame('<a href="http://example.com">Test</a>', $feed->entries[0]->title->to_html());
    }
        
    public function xhtmlTitleData()
    {
        return array(
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom" xml:base="http://example.com">
    <entry>
        <title type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></title>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry xml:base="http://example.com">
        <title type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></title>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <link href="http://example.com"/>
    <entry>
        <title type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></title>
    </entry>
</feed>
EOF
            ),
            array(
<<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <title type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></title>
    </entry>
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
        $this->assertSame('<a href="http://example.com">Test</a>', $feed->entries[0]->title->to_html());
    }
}

?>
