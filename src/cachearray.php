<?php
namespace ComplexPie;

class CacheArray extends \ArrayObject
{
    const MAX_CACHE_SIZE = 100;
    private $oldaccess_count = array();
    private $access = array();
    
    public function offsetGet($index)
    {
        $value = parent::offsetGet($index);
        $this->access[] = $index;
        if (count($this->access) === self::MAX_CACHE_SIZE)
        {
            $this->gc();
        }
        return $value;
    }
    
    public function offsetSet($index, $newval)
    {
        if (count($this) === self::MAX_CACHE_SIZE)
        {
            $this->gc();
        }
        return parent::offsetSet($index, $newval);
    }
    
    private function gc()
    {
        $access_count = array_count_values($this->access);
        $keep = array();
        foreach ($access_count as $value => $count)
        {
            if (!isset($this->oldaccess_count[$value]) ||
                $this->oldaccess_count[$value] < $count)
            {
                $keep[] = $value;
            }
        }
        $this->oldaccess_count = $access_count;
        $this->access = array();
        $keys = array();
        foreach ($this as $key => $value)
        {
            $keys[] = $key;
        }
        foreach(array_diff($keys, $keep) as $remove)
        {
            unset($this[$remove]);
        }
    }
}
