<?php

class SimplePie_Misc
{
	public static function absolutize_url($relative, $base)
	{
		$iri = SimplePie_IRI::absolutize(new SimplePie_IRI($base), $relative);
		return $iri->get_iri();
	}

	public static function get_element($realname, $string)
	{
		$return = array();
		$name = preg_quote($realname, '/');
		if (preg_match_all("/<($name)" . SIMPLEPIE_PCRE_HTML_ATTRIBUTE . "(>(.*)<\/$name>|(\/)?>)/siU", $string, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE))
		{
			for ($i = 0, $total_matches = count($matches); $i < $total_matches; $i++)
			{
				$return[$i]['tag'] = $realname;
				$return[$i]['full'] = $matches[$i][0][0];
				$return[$i]['offset'] = $matches[$i][0][1];
				if (strlen($matches[$i][3][0]) <= 2)
				{
					$return[$i]['self_closing'] = true;
				}
				else
				{
					$return[$i]['self_closing'] = false;
					$return[$i]['content'] = $matches[$i][4][0];
				}
				$return[$i]['attribs'] = array();
				if (isset($matches[$i][2][0]) && preg_match_all('/[\x09\x0A\x0B\x0C\x0D\x20]+([^\x09\x0A\x0B\x0C\x0D\x20\x2F\x3E][^\x09\x0A\x0B\x0C\x0D\x20\x2F\x3D\x3E]*)(?:[\x09\x0A\x0B\x0C\x0D\x20]*=[\x09\x0A\x0B\x0C\x0D\x20]*(?:"([^"]*)"|\'([^\']*)\'|([^\x09\x0A\x0B\x0C\x0D\x20\x22\x27\x3E][^\x09\x0A\x0B\x0C\x0D\x20\x3E]*)?))?/', ' ' . $matches[$i][2][0] . ' ', $attribs, PREG_SET_ORDER))
				{
					for ($j = 0, $total_attribs = count($attribs); $j < $total_attribs; $j++)
					{
						if (count($attribs[$j]) === 2)
						{
							$attribs[$j][2] = $attribs[$j][1];
						}
						$return[$i]['attribs'][strtolower($attribs[$j][1])]['data'] = SimplePie_Misc::entities_decode(end($attribs[$j]), 'UTF-8');
					}
				}
			}
		}
		return $return;
	}

	public static function element_implode($element)
	{
		$full = "<$element[tag]";
		foreach ($element['attribs'] as $key => $value)
		{
			$key = strtolower($key);
			$full .= " $key=\"" . htmlspecialchars($value['data']) . '"';
		}
		if ($element['self_closing'])
		{
			$full .= ' />';
		}
		else
		{
			$full .= ">$element[content]</$element[tag]>";
		}
		return $full;
	}

	public static function error($message, $level, $file, $line)
	{
		if ((ini_get('error_reporting') & $level) > 0)
		{
			switch ($level)
			{
				case E_USER_ERROR:
					$note = 'PHP Error';
					break;
				case E_USER_WARNING:
					$note = 'PHP Warning';
					break;
				case E_USER_NOTICE:
					$note = 'PHP Notice';
					break;
				default:
					$note = 'Unknown Error';
					break;
			}

			$log_error = true;
			if (!function_exists('error_log'))
			{
				$log_error = false;
			}

			$log_file = @ini_get('error_log');
			if (!empty($log_file) && ('syslog' != $log_file) && !@is_writable($log_file))
			{
				$log_error = false;
			}

			if ($log_error)
			{
				@error_log("$note: $message in $file on line $line", 0);
			}
		}

		return $message;
	}

	public static function parse_date($dt)
	{
		$parser = SimplePie_Parse_Date::get();
		return $parser->parse($dt);
	}

	/**
	 * Decode HTML entities
	 *
	 * @param string $data Input data
	 * @return string Output data
	 */
	public static function entities_decode($data)
	{
		$decoder = new SimplePie_Decode_HTML_Entities($data);
		return $decoder->parse();
	}

	public static function atom_03_construct_type($attribs)
	{
		if (isset($attribs['']['mode']) && strtolower(trim($attribs['']['mode']) === 'base64'))
		{
			$mode = SIMPLEPIE_CONSTRUCT_BASE64;
		}
		else
		{
			$mode = SIMPLEPIE_CONSTRUCT_NONE;
		}
		if (isset($attribs['']['type']))
		{
			switch (strtolower(trim($attribs['']['type'])))
			{
				case 'text':
				case 'text/plain':
					return SIMPLEPIE_CONSTRUCT_TEXT | $mode;

				case 'html':
				case 'text/html':
					return SIMPLEPIE_CONSTRUCT_HTML | $mode;

				case 'xhtml':
				case 'application/xhtml+xml':
					return SIMPLEPIE_CONSTRUCT_XHTML | $mode;

				default:
					return SIMPLEPIE_CONSTRUCT_NONE | $mode;
			}
		}
		else
		{
			return SIMPLEPIE_CONSTRUCT_TEXT | $mode;
		}
	}

	public static function atom_10_construct_type($attribs)
	{
		if (isset($attribs['']['type']))
		{
			switch (strtolower(trim($attribs['']['type'])))
			{
				case 'text':
					return SIMPLEPIE_CONSTRUCT_TEXT;

				case 'html':
					return SIMPLEPIE_CONSTRUCT_HTML;

				case 'xhtml':
					return SIMPLEPIE_CONSTRUCT_XHTML;

				default:
					return SIMPLEPIE_CONSTRUCT_NONE;
			}
		}
		return SIMPLEPIE_CONSTRUCT_TEXT;
	}

	public static function atom_10_content_construct_type($attribs)
	{
		if (isset($attribs['']['type']))
		{
			$type = strtolower(trim($attribs['']['type']));
			switch ($type)
			{
				case 'text':
					return SIMPLEPIE_CONSTRUCT_TEXT;

				case 'html':
					return SIMPLEPIE_CONSTRUCT_HTML;

				case 'xhtml':
					return SIMPLEPIE_CONSTRUCT_XHTML;
			}
			if (in_array(substr($type, -4), array('+xml', '/xml')) || substr($type, 0, 5) === 'text/')
			{
				return SIMPLEPIE_CONSTRUCT_NONE;
			}
			else
			{
				return SIMPLEPIE_CONSTRUCT_BASE64;
			}
		}
		else
		{
			return SIMPLEPIE_CONSTRUCT_TEXT;
		}
	}

	public static function is_isegment_nz_nc($string)
	{
		return (bool) preg_match('/^([A-Za-z0-9\-._~\x{A0}-\x{D7FF}\x{F900}-\x{FDCF}\x{FDF0}-\x{FFEF}\x{10000}-\x{1FFFD}\x{20000}-\x{2FFFD}\x{30000}-\x{3FFFD}\x{40000}-\x{4FFFD}\x{50000}-\x{5FFFD}\x{60000}-\x{6FFFD}\x{70000}-\x{7FFFD}\x{80000}-\x{8FFFD}\x{90000}-\x{9FFFD}\x{A0000}-\x{AFFFD}\x{B0000}-\x{BFFFD}\x{C0000}-\x{CFFFD}\x{D0000}-\x{DFFFD}\x{E1000}-\x{EFFFD}!$&\'()*+,;=@]|(%[0-9ABCDEF]{2}))+$/u', $string);
	}

	/**
	 * Converts a unicode codepoint to a UTF-8 character
	 *
	 * @param int $codepoint Unicode codepoint
	 * @return string UTF-8 character
	 */
	public static function codepoint_to_utf8($codepoint)
	{
		$codepoint = (int) $codepoint;
		if ($codepoint < 0)
		{
			return false;
		}
		else if ($codepoint <= 0x7f)
		{
			return chr($codepoint);
		}
		else if ($codepoint <= 0x7ff)
		{
			return chr(0xc0 | ($codepoint >> 6)) . chr(0x80 | ($codepoint & 0x3f));
		}
		else if ($codepoint <= 0xffff)
		{
			return chr(0xe0 | ($codepoint >> 12)) . chr(0x80 | (($codepoint >> 6) & 0x3f)) . chr(0x80 | ($codepoint & 0x3f));
		}
		else if ($codepoint <= 0x10ffff)
		{
			return chr(0xf0 | ($codepoint >> 18)) . chr(0x80 | (($codepoint >> 12) & 0x3f)) . chr(0x80 | (($codepoint >> 6) & 0x3f)) . chr(0x80 | ($codepoint & 0x3f));
		}
		else
		{
			// U+FFFD REPLACEMENT CHARACTER
			return "\xEF\xBF\xBD";
		}
	}
	
	public static function get_descendant($root, $query, $namespace_map = array(), $onlyfirst = false)
	{
		$doc = isset($root->ownerDocument) ? $root->ownerDocument : $root;
		$xpath = new DOMXPath($doc);
		foreach ($namespace_map as $prefix => $uri)
		{
			$xpath->registerNamespace($prefix, $uri);
		}
		$result = $xpath->query($query, $root);
		if ($onlyfirst)
			return $result->item(0);
		else
			return $result;
	}
}