<?php

require_once 'PHPUnit/Framework.php';
require_once '../src/simplepie.php';

class CacheArrayTest extends PHPUnit_Framework_TestCase
{
    /**
     * This case is simple enough: it just grows to the maximum size.
     */
    public function testAppendToMaxSizeWithoutAccess()
    {
        $array = new \ComplexPie\CacheArray();
        $max = \ComplexPie\CacheArray::MAX_CACHE_SIZE;
        for ($i = 0; $i < $max; $i++)
        {
            $array[] = $i;
        }
        $this->assertSame($max, count($array));
    }
    
    /**
     * Access here makes no difference, as this just makes everything stay
     * when it hits 100 accesses.
     */
    public function testAppendToMaxSizeWithAccess()
    {
        $array = new \ComplexPie\CacheArray();
        $max = \ComplexPie\CacheArray::MAX_CACHE_SIZE;
        for ($i = 0; $i < $max; $i++)
        {
            $array[] = $i;
            $array[$i];
        }
        $this->assertSame($max, count($array));
    }
    
    /**
     * This is slightly more complex, and relies upon (our) GC behaviour:
     * it assumes that array values that are never accessed are removed.
     */
    public function testAppendToOverMaxSizeWithoutAccess()
    {
        $array = new \ComplexPie\CacheArray();
        $max = \ComplexPie\CacheArray::MAX_CACHE_SIZE + 1;
        for ($i = 0; $i < $max; $i++)
        {
            $array[] = $i;
        }
        $this->assertSame(1, count($array));
    }
    
    /**
     * The act of reading the 100th item after reaching 100 items means we
     * clean up here.
     */
    public function testAppendToOverMaxSizeWithAccess()
    {
        $array = new \ComplexPie\CacheArray();
        $max = \ComplexPie\CacheArray::MAX_CACHE_SIZE + 1;
        for ($i = 0; $i < $max; $i++)
        {
            $array[] = $i;
            $array[$i];
        }
        $this->assertSame(1, count($array));
    }
    
    /**
     * When we set the 101st item we clear out all the items not new and not
     * read.
     */
    public function testAppendToOverMaxSizeWithAccessToSpecific()
    {
        $array = new \ComplexPie\CacheArray();
        $max = \ComplexPie\CacheArray::MAX_CACHE_SIZE;
        for ($i = 0; $i < $max; $i++)
        {
            $array[] = $i;
        }
        $array[1];
        $array[2];
        $array[3];
        $array[] = $i;
        $this->assertSame(4, count($array));
    }
}

?>
