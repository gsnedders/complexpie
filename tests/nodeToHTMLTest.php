<?php

require_once 'PHPUnit/Framework.php';
require_once '../src/simplepie.php';

class nodeToHTMLTest extends PHPUnit_Framework_TestCase
{
    public function basicXML()
    {
        return array(
            array(
                '<foo/>',
                '<foo></foo>'
            ),
            array(
                '<foo>Test</foo>',
                '<foo>Test</foo>'
            ),
            array(
                '<foo><bar>Test</bar></foo>',
                '<foo><bar>Test</bar></foo>'
            ),
            array(
                '<foo><bar/>Test</foo>',
                '<foo><bar></bar>Test</foo>'
            ),
            array(
                '<foo><a><b/></a>Test</foo>',
                '<foo><a><b></b></a>Test</foo>'
            ),
            array(
                '<foo><a><b><c/></b></a>Test</foo>',
                '<foo><a><b><c></c></b></a>Test</foo>'
            ),
            array(
                '<html xmlns="http://www.w3.org/1999/xhtml"/>',
                '<html xmlns="http://www.w3.org/1999/xhtml"></html>'
            ),
            array(
                '<a href="http://example.com">Test</a>',
                '<a href="http://example.com">Test</a>'
            ),
            array(
                '<a><!--foo--></a>',
                '<a><!--foo--></a>'
            )
        );
    }
    
    /**
     * @dataProvider basicXML
     */
    public function testXML($xml, $expected)
    {
        $dom = new \DOMDocument;
        $dom->loadXML($xml);
        $this->assertSame($expected, \ComplexPie\nodeToHTML($dom->documentElement));
    }
    
    public function basicHTML()
    {
        return array(
            array(
                '<html><head><body><p>Test</p>',
                '<html><head></head><body><p>Test</p></body></html>'
            ),
            array(
                '<html><head><body><a href="http://example.com">Test</a>',
                '<html><head></head><body><a href="http://example.com">Test</a></body></html>'
            ),
            array(
                '<html><head><body><img src="http://example.com">',
                '<html><head></head><body><img src="http://example.com"></body></html>'
            ),
            array(
                '<html><head><body><img src="http://example.com"><p>Test',
                '<html><head></head><body><img src="http://example.com"><p>Test</p></body></html>'
            ),
        );
    }
    
    /**
     * @dataProvider basicHTML
     */
    public function testHTML($html, $expected)
    {
        $parser = new \ComplexPie\HTMLParser($html);
        $dom = $parser->parse();
        $this->assertSame($expected, \ComplexPie\nodeToHTML($dom->documentElement));
    }
}

?>
