<?php

require_once 'PHPUnit/Framework.php';
require_once '../src/simplepie.php';

class DOMIteratorTest extends PHPUnit_Framework_TestCase
{
    public function basicData()
    {
        $tests = array();
        
        $dom = new \DOMDocument;
        $dom->loadXML('<foo/>');
        $expected = array(
            $dom,
            $dom->documentElement
        );
        $tests[] = array($dom, $expected);
        
        $dom = new \DOMDocument;
        $dom->loadXML('<foo>Test</foo>');
        $expected = array(
            $dom,
            $dom->documentElement,
            $dom->documentElement->firstChild
        );
        $tests[] = array($dom, $expected);
        
        $dom = new \DOMDocument;
        $dom->loadXML('<foo><bar>Test</bar></foo>');
        $expected = array(
            $dom,
            $dom->documentElement,
            $dom->documentElement->firstChild,
            $dom->documentElement->firstChild->firstChild
        );
        $tests[] = array($dom, $expected);
        
        $dom = new \DOMDocument;
        $dom->loadXML('<foo><bar/>Test</foo>');
        $expected = array(
            $dom,
            $dom->documentElement,
            $dom->documentElement->firstChild,
            $dom->documentElement->lastChild
        );
        $tests[] = array($dom, $expected);
        
        $dom = new \DOMDocument;
        $dom->loadXML('<foo><a><b/></a>Test</foo>');
        $expected = array(
            $dom,
            $dom->documentElement,
            $dom->documentElement->firstChild,
            $dom->documentElement->firstChild->firstChild,
            $dom->documentElement->lastChild
        );
        $tests[] = array($dom, $expected);
        
        $dom = new \DOMDocument;
        $dom->loadXML('<foo><a><b><c/></b></a>Test</foo>');
        $expected = array(
            $dom,
            $dom->documentElement,
            $dom->documentElement->firstChild,
            $dom->documentElement->firstChild->firstChild,
            $dom->documentElement->firstChild->firstChild->firstChild,
            $dom->documentElement->lastChild
        );
        $tests[] = array($dom, $expected);
        
        $dom = new \DOMDocument;
        $dom->loadXML('<foo><bar/>Test</foo>');
        $expected = array(
            $dom->documentElement->firstChild,
        );
        $tests[] = array($dom->documentElement->firstChild, $expected);
        
        return $tests;
    }
    
    /**
     * @dataProvider basicData
     */
    public function testBasic($root, $expected)
    {
        $got = array();
        foreach (new \ComplexPie\DOMIterator($root) as $key => $node)
        {
            $got[$key] = $node;
        }
        $this->assertSame($expected, $got);
    }
    
    /**
     * @dataProvider basicData
     */
    public function testRootElementAsRoot($root, $expected)
    {
        if ($root instanceof \DOMDocument)
        {
            if ($root->documentElement)
            {
                while ($expected[0] !== $root->documentElement)
                    array_shift($expected);
                
                $got = array();
                foreach (new \ComplexPie\DOMIterator($root->documentElement) as $key => $node)
                {
                    $got[$key] = $node;
                }
                $this->assertSame($expected, $got);
            }
        }
    }
}

?>
