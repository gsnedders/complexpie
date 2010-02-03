<?php
namespace ComplexPie;

class Content_String extends Content
{
    protected $string;
    
	public function __construct($string)
	{
		$this->string = $string;
	}
	
	public function to_text()
	{
		return $this->string;
	}
	
	public function to_xml()
	{
		return htmlspecialchars($this->string, ENT_QUOTES, 'UTF-8');
	}
}
