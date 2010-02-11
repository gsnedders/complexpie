<?php
namespace ComplexPie;

abstract class Extension
{
    protected static $static_ext = array();
    protected $object_ext = array();
    
    public static function add_static_extension($extpoint, $ext, $priority)
    {
        if (!static::static_ext_point_exists($extpoint))
        {
            throw new \InvalidArgumentException("Unknown extension point $extpoint");
        }
        else
        {
            static::$static_ext[$extpoint][$priority][] = $ext;
        }
    }
    
    public static function add_static_extension_point($name)
    {
        if (!static::static_ext_point_exists($name))
        {
            static::$static_ext[$name] = array();
        }
        else
        {
            throw new \InvalidArgumentException("Extension point \"$name\" already exists");
        }
    }
    
    protected static function static_ext_point_exists($name)
    {
        $current = get_called_class();
        do
        {
            if (isset($current::$static_ext[$name]))
            {
                return true;
            }
        } while ($current = get_parent_class($current));
        
        return false;
    }
    
    public function add_extension($extpoint, $ext, $priority)
    {
        if (!static::static_ext_point_exists($extpoint) && !isset($this->object_ext[$extpoint]))
        {
            throw new \InvalidArgumentException("Unknown extension point $extpoint");
        }
        else
        {
            $this->object_ext[$extpoint][$priority][] = $ext;
        }
    }
    
    public function add_extension_point($name)
    {
        if (!isset(static::$static_ext[$name]) && !isset($this->object_ext[$name]))
        {
            $this->object_ext[$name] = array();
        }
        else
        {
            throw new \InvalidArgumentException("Extension point \"$name\" already exists");
        }
    }
    
    public function get_extensions($extpoint)
    {
        $extensions = array();
        $extpoint_exists = false;
        
        // Static, per-class extensions
        $current = get_class($this);
        do
        {
            if (isset($current::$static_ext[$extpoint]))
            {
                // Note the order of arguments: the superclass is first so that
                // the subclass's extensions' priorities will override it in
                // case of conflicts.
                $extensions = array_merge_recursive($current::$static_ext[$extpoint], $extensions);
                $extpoint_exists = true;
            }
        } while ($current = get_parent_class($current));
        
        // Per object extensions
        // Again, watch argument order here; per-object should override -class.
        if (isset($this->object_ext[$extpoint]))
        {
            $extensions = array_merge_recursive($extensions, $this->object_ext[$extpoint]);
            $extpoint_exists = true;
        }
        
        if ($extpoint_exists)
        {
            if ($extensions)
            {
                // Sort by priority (where lower is higher priority).
                ksort($extensions, SORT_NUMERIC);
                return call_user_func_array('array_merge', $extensions);
            }
            else
            {
                return array();
            }
        }
        else
        {
            throw new \InvalidArgumentException("Unknown extension point $extpoint");
        }
    }
}
