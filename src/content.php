<?php

class SimplePie_Content
{
	public function __construct($node, $type)
	{
		$this->node = $node;
		$this->type = $type;
	}
	
	public static function from_escaped_html($escaped_node)
	{
		$dom = new DOMDocument();
		$dom->documentURI = $escaped_node->baseURI;
		$dom->loadHTML('<div>' . $escaped_node->textContent);
		$node = $dom->getElementsByTagName('div');
		$node = $node[0];
		return new SimplePie_Content($node, 'text/html');
	}
}