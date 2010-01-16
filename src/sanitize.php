<?php

/**
 * @todo Move to using an actual HTML parser (this will allow tags to be properly stripped, and to switch between HTML and XHTML), this will also make it easier to shorten a string while preserving HTML tags
 */
class SimplePie_Sanitize
{
	// Private vars
	var $base;

	var $replace_url_attributes = array(
		'a' => 'href',
		'area' => 'href',
		'blockquote' => 'cite',
		'del' => 'cite',
		'form' => 'action',
		'img' => array('longdesc', 'src'),
		'input' => 'src',
		'ins' => 'cite',
		'q' => 'cite'
	);

	/**
	 * Set element/attribute key/value pairs of HTML attributes
	 * containing URLs that need to be resolved relative to the feed
	 *
	 * @access public
	 * @since 1.0
	 * @param array $element_attribute Element/attribute key/value pairs
	 */
	public function set_url_replacements($element_attribute = array('a' => 'href', 'area' => 'href', 'blockquote' => 'cite', 'del' => 'cite', 'form' => 'action', 'img' => array('longdesc', 'src'), 'input' => 'src', 'ins' => 'cite', 'q' => 'cite'))
	{
		$this->replace_url_attributes = (array) $element_attribute;
	}

	public function sanitize($data, $type, $base = '')
	{
		$data = trim($data);
		if ($data !== '' || $type & SIMPLEPIE_CONSTRUCT_IRI)
		{
			if ($type & SIMPLEPIE_CONSTRUCT_BASE64)
			{
				$data = base64_decode($data);
			}

			if ($type & SIMPLEPIE_CONSTRUCT_XHTML)
			{
				$data = preg_replace('/^<div' . SIMPLEPIE_PCRE_XML_ATTRIBUTE . '>/', '', $data);
				$data = preg_replace('/<\/div>$/', '', $data);
			}

			if ($type & (SIMPLEPIE_CONSTRUCT_HTML | SIMPLEPIE_CONSTRUCT_XHTML))
			{
				// Replace relative URLs
				$this->base = $base;
				foreach ($this->replace_url_attributes as $element => $attributes)
				{
					$data = $this->replace_urls($data, $element, $attributes);
				}

				// Having (possibly) taken stuff out, there may now be whitespace at the beginning/end of the data
				$data = trim($data);
			}

			if ($type & SIMPLEPIE_CONSTRUCT_IRI)
			{
				$data = SimplePie_Misc::absolutize_url($data, $base);
			}

			if ($type & (SIMPLEPIE_CONSTRUCT_TEXT | SIMPLEPIE_CONSTRUCT_IRI))
			{
				$data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
			}
		}
		return $data;
	}

	public function replace_urls($data, $tag, $attributes)
	{
		$elements = SimplePie_Misc::get_element($tag, $data);
		foreach ($elements as $element)
		{
			if (is_array($attributes))
			{
				foreach ($attributes as $attribute)
				{
					if (isset($element['attribs'][$attribute]['data']))
					{
						$element['attribs'][$attribute]['data'] = SimplePie_Misc::absolutize_url($element['attribs'][$attribute]['data'], $this->base);
						$new_element = SimplePie_Misc::element_implode($element);
						$data = str_replace($element['full'], $new_element, $data);
						$element['full'] = $new_element;
					}
				}
			}
			elseif (isset($element['attribs'][$attributes]['data']))
			{
				$element['attribs'][$attributes]['data'] = SimplePie_Misc::absolutize_url($element['attribs'][$attributes]['data'], $this->base);
				$data = str_replace($element['full'], SimplePie_Misc::element_implode($element), $data);
			}
		}
		return $data;
	}
}