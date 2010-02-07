<?php

date_default_timezone_set('Europe/Stockholm');

require_once 'PHPUnit/Framework.php';
require_once '../src/simplepie.php';

class DateTest extends PHPUnit_Framework_TestCase
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
                'Sat, 05 Nov 1994 13:15:30 GMT',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Saturday, 05 Nov 94 13:15:30 GMT',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Vendredi, 05 Nov 94 13:15:30 GMT',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 UTC',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Mon, 05 Nov 94 13:15:30 GMT',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 GMT',
            ),
            array(
                '2010-11-05T13:15:30+00:00',
                'Fri, 05 Nov 10 13:15:30 GMT',
            ),
            array(
                '1990-11-05T13:15:30+00:00',
                'Mon, 05 Nov 90 13:15:30 GMT',
            ),
            array(
                '2049-11-05T13:15:30+00:00',
                'Sat, 05 Nov 49 13:15:30 GMT',
            ),
            array(
                '1950-11-05T13:15:30+00:00',
                'Sat, 05 Nov 50 13:15:30 GMT',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                '05 Nov 94 13:15:30 GMT',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 5 Nov 94 13:15:30 GMT',
            ),
            array(
                '1994-11-05T13:15:00+00:00',
                'Sat, 05 Nov 94 13:15 GMT',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 UT',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 08:15:30 EST',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 09:15:30 EDT',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 07:15:30 CST',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 08:15:30 CDT',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 06:15:30 MST',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 07:15:30 MDT',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 05:15:30 PST',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 06:15:30 PDT',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 A',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 B',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 C',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 D',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 E',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 F',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 G',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 H',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 I',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 K',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 L',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 M',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 N',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 O',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 P',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 Q',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 R',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 S',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 T',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 U',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 V',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 W',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 X',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 Y',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 Z',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 +0000',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:15:30 -0000',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 14:15:30 +0100',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 12:15:30 -0100',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 13:45:30 +0030',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat, 05 Nov 94 12:45:30 -0030',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat(urday), 05 Nov(ember) 94 13:15:30 GMT',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat(urd(a)y), 05 Nov 94 13:15:30 GMT',
            ),
            array(
                false,
                'Saturday, 05 Nov\\(ember) 94 13:15:30 GMT',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat(urda\\)y), 05 Nov 94 13:15:30 GMT',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat(urday\\\\), 05 Nov 94 13:15:30 GMT',
            ),
            array(
                false,
                'Sat, 05 Nov( 94 13:15:30 GMT',
            ),
            array(
                '1994-11-05T13:15:30+00:00',
                'Sat(urday), 05 Nov(ember) 94 13:15:30 A',
            ),
            array(
                false,
                'meep',
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
        );
    }
    
    /**
     * @dataProvider basicData
     */
    public function testBasic($expected, $date)
    {
        $parsed = \ComplexPie\Misc::parse_date($date);
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
}

?>
