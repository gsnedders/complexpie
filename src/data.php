<?php
namespace ComplexPie;

class Data extends Extension
{
    protected static $static_ext = array();
    
    public static function add_static_extension($extpoint, $ext, $priority)
    {
        if ($extpoint === 'get' && !is_callable($ext))
        {
            throw new Excetpion("$ext is not callable");
        }
        parent::add_static_extension($extpoint, $ext, $priority);
    }
    
    public function add_extension($extpoint, $ext, $priority)
    {
        if ($extpoint === 'get' && !is_callable($ext))
        {
            throw new Excetpion("$ext is not callable");
        }
        parent::add_extension($extpoint, $ext, $priority);
    }
    
    /**
     * @todo This should cope with things that return an array and merge them
     */
    public function __get($name)
    {
        foreach ($this->get_extensions('get') as $extension => $priority)
        {
            if (($return = $extension($this->dom, $name)) !== null)
            {
                return $return;
            }
        }
        if (method_exists($this, "get_$name"))
        {
            return call_user_func(array($this, "get_$name"));
        }
    }
}

Data::add_static_extension_point('get');
