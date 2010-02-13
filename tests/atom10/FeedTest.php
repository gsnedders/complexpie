<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../src/complexpie.php';

class FeedTest extends PHPUnit_Framework_TestCase
{
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
}

?>
