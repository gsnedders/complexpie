<?php

class SimplePie_Content
{
	public function __construct($node, $type)
	{
		if ($node instanceof DOMNodeList)
		{
			$new_node = array();
			foreach ($node as $n)
				$new_node[] = $n;
			$node = $new_node;
		}
		$this->node = $node;
		$this->type = $type;
	}
	
	public static function from_textcontent($root)
	{
		$dom = new DOMDocument();
		$dom->documentURI = $root->baseURI;
		$dom->appendChild($dom->createElement('SIMPLEPIE_INTERNAL'));
		$node = $dom->createTextNode($root->textContent);
		$dom->firstChild->appendChild($node);
		return new SimplePie_Content($node, 'text/plain');
	}
	
	public static function from_escaped_html($escaped_node)
	{
		$dom = new DOMDocument();
		$dom->documentURI = $escaped_node->baseURI;
		$dom->loadHTML('<div>' . $escaped_node->textContent);
		$node = $dom->getElementsByTagName('div');
		$node = $node[0];
		return new SimplePie_Content($node->childNodes, 'text/html');
	}
	
	public static function from_atom_text_construct($text_construct)
	{
		switch ($text_construct->getAttribute('type'))
		{
			case 'html':
				return self::from_escaped_html($text_construct);
			
			case 'xhtml':
				$div_count = null;
				foreach ($text_construct->childNodes as $child)
				{
					switch ($child->nodeType)
					{
						case XML_COMMENT_NODE:
							break;
						
						case XML_TEXT_NODE:
							if (strspn("\x09\x0A\x0D\x20", $child->data) === strlen($child->data))
								break;
						
						case XML_ELEMENT_NODE:
							if ($child->namespaceURI === 'http://www.w3.org/1999/xhtml' &&
								$child->localName === 'div')
							{
								$the_div = $child;
								$div_count++;
								break;
							}
						
						default:
							$div_count = false;
							break 2;
					}
				}
				$element = $div_count === 1 ? $the_div : $text_construct;
				$elements = array();
				foreach ($element->childNodes as $child)
				{
					$elements[] = $child;
				}
				return new SimplePie_Content($elements, 'application/xhtml+xml');
				
			default:
				return self::from_textcontent($text_construct);
		}
	}
}
