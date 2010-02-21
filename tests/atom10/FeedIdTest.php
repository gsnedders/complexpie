<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../src/complexpie.php';

class FeedIdTest extends PHPUnit_Framework_TestCase
{
    public function basicData()
    {
        return array(
            array('http://www.example.org/thing'),
            array('http://www.example.org/Thing'),
            array('http://www.EXAMPLE.org/thing'),
            array('HTTP://www.example.org/thing'),
            array('http://www.example.com/~bob'),
            array('http://www.example.com/%7ebob'),
            array('http://www.example.com/%7Ebob'),
        );
    }
    
    /**
     * @dataProvider basicData
     */
    public function testBasic($id)
    {
        $input = <<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <id>%s</id>
</feed>
EOF;
        $feed = \ComplexPie\ComplexPie(sprintf($input, $id));
        $this->assertSame($id, $feed->id->to_text());
    }
    
    public function needsSanitizedData()
    {
        return array(
            array(
                'http://www.example.org/foo&bar',
                'http://www.example.org/foo&amp;bar',
            ),
            array(
                'http://www.example.org/foo&amp;bar',
                'http://www.example.org/foo&amp;amp;bar',
            ),
        );
    }
    
    /**
     * @dataProvider needsSanitizedData
     */
    public function testNeedsSanitized($expected, $id)
    {
        $input = <<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <id>%s</id>
</feed>
EOF;
        $feed = \ComplexPie\ComplexPie(sprintf($input, $id));
        $this->assertSame($expected, $feed->id->to_text());
    }
}

?>
