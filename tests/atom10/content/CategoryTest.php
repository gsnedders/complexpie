<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../../src/complexpie.php';

class ContentCategoryTest extends PHPUnit_Framework_TestCase
{
    public function termData()
    {
        return array(
            array(
                'Foobar',
                '<term>Foobar</term>',
            ),
            array(
                'Foobar',
                '<term xmlns="http://example.com">FAIL</term><term>Foobar</term>',
            ),
            array(
                'Foobar',
                '<term>Foobar</term><term xmlns="http://example.com">FAIL</term>',
            ),
            array(
                'Foo&bar',
                '<term>Foo&amp;bar</term>',
            ),
            array(
                'Foo&amp;bar',
                '<term>Foo&amp;amp;bar</term>',
            ),
            array(
                '<span>Foobar</span>',
                '<term>&lt;span>Foobar&lt;/span></term>',
            ),
            array(
                null,
                '',
            ),
        );
    }
    
    /**
     * @dataProvider termData
     */
    public function testTerm($expected, $input)
    {
        $dom = new \DOMDocument();
        $dom->loadXML('<category xmlns="http://www.w3.org/2005/Atom">' . $input . '</category>');
        $dom->documentURI = null;
        $category = new \ComplexPie\Atom10\Content\Category($dom->documentElement);
        if ($expected !== null)
        {
            $this->assertSame($expected, $category->term->to_text());
        }
        else
        {
            $this->assertSame($expected, $category->term);
        }
    }
    
    public function schemeData()
    {
        return array(
            array(
                'http://example.com',
                '<scheme>http://example.com</scheme>',
            ),
            array(
                'http://example.com',
                '<scheme xml:base="http://example.com">/</scheme>',
            ),
            array(
                'http://example.com?foo&bar',
                '<scheme>http://example.com?foo&amp;bar</scheme>',
            ),
            array(
                '/',
                '<scheme>/</scheme>',
            ),
            array(
                null,
                '',
            ),
        );
    }
    
    /**
     * @dataProvider schemeData
     */
    public function testScheme($expected, $input)
    {
        $dom = new \DOMDocument();
        $dom->loadXML('<category xmlns="http://www.w3.org/2005/Atom">' . $input . '</category>');
        $dom->documentURI = null;
        $category = new \ComplexPie\Atom10\Content\Category($dom->documentElement);
        if ($expected !== null)
        {
            $this->assertSame($expected, $category->scheme->to_text());
        }
        else
        {
            $this->assertSame($expected, $category->scheme);
        }
    }
    
    public function labelData()
    {
        return array(
            array(
                'foobar@example.com',
                '<label>foobar@example.com</label>',
            ),
            array(
                'Invalid bogus string',
                '<label>Invalid bogus string</label>',
            ),
            array(
                'Foo&bar',
                '<label>Foo&amp;bar</label>',
            ),
            array(
                'Foo&amp;bar',
                '<label>Foo&amp;amp;bar</label>',
            ),
            array(
                '<span>Foobar</span>',
                '<label>&lt;span>Foobar&lt;/span></label>',
            ),
            array(
                null,
                '',
            ),
        );
    }
    
    /**
     * @dataProvider labelData
     */
    public function testLabel($expected, $input)
    {
        $dom = new \DOMDocument();
        $dom->loadXML('<category xmlns="http://www.w3.org/2005/Atom">' . $input . '</category>');
        $dom->documentURI = null;
        $category = new \ComplexPie\Atom10\Content\Category($dom->documentElement);
        if ($expected !== null)
        {
            $this->assertSame($expected, $category->label->to_text());
        }
        else
        {
            $this->assertSame($expected, $category->label);
        }
    }
}

?>
