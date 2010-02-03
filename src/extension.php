<?php
namespace ComplexPie;

abstract class Extension
{
    protected static $static_ext = array();
    protected $object_ext = array();
    
    public static function add_static_extension($extpoint, $ext, $priority)
    {
        if (!isset(static::$static_ext[$extpoint]))
        {
            throw new Exception("Unknown extension point $extpoint.");
        }
        else
        {
            static::$static_ext[$extpoint][$ext] = (int) $priority;
        }
    }
    
    public static function add_static_extension_point($name)
    {
        if (!isset(static::$static_ext[$name]))
        {
            static::$static_ext[$name] = array();
        }
    }
    
    public function add_extension($extpoint, $ext, $priority)
    {
        if (!isset($this->object_ext[$extpoint]))
        {
            throw new Exception("Unknown extension point $extpoint.");
        }
        else
        {
            $this->object_ext[$extpoint][$ext] = (int) $priority;
        }
    }
    
    public function add_extension_point($name)
    {
        if (!isset(static::$static_ext[$name]) && !isset($this->object_ext[$name]))
        {
            $this->object_ext[$name] = array();
        }
    }
    
    protected function get_extensions($extpoint)
    {
        $extensions = array();
        
        // Static, per-class extensions
        $current = get_class($this);
        do
        {
            // Note the order of arguments: the superclass is first so that the
            // subclass's extensions' priorities will override it in case of
            // conflicts.
            $extensions = array_merge($current::$static_ext[$extpoint], $extensions);
        } while ($current = get_parent_class($current));
        
        // Per object extensions
        // Again, watch argument order here; per-object should override -class.
        $extensions = array_merge($extensions, $this->object_ext[$extpoint]);
        
        // Sort by priority (where lower is higher priority). Don't forget keys.
        asort($extensions, SORT_NUMERIC);
        
        return $extensions;
    }
}
