<?php

class SimplePie_Enclosure
{
	var $length;
	var $link;
	var $type;

	// Constructor, used to input the data
	public function __construct($link = null, $type = null, $length = null)
	{
		$this->length = $length;
		$this->link = $link;
		$this->type = $type;
	}

	public function __toString()
	{
		// There is no $this->data here
		return md5(serialize($this));
	}

	public function get_length()
	{
		if ($this->length !== null)
		{
			return $this->length;
		}
		else
		{
			return null;
		}
	}

	public function get_link()
	{
		if ($this->link !== null)
		{
			return urldecode($this->link);
		}
		else
		{
			return null;
		}
	}

	public function get_type()
	{
		if ($this->type !== null)
		{
			return $this->type;
		}
		else
		{
			return null;
		}
	}
}