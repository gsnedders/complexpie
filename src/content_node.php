<?php

class SimplePie_Content_Node extends SimplePie_Content
{
    protected $node;
    
	public function __construct($node)
	{
		if ($node instanceof DOMNodeList)
		{
			$new_node = array();
			foreach ($node as $n)
				$new_node[] = $n;
			$node = $new_node;
		}
		if (is_array($node) && count($node) === 1)
		{
			$node = $node[0];
		}
		$this->node = $node;
	}
	
	public function get_node()
	{
		return $this->node;
	}
	
	public function to_text()
	{
		if (is_array($this->node))
		{
			$text = '';
			foreach ($this->node as $node)
			{
				$text .= $node->textContent;
			}
			return $text;
		}
		else
		{
			return $this->node->textContent;
		}
	}
	
	public function to_xml()
	{
		if (is_array($this->node))
		{
			$xml = '';
			foreach ($this->node as $node)
			{
				$document = $node instanceof DOMDocument ? $node : $node->ownerDocument;
				$xml .= $document->saveXML($node);
			}
			return $xml;
		}
		else
		{
			$document = $this->node instanceof DOMDocument ? $this->node : $this->node->ownerDocument;
			return $document->saveXML($this->node);
		}
	}
}