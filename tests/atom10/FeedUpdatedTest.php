<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../src/complexpie.php';

class FeedUpdatedTest extends PHPUnit_Framework_TestCase
{
    public function basicData()
    {
        return array(
            array(
                '1985-04-12T23:20:51+00:00',
                '1985-04-12T23:20:50.52Z',
            ),
            array(
                '1996-12-20T00:39:57+00:00',
                '1996-12-19T16:39:57-08:00',
            ),
            array(
                '1996-12-20T00:39:57+00:00',
                '1996-12-20T00:39:57Z',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                '1994-11-05T08:15:30-0500',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                '1994-11-05T08:15:30-05:00',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                '1994-11-05T13:15:30Z',
            ),
            array(
                false,
                'foobar',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 GMT',
            ),
        );
    }
    
    /**
     * @dataProvider basicData
     */
    public function testBasic($expected, $date)
    {
        $input = <<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <updated>%s</updated>
</feed>
EOF;
        $feed = \ComplexPie\ComplexPie(sprintf($input, $date));
        $parsed = $feed->updated;
        if ($parsed)
        {
            $tz = new \DateTimeZone('UTC');
            $parsed->setTimezone($tz);
            $this->assertSame($expected, $parsed->format(\DateTime::ATOM));
        }
        else
        {
            $this->assertSame($expected, $parsed);
        }
    }
    
    public function testMultipleReturnsFirst()
    {
        $input = <<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <updated>2000-01-01T00:00:00Z</updated>
    <updated>2010-01-01T00:00:00Z</updated>
</feed>
EOF;
        $feed = \ComplexPie\ComplexPie($input);
        $parsed = $feed->updated;
        $tz = new \DateTimeZone('UTC');
        $parsed->setTimezone($tz);
        $this->assertSame('2000-01-01T00:00:00+00:00', $parsed->format(\DateTime::ATOM));
    }
}

?>
