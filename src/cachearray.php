<?php
namespace ComplexPie;

class CacheArray extends \ArrayObject
{
    const MAX_CACHE_SIZE = 100;
    private $max_int_index = 0;
    private $access_count = array();
    
    public function offsetGet($index)
    {
        ++$this->access_count[$index];
        return parent::offsetGet($index);
    }
    
    public function offsetSet($index, $newval)
    {
        if (count($this) === self::MAX_CACHE_SIZE)
        {
            $this->invalidate();
        }
        
        // Make sure we know the index so we can set access_count correctly
        if ($index === null)
        {
            $index = $this->max_int_index++;
        }
        elseif (!is_string($index))
        {
            $index = (int) $index;
            $this->max_int_index = max($this->max_int_index, $index);
        }
        
        $this->access_count[$index] = 0;
        return parent::offsetSet($index, $newval);
    }
    
    public function offsetUnset($index)
    {
        unset($this->access_count[$index]);
        return parent::offsetUnset($index);
    }
    
    private function invalidate()
    {
        // The next, non-obvious, line gives the average access count.
        $keep_threshold = array_sum($this->access_count) / count($this);
        
        // Now, to make this even more non-obvious:
        // If something, but not everything, has been accessed,
        if (min($this->access_count) === 0 && max($this->access_count) !== 0)
        {
            // Then the threshold is simply the average rounded up.
            $keep_threshold = ceil($keep_threshold);
        }
        else
        {
            // Otherwise, it is rounded up, or increased by one if an int.
            $keep_threshold = floor($keep_threshold) + 1;
        }
        
        /*
         * The above if statement probably deserves even more explaining.
         * The concern of that is the case where we have everything in the
         * array being hit in the cache the same number of times, in which
         * case just rounding towards positive infinity as the threshold will
         * result in nothing being removed. Obviously, when it is full,
         * we want to ensure we do actually remove anything that isn't
         * so relevant, so treat everything here as being equally relevant
         * (which appears to be true).
         *
         * Equally, it's probably also worthwhile why in the first case we
         * round towards positive infinity, not to nearest: taking the average
         * when all but one (which is one more) are the same is going to result
         * in the average being very close to the majority of them, which would
         * result in nothing being removed when rounding to nearest.
         */
        
        $keep = array();
        foreach ($this->access_count as $key => $count)
        {
            if ($count < $keep_threshold)
            {
                unset($this[$key]);
                unset($this->access_count[$key]);
            }
        }
    }
}
