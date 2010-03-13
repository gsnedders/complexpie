<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../src/complexpie.php';

class FeedCategoryTest extends PHPUnit_Framework_TestCase
{
    public function termData()
    {
        return array(
            array(
                'Foobar',
                'term="Foobar"',
            ),
            array(
                'Foo&bar',
                'term="Foo&amp;bar"',
            ),
            array(
                'Foo&amp;bar',
                'term="Foo&amp;amp;bar"',
            ),
            array(
                '<span>Foobar</span>',
                'term="&lt;span>Foobar&lt;/span>"',
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
        $input = sprintf('<feed xmlns="http://www.w3.org/2005/Atom"><category %s/></feed>', $input);
        $feed = \ComplexPie\ComplexPie($input);
        list($category) = $feed->categories;
        if ($expected !== null)
        {
            $this->assertSame($expected, $category->term->to_text());
        }
        else
        {
            $this->assertSame($expected, $category->term);
        }
    }
    
    /**
     * @dataProvider termData
     */
    public function testLabelImpliedByTerm($expected, $input)
    {
        $input = sprintf('<feed xmlns="http://www.w3.org/2005/Atom"><category %s/></feed>', $input);
        $feed = \ComplexPie\ComplexPie($input);
        list($category) = $feed->categories;
        if ($expected !== null)
        {
            $this->assertSame($expected, $category->label->to_text());
        }
        else
        {
            $this->assertSame($expected, $category->label);
        }
    }
    
    public function testTermNotImpliedByLabel()
    {
        $input = '<feed xmlns="http://www.w3.org/2005/Atom"><category label="FAIL"/></feed>';
        $feed = \ComplexPie\ComplexPie($input);
        list($category) = $feed->categories;
        $this->assertSame(null, $category->term);
    }
    
    public function schemeData()
    {
        return array(
            array(
                'http://example.com',
                'scheme="http://example.com"',
            ),
            array(
                'http://example.com',
                'xml:base="http://example.com" scheme="/"',
            ),
            array(
                'http://example.com?foo&bar',
                'scheme="http://example.com?foo&amp;bar"',
            ),
            array(
                '/',
                'scheme="/"',
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
        $input = sprintf('<feed xmlns="http://www.w3.org/2005/Atom"><category %s/></feed>', $input);
        $feed = \ComplexPie\ComplexPie($input);
        list($category) = $feed->categories;
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
                'PASS',
                'label="PASS" term="FAIL"',
            ),
            array(
                'PASS',
                'term="FAIL" label="PASS"',
            ),
            array(
                'Foobar',
                'label="Foobar"',
            ),
            array(
                'Foo&bar',
                'label="Foo&amp;bar"',
            ),
            array(
                'Foo&amp;bar',
                'label="Foo&amp;amp;bar"',
            ),
            array(
                '<span>Foobar</span>',
                'label="&lt;span>Foobar&lt;/span>"',
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
        $input = sprintf('<feed xmlns="http://www.w3.org/2005/Atom"><category %s/></feed>', $input);
        $feed = \ComplexPie\ComplexPie($input);
        list($category) = $feed->categories;
        if ($expected !== null)
        {
            $this->assertSame($expected, $category->label->to_text());
        }
        else
        {
            $this->assertSame($expected, $category->label);
        }
    }
    
    public function testMultipleCategories()
    {
        $input = <<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <category term="category 1"/>
    <category term="category 2"/>
</feed>
EOF;
        $feed = \ComplexPie\ComplexPie($input);
        $categories = $feed->categories;
        $this->assertSame('category 1', $categories[0]->term->to_text());
        $this->assertSame('category 2', $categories[1]->term->to_text());
    }
    
    public function testMultipleCategoriesConstantOrder()
    {
        $input = <<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <category term="category 1"/>
    <category term="category 2"/>
</feed>
EOF;
        $feed = \ComplexPie\ComplexPie($input);
        // This causes authors to be calculated twice
        $this->assertSame('category 1', $feed->categories[0]->term->to_text());
        $this->assertSame('category 2', $feed->categories[1]->term->to_text());
    }
    
    public function testCategoryCount()
    {
        $input = <<<EOF
<feed xmlns="http://www.w3.org/2005/Atom">
    <category term="category 1"/>
    <category term="category 2"/>
</feed>
EOF;
        $feed = \ComplexPie\ComplexPie($input);
        $this->assertSame(2, count($feed->categories));
    }
}

?>
