<?php
namespace ComplexPie;

class Data extends Extension
{
    protected static $static_ext = array();
    
    public static function add_static_extension($extpoint, $ext, $priority, $force = false)
    {
        if (is_string($ext) && substr($ext, 0, 1) === '\\')
        {
            $ext = substr($ext, 1);
        }
        
        if (!$force && $extpoint === 'get' && !is_callable($ext))
        {
            throw new \InvalidArgumentException("$ext is not callable");
        }
        parent::add_static_extension($extpoint, $ext, $priority);
    }
    
    public function add_extension($extpoint, $ext, $priority, $force = false)
    {
        if (is_string($ext) && substr($ext, 0, 1) === '\\')
        {
            $ext = substr($ext, 1);
        }
        
        if (!$force && $extpoint === 'get' && !is_callable($ext))
        {
            throw new \InvalidArgumentException("$ext is not callable");
        }
        parent::add_extension($extpoint, $ext, $priority);
    }
    
    public function __get($name)
    {
        $extensions = $this->get_extensions('get');
        if (method_exists($this, "get_$name"))
        {
            $extensions[] = array($this, "get_$name");
        }
        
        $return = array();
        $returnarray = false;
        foreach ($extensions as $extension)
        {
            if (($extreturn = call_user_func($extension, $this->dom, $name)) !== null)
            {
                if (is_array($extreturn))
                {
                    $returnarray = true;
                    $return = array_merge_recursive($extreturn, $return);
                }
                else
                {
                    $return[] = $extreturn;
                }
            }
        }
        
        if ($return)
        {
            if ($returnarray)
                return $return;
            else
                return $return[0];
        }
    }
}

Data::add_static_extension_point('get');
