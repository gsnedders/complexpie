<?php

abstract class SimplePie_Data
{
	private $extensions = array();
	
	/**
	 * @todo This should cope with things that return an array and merge them
	 */
	public function __get($name)
	{
		foreach ($this->extensions as $extension => $priority)
		{
			if (is_callable($extension))
			{
				if (($return = $extension($this->dom, $name)) !== null)
				{
					return $return;
				}
			}
			elseif (($return = $extension->$name) !== null)
			{
				return $return;
			}
		}
		if (method_exists($this, "get_$name"))
		{
			return call_user_func(array($this, "get_$name"));
		}
	}
	
	public function add_getter($classfunc, $priority)
	{
		if (is_callable($classfunc))
		{
			$this->extensions[$classfunc] = $priority;
		}
		elseif (class_exists($classfunc))
		{
			$this->extensions[new $classfunc($this->dom)] = $priority;
		}
		else
		{
			throw new Exception('Cannot add ' . print_r($classfunc, true) . ' as getter as it is neither callable nor a class name');
		}
		asort($this->extensions);
	}
}
