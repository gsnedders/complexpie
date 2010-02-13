<?php

require_once 'PHPUnit/Framework.php';
require_once '../src/complexpie.php';

class ExtensionTest extends PHPUnit_Framework_TestCase
{
    private function createClasses($number)
    {
        static $num = 0;
        $prefix = 'ExtensionTest_Class_';
        while (class_exists($prefix . $num))
            $num++;
        
        $classes = array();
        $previous = '\ComplexPie\Extension';
        for ($i = 0; $i < $number; $i++)
        {
            $class = $prefix . $num++;
            eval("class {$class} extends {$previous}" . '{protected static $static_ext = array();}');
            $classes[] = $previous = $class;
        }
        return $classes;
    }
    
    public function testBasicNonStatic()
    {
        list($class) = $this->createClasses(1);
        $obj = new $class;
        $obj->add_extension_point('foobar');
        $obj->add_extension('foobar', 'test', 1);
        $this->assertSame(array('test'), $obj->get_extensions('foobar'));
    }
    
    public function testBasicStatic()
    {
        list($class) = $this->createClasses(1);
        $class::add_static_extension_point('foobar');
        $class::add_static_extension('foobar', 'test', 1);
        $obj = new $class;
        $this->assertSame(array('test'), $obj->get_extensions('foobar'));
    }
    
    public function testAddNonStaticToStaticExtPoint()
    {
        list($class) = $this->createClasses(1);
        $class::add_static_extension_point('foobar');
        $obj = new $class;
        $obj2 = new $class;
        $obj->add_extension('foobar', 'test', 1);
        $this->assertSame(array('test'), $obj->get_extensions('foobar'));
        $this->assertSame(array(), $obj2->get_extensions('foobar'));
    }
    
    public function testAddNonStaticToStaticExtPointCreatedAfterObj()
    {
        list($class) = $this->createClasses(1);
        $obj = new $class;
        $obj2 = new $class;
        $class::add_static_extension_point('foobar');
        $obj->add_extension('foobar', 'test', 1);
        $this->assertSame(array('test'), $obj->get_extensions('foobar'));
        $this->assertSame(array(), $obj2->get_extensions('foobar'));
    }
    
    public function testAddStaticToSubclass()
    {
        list($class, $class2) = $this->createClasses(2);
        $class::add_static_extension_point('foobar');
        $class2::add_static_extension('foobar', 'test', 1);
        $obj = new $class;
        $obj2 = new $class2;
        $this->assertSame(array(), $obj->get_extensions('foobar'));
        $this->assertSame(array('test'), $obj2->get_extensions('foobar'));
    }
    
    public function testAddToSuperclassPreexistingInSubclassStaticExtPoint()
    {
        list($class, $class2) = $this->createClasses(2);
        $class2::add_static_extension_point('foobar');
        $class2::add_static_extension('foobar', 'subclass', 1);
        $class::add_static_extension_point('foobar');
        $class::add_static_extension('foobar', 'superclass', 0);
        $obj = new $class;
        $obj2 = new $class2;
        $this->assertSame(array('superclass'), $obj->get_extensions('foobar'));
        $this->assertSame(array('superclass', 'subclass'), $obj2->get_extensions('foobar'));
    }
    
    public function testAddPreexistingStaticExtPoint()
    {
        list($class) = $this->createClasses(1);
        $class::add_static_extension_point('foobar');
        try
        {
            $class::add_static_extension_point('foobar');
            $this->fail('Expected exception not raised');
        }
        catch(\InvalidArgumentException $e)
        {
            $this->assertSame('Extension point "foobar" already exists', $e->getMessage());
        }
    }
    
    public function testAddToSubclassPreexistingStaticExtPoint()
    {
        list($class, $class2) = $this->createClasses(2);
        $class::add_static_extension_point('foobar');
        try
        {
            $class2::add_static_extension_point('foobar');
            $this->fail('Expected exception not raised');
        }
        catch(\InvalidArgumentException $e)
        {
            $this->assertSame('Extension point "foobar" already exists', $e->getMessage());
        }
    }
    
    public function testAddStaticExtPointWithNonStaticExtPoint()
    {
        list($class) = $this->createClasses(1);
        $obj = new $class;
        $obj->add_extension_point('foobar');
        $obj->add_extension('foobar', 'test', 1);
        $class::add_static_extension_point('foobar');
        $this->assertSame(array('test'), $obj->get_extensions('foobar'));
        $obj2 = new $class;
        $this->assertSame(array(), $obj2->get_extensions('foobar'));
    }
    
    public function testAddNonStaticExtPointWithPreexistingStaticExtPoint()
    {
        list($class) = $this->createClasses(1);
        $class::add_static_extension_point('foobar');
        $obj = new $class;
        try
        {
            $obj->add_extension_point('foobar');
            $this->fail('Expected exception not raised');
        }
        catch(\InvalidArgumentException $e)
        {
            $this->assertSame('Extension point "foobar" already exists', $e->getMessage());
        }
    }
}

?>
