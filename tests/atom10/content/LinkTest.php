<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../../src/complexpie.php';

class ContentLinkTest extends PHPUnit_Framework_TestCase
{
    public function hrefData()
    {
        return array(
            array(
                'http://example.com',
                'href="http://example.com"',
            ),
            array(
                'http://example.com',
                'href="/" xml:base="http://example.com"',
            ),
        );
    }
    
    /**
     * @dataProvider hrefData
     */
    public function testHref($expected, $input)
    {
        $dom = new \DOMDocument();
        $dom->loadXML('<link xmlns="http://www.w3.org/2005/Atom" ' . $input . '/>');
        $dom->documentURI = null;
        $link = new \ComplexPie\Atom10\Content\Link($dom->documentElement);
        $this->assertSame($expected, $link->to_text());
    }
    
    public function relData()
    {
        return array(
            array(
                'http://www.iana.org/assignments/relation/alternate',
                'href=""',
            ),
            array(
                'http://www.iana.org/assignments/relation/self',
                'href="" rel="self"',
            ),
            array(
                'http://www.iana.org/assignments/relation/foobar',
                'href="" rel="foobar"',
            ),
            array(
                'http://example.com',
                'href="" rel="http://example.com"',
            ),
        );
    }
    
    /**
     * @dataProvider relData
     */
    public function testRel($expected, $input)
    {
        $dom = new \DOMDocument();
        $dom->loadXML('<link xmlns="http://www.w3.org/2005/Atom" ' . $input . '/>');
        $dom->documentURI = null;
        $link = new \ComplexPie\Atom10\Content\Link($dom->documentElement);
        $this->assertSame($expected, $link->rel->to_text());
    }
    
    public function hreflangData()
    {
        return array(
            array(
                null,
                'href=""',
            ),
            array(
                'en-gb-oed',
                'href="" hreflang="en-gb-oed"',
            ),
            array(
                'totally bogus and invalid string',
                'href="" hreflang="totally bogus and invalid string"',
            ),
        );
    }
    
    /**
     * @dataProvider hreflangData
     */
    public function testHreflang($expected, $input)
    {
        $dom = new \DOMDocument();
        $dom->loadXML('<link xmlns="http://www.w3.org/2005/Atom" ' . $input . '/>');
        $dom->documentURI = null;
        $link = new \ComplexPie\Atom10\Content\Link($dom->documentElement);
        if ($expected)
        {
            $this->assertSame($expected, $link->hreflang->to_text());
        }
        else
        {
            $this->assertSame($expected, $link->hreflang);
        }
    }
    
    public function titleData()
    {
        return array(
            array(
                null,
                'href=""',
            ),
            array(
                'Foobar',
                'href="" title="Foobar"',
            ),
            array(
                '<b>Foobar</b>',
                'href="" title="&lt;b&gt;Foobar&lt;/b&gt;"',
            ),
            array(
                'Foo&bar',
                'href="" title="Foo&amp;bar"',
            ),
        );
    }
    
    /**
     * @dataProvider titleData
     */
    public function testTitle($expected, $input)
    {
        $dom = new \DOMDocument();
        $dom->loadXML('<link xmlns="http://www.w3.org/2005/Atom" ' . $input . '/>');
        $dom->documentURI = null;
        $link = new \ComplexPie\Atom10\Content\Link($dom->documentElement);
        if ($expected)
        {
            $this->assertSame($expected, $link->title->to_text());
        }
        else
        {
            $this->assertSame($expected, $link->title);
        }
    }
    
    public function lengthData()
    {
        return array(
            array(
                null,
                'href=""',
            ),
            array(
                '123',
                'href="" length="123"',
            ),
            array(
                'totally bogus string',
                'href="" length="totally bogus string"',
            ),
        );
    }
    
    /**
     * @dataProvider lengthData
     */
    public function testLength($expected, $input)
    {
        $dom = new \DOMDocument();
        $dom->loadXML('<link xmlns="http://www.w3.org/2005/Atom" ' . $input . '/>');
        $dom->documentURI = null;
        $link = new \ComplexPie\Atom10\Content\Link($dom->documentElement);
        if ($expected)
        {
            $this->assertSame($expected, $link->length->to_text());
        }
        else
        {
            $this->assertSame($expected, $link->length);
        }
    }
}

?>
