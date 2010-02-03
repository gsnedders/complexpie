<?php
namespace ComplexPie;

/**
 * IRI parser/serialiser
 *
 * @package SimplePie
 */
class IRI
{
	/**
	 * Scheme
	 *
	 * @access private
	 * @var string
	 */
	var $scheme;

	/**
	 * User Information
	 *
	 * @access private
	 * @var string
	 */
	var $userinfo;

	/**
	 * Host
	 *
	 * @access private
	 * @var string
	 */
	var $host;

	/**
	 * Port
	 *
	 * @access private
	 * @var string
	 */
	var $port;

	/**
	 * Path
	 *
	 * @access private
	 * @var string
	 */
	var $path;

	/**
	 * Query
	 *
	 * @access private
	 * @var string
	 */
	var $query;

	/**
	 * Fragment
	 *
	 * @access private
	 * @var string
	 */
	var $fragment;

	/**
	 * Whether the object represents a valid IRI
	 *
	 * @access private
	 * @var array
	 */
	var $valid = array();

	/**
	 * Return the entire IRI when you try and read the object as a string
	 *
	 * @access public
	 * @return string
	 */
	public function __toString()
	{
		return $this->get_iri();
	}

	/**
	 * Create a new IRI object, from a specified string
	 *
	 * @access public
	 * @param string $iri
	 * @return IRI
	 */
	public function __construct($iri)
	{
		$iri = (string) $iri;
		if ($iri !== '')
		{
			$parsed = $this->parse_iri($iri);
			$this->set_scheme($parsed['scheme']);
			$this->set_authority($parsed['authority']);
			$this->set_path($parsed['path']);
			$this->set_query($parsed['query']);
			$this->set_fragment($parsed['fragment']);
		}
	}

	/**
	 * Create a new IRI object by resolving a relative IRI
	 *
	 * @param IRI $base Base IRI
	 * @param string $relative Relative IRI
	 * @return IRI
	 */
	public static function absolutize($base, $relative)
	{
		$relative = (string) $relative;
		if ($relative !== '')
		{
			$relative = new IRI($relative);
			if ($relative->get_scheme() !== null)
			{
				$target = $relative;
			}
			elseif ($base->get_iri() !== null)
			{
				if ($relative->get_authority() !== null)
				{
					$target = $relative;
					$target->set_scheme($base->get_scheme());
				}
				else
				{
					$target = new IRI('');
					$target->set_scheme($base->get_scheme());
					$target->set_userinfo($base->get_userinfo());
					$target->set_host($base->get_host());
					$target->set_port($base->get_port());
					if ($relative->get_path() !== null)
					{
						if (strpos($relative->get_path(), '/') === 0)
						{
							$target->set_path($relative->get_path());
						}
						elseif (($base->get_userinfo() !== null || $base->get_host() !== null || $base->get_port() !== null) && $base->get_path() === null)
						{
							$target->set_path('/' . $relative->get_path());
						}
						elseif (($last_segment = strrpos($base->get_path(), '/')) !== false)
						{
							$target->set_path(substr($base->get_path(), 0, $last_segment + 1) . $relative->get_path());
						}
						else
						{
							$target->set_path($relative->get_path());
						}
						$target->set_query($relative->get_query());
					}
					else
					{
						$target->set_path($base->get_path());
						if ($relative->get_query() !== null)
						{
							$target->set_query($relative->get_query());
						}
						elseif ($base->get_query() !== null)
						{
							$target->set_query($base->get_query());
						}
					}
				}
				$target->set_fragment($relative->get_fragment());
			}
			else
			{
				// No base URL, just return the relative URL
				$target = $relative;
			}
		}
		else
		{
			$target = $base;
		}
		return $target;
	}

	/**
	 * Parse an IRI into scheme/authority/path/query/fragment segments
	 *
	 * @access private
	 * @param string $iri
	 * @return array
	 */
	public function parse_iri($iri)
	{
		preg_match('/^(([^:\/?#]+):)?(\/\/([^\/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?$/', $iri, $match);
		for ($i = count($match); $i <= 9; $i++)
		{
			$match[$i] = '';
		}
		return array('scheme' => $match[2], 'authority' => $match[4], 'path' => $match[5], 'query' => $match[7], 'fragment' => $match[9]);
	}

	/**
	 * Remove dot segments from a path
	 *
	 * @access private
	 * @param string $input
	 * @return string
	 */
	public function remove_dot_segments($input)
	{
		$output = '';
		while (strpos($input, './') !== false || strpos($input, '/.') !== false || $input === '.' || $input === '..')
		{
			// A: If the input buffer begins with a prefix of "../" or "./", then remove that prefix from the input buffer; otherwise,
			if (strpos($input, '../') === 0)
			{
				$input = substr($input, 3);
			}
			elseif (strpos($input, './') === 0)
			{
				$input = substr($input, 2);
			}
			// B: if the input buffer begins with a prefix of "/./" or "/.", where "." is a complete path segment, then replace that prefix with "/" in the input buffer; otherwise,
			elseif (strpos($input, '/./') === 0)
			{
				$input = substr_replace($input, '/', 0, 3);
			}
			elseif ($input === '/.')
			{
				$input = '/';
			}
			// C: if the input buffer begins with a prefix of "/../" or "/..", where ".." is a complete path segment, then replace that prefix with "/" in the input buffer and remove the last segment and its preceding "/" (if any) from the output buffer; otherwise,
			elseif (strpos($input, '/../') === 0)
			{
				$input = substr_replace($input, '/', 0, 4);
				$output = substr_replace($output, '', strrpos($output, '/'));
			}
			elseif ($input === '/..')
			{
				$input = '/';
				$output = substr_replace($output, '', strrpos($output, '/'));
			}
			// D: if the input buffer consists only of "." or "..", then remove that from the input buffer; otherwise,
			elseif ($input === '.' || $input === '..')
			{
				$input = '';
			}
			// E: move the first path segment in the input buffer to the end of the output buffer, including the initial "/" character (if any) and any subsequent characters up to, but not including, the next "/" character or the end of the input buffer
			elseif (($pos = strpos($input, '/', 1)) !== false)
			{
				$output .= substr($input, 0, $pos);
				$input = substr_replace($input, '', 0, $pos);
			}
			else
			{
				$output .= $input;
				$input = '';
			}
		}
		return $output . $input;
	}

	/**
	 * Replace invalid character with percent encoding
	 *
	 * @access private
	 * @param string $string Input string
	 * @param string $valid_chars Valid characters
	 * @param int $case Normalise case
	 * @return string
	 */
	public function replace_invalid_with_pct_encoding($string, $valid_chars, $case = SAME_CASE)
	{
		// Normalise case
		if ($case & LOWERCASE)
		{
			$string = strtolower($string);
		}
		elseif ($case & UPPERCASE)
		{
			$string = strtoupper($string);
		}

		// Store position and string length (to avoid constantly recalculating this)
		$position = 0;
		$strlen = strlen($string);

		// Loop as long as we have invalid characters, advancing the position to the next invalid character
		while (($position += strspn($string, $valid_chars, $position)) < $strlen)
		{
			// If we have a % character
			if ($string[$position] === '%')
			{
				// If we have a pct-encoded section
				if ($position + 2 < $strlen && strspn($string, '0123456789ABCDEFabcdef', $position + 1, 2) === 2)
				{
					// Get the the represented character
					$chr = chr(hexdec(substr($string, $position + 1, 2)));

					// If the character is valid, replace the pct-encoded with the actual character while normalising case
					if (strpos($valid_chars, $chr) !== false)
					{
						if ($case & LOWERCASE)
						{
							$chr = strtolower($chr);
						}
						elseif ($case & UPPERCASE)
						{
							$chr = strtoupper($chr);
						}
						$string = substr_replace($string, $chr, $position, 3);
						$strlen -= 2;
						$position++;
					}

					// Otherwise just normalise the pct-encoded to uppercase
					else
					{
						$string = substr_replace($string, strtoupper(substr($string, $position + 1, 2)), $position + 1, 2);
						$position += 3;
					}
				}
				// If we don't have a pct-encoded section, just replace the % with its own esccaped form
				else
				{
					$string = substr_replace($string, '%25', $position, 1);
					$strlen += 2;
					$position += 3;
				}
			}
			// If we have an invalid character, change into its pct-encoded form
			else
			{
				$replacement = sprintf("%%%02X", ord($string[$position]));
				$string = str_replace($string[$position], $replacement, $string);
				$strlen = strlen($string);
			}
		}
		return $string;
	}

	/**
	 * Check if the object represents a valid IRI
	 *
	 * @access public
	 * @return bool
	 */
	public function is_valid()
	{
		return array_sum($this->valid) === count($this->valid);
	}

	/**
	 * Set the scheme. Returns true on success, false on failure (if there are
	 * any invalid characters).
	 *
	 * @access public
	 * @param string $scheme
	 * @return bool
	 */
	public function set_scheme($scheme)
	{
		if ($scheme === null || $scheme === '')
		{
			$this->scheme = null;
		}
		else
		{
			$len = strlen($scheme);
			switch (true)
			{
				case $len > 1:
					if (!strspn($scheme, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+-.', 1))
					{
						$this->scheme = null;
						$this->valid[__FUNCTION__] = false;
						return false;
					}

				case $len > 0:
					if (!strspn($scheme, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', 0, 1))
					{
						$this->scheme = null;
						$this->valid[__FUNCTION__] = false;
						return false;
					}
			}
			$this->scheme = strtolower($scheme);
		}
		$this->valid[__FUNCTION__] = true;
		return true;
	}

	/**
	 * Set the authority. Returns true on success, false on failure (if there are
	 * any invalid characters).
	 *
	 * @access public
	 * @param string $authority
	 * @return bool
	 */
	public function set_authority($authority)
	{
		if (($userinfo_end = strrpos($authority, '@')) !== false)
		{
			$userinfo = substr($authority, 0, $userinfo_end);
			$authority = substr($authority, $userinfo_end + 1);
		}
		else
		{
			$userinfo = null;
		}

		if (($port_start = strpos($authority, ':')) !== false)
		{
			$port = substr($authority, $port_start + 1);
			$authority = substr($authority, 0, $port_start);
		}
		else
		{
			$port = null;
		}

		return $this->set_userinfo($userinfo) && $this->set_host($authority) && $this->set_port($port);
	}

	/**
	 * Set the userinfo.
	 *
	 * @access public
	 * @param string $userinfo
	 * @return bool
	 */
	public function set_userinfo($userinfo)
	{
		if ($userinfo === null || $userinfo === '')
		{
			$this->userinfo = null;
		}
		else
		{
			$this->userinfo = $this->replace_invalid_with_pct_encoding($userinfo, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~!$&\'()*+,;=:');
		}
		$this->valid[__FUNCTION__] = true;
		return true;
	}

	/**
	 * Set the host. Returns true on success, false on failure (if there are
	 * any invalid characters).
	 *
	 * @access public
	 * @param string $host
	 * @return bool
	 */
	public function set_host($host)
	{
		if ($host === null || $host === '')
		{
			$this->host = null;
			$this->valid[__FUNCTION__] = true;
			return true;
		}
		elseif ($host[0] === '[' && substr($host, -1) === ']')
		{
			if (Net_IPv6::checkIPv6(substr($host, 1, -1)))
			{
				$this->host = $host;
				$this->valid[__FUNCTION__] = true;
				return true;
			}
			else
			{
				$this->host = null;
				$this->valid[__FUNCTION__] = false;
				return false;
			}
		}
		else
		{
			$this->host = $this->replace_invalid_with_pct_encoding($host, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~!$&\'()*+,;=', LOWERCASE);
			$this->valid[__FUNCTION__] = true;
			return true;
		}
	}

	/**
	 * Set the port. Returns true on success, false on failure (if there are
	 * any invalid characters).
	 *
	 * @access public
	 * @param string $port
	 * @return bool
	 */
	public function set_port($port)
	{
		if ($port === null || $port === '')
		{
			$this->port = null;
			$this->valid[__FUNCTION__] = true;
			return true;
		}
		elseif (strspn($port, '0123456789') === strlen($port))
		{
			$this->port = (int) $port;
			$this->valid[__FUNCTION__] = true;
			return true;
		}
		else
		{
			$this->port = null;
			$this->valid[__FUNCTION__] = false;
			return false;
		}
	}

	/**
	 * Set the path.
	 *
	 * @access public
	 * @param string $path
	 * @return bool
	 */
	public function set_path($path)
	{
		if ($path === null || $path === '')
		{
			$this->path = null;
			$this->valid[__FUNCTION__] = true;
			return true;
		}
		elseif (substr($path, 0, 2) === '//' && $this->userinfo === null && $this->host === null && $this->port === null)
		{
			$this->path = null;
			$this->valid[__FUNCTION__] = false;
			return false;
		}
		else
		{
			$this->path = $this->replace_invalid_with_pct_encoding($path, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~!$&\'()*+,;=@/');
			if ($this->scheme !== null)
			{
				$this->path = $this->remove_dot_segments($this->path);
			}
			$this->valid[__FUNCTION__] = true;
			return true;
		}
	}

	/**
	 * Set the query.
	 *
	 * @access public
	 * @param string $query
	 * @return bool
	 */
	public function set_query($query)
	{
		if ($query === null || $query === '')
		{
			$this->query = null;
		}
		else
		{
			$this->query = $this->replace_invalid_with_pct_encoding($query, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~!$\'()*+,;:@/?');
		}
		$this->valid[__FUNCTION__] = true;
		return true;
	}

	/**
	 * Set the fragment.
	 *
	 * @access public
	 * @param string $fragment
	 * @return bool
	 */
	public function set_fragment($fragment)
	{
		if ($fragment === null || $fragment === '')
		{
			$this->fragment = null;
		}
		else
		{
			$this->fragment = $this->replace_invalid_with_pct_encoding($fragment, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~!$&\'()*+,;=:@/?');
		}
		$this->valid[__FUNCTION__] = true;
		return true;
	}

	/**
	 * Get the complete IRI
	 *
	 * @access public
	 * @return string
	 */
	public function get_iri()
	{
		$iri = '';
		if ($this->scheme !== null)
		{
			$iri .= $this->scheme . ':';
		}
		if (($authority = $this->get_authority()) !== null)
		{
			$iri .= '//' . $authority;
		}
		if ($this->path !== null)
		{
			$iri .= $this->path;
		}
		if ($this->query !== null)
		{
			$iri .= '?' . $this->query;
		}
		if ($this->fragment !== null)
		{
			$iri .= '#' . $this->fragment;
		}

		if ($iri !== '')
		{
			return $iri;
		}
		else
		{
			return null;
		}
	}

	/**
	 * Get the scheme
	 *
	 * @access public
	 * @return string
	 */
	public function get_scheme()
	{
		return $this->scheme;
	}

	/**
	 * Get the complete authority
	 *
	 * @access public
	 * @return string
	 */
	public function get_authority()
	{
		$authority = '';
		if ($this->userinfo !== null)
		{
			$authority .= $this->userinfo . '@';
		}
		if ($this->host !== null)
		{
			$authority .= $this->host;
		}
		if ($this->port !== null)
		{
			$authority .= ':' . $this->port;
		}

		if ($authority !== '')
		{
			return $authority;
		}
		else
		{
			return null;
		}
	}

	/**
	 * Get the user information
	 *
	 * @access public
	 * @return string
	 */
	public function get_userinfo()
	{
		return $this->userinfo;
	}

	/**
	 * Get the host
	 *
	 * @access public
	 * @return string
	 */
	public function get_host()
	{
		return $this->host;
	}

	/**
	 * Get the port
	 *
	 * @access public
	 * @return string
	 */
	public function get_port()
	{
		return $this->port;
	}

	/**
	 * Get the path
	 *
	 * @access public
	 * @return string
	 */
	public function get_path()
	{
		return $this->path;
	}

	/**
	 * Get the query
	 *
	 * @access public
	 * @return string
	 */
	public function get_query()
	{
		return $this->query;
	}

	/**
	 * Get the fragment
	 *
	 * @access public
	 * @return string
	 */
	public function get_fragment()
	{
		return $this->fragment;
	}
}

/**
 * Class to validate and to work with IPv6 addresses.
 *
 * @package SimplePie
 * @copyright 2003-2005 The PHP Group
 * @license http://www.opensource.org/licenses/bsd-license.php
 * @link http://pear.php.net/package/Net_IPv6
 * @author Alexander Merz <alexander.merz@web.de>
 * @author elfrink at introweb dot nl
 * @author Josh Peck <jmp at joshpeck dot org>
 * @author Geoffrey Sneddon <geoffers@gmail.com>
 */
class Net_IPv6
{
	/**
	 * Removes a possible existing netmask specification of an IP address.
	 *
	 * @param string $ip the (compressed) IP as Hex representation
	 * @return string the IP the without netmask
	 * @since 1.1.0
	 */
	public static function removeNetmaskSpec($ip)
	{
		if (strpos($ip, '/') !== false)
		{
			list($addr, $nm) = explode('/', $ip);
		}
		else
		{
			$addr = $ip;
		}
		return $addr;
	}

	/**
	 * Uncompresses an IPv6 address
	 *
	 * RFC 2373 allows you to compress zeros in an address to '::'. This
	 * function expects an valid IPv6 address and expands the '::' to
	 * the required zeros.
	 *
	 * Example:	 FF01::101	->	FF01:0:0:0:0:0:0:101
	 *			 ::1		->	0:0:0:0:0:0:0:1
	 *
	 * @access public
	 * @static
	 * @param string $ip a valid IPv6-address (hex format)
	 * @return string the uncompressed IPv6-address (hex format)
	 */
	public static function Uncompress($ip)
	{
		$uip = Net_IPv6::removeNetmaskSpec($ip);
		$c1 = -1;
		$c2 = -1;
		if (strpos($ip, '::') !== false)
		{
			list($ip1, $ip2) = explode('::', $ip);
			if ($ip1 === '')
			{
				$c1 = -1;
			}
			else
			{
				$pos = 0;
				if (($pos = substr_count($ip1, ':')) > 0)
				{
					$c1 = $pos;
				}
				else
				{
					$c1 = 0;
				}
			}
			if ($ip2 === '')
			{
				$c2 = -1;
			}
			else
			{
				$pos = 0;
				if (($pos = substr_count($ip2, ':')) > 0)
				{
					$c2 = $pos;
				}
				else
				{
					$c2 = 0;
				}
			}
			if (strstr($ip2, '.'))
			{
				$c2++;
			}
			// ::
			if ($c1 === -1 && $c2 === -1)
			{
				$uip = '0:0:0:0:0:0:0:0';
			}
			// ::xxx
			else if ($c1 === -1)
			{
				$fill = str_repeat('0:', 7 - $c2);
				$uip =	str_replace('::', $fill, $uip);
			}
			// xxx::
			else if ($c2 === -1)
			{
				$fill = str_repeat(':0', 7 - $c1);
				$uip =	str_replace('::', $fill, $uip);
			}
			// xxx::xxx
			else
			{
				$fill = str_repeat(':0:', 6 - $c2 - $c1);
				$uip =	str_replace('::', $fill, $uip);
				$uip =	str_replace('::', ':', $uip);
			}
		}
		return $uip;
	}

	/**
	 * Splits an IPv6 address into the IPv6 and a possible IPv4 part
	 *
	 * RFC 2373 allows you to note the last two parts of an IPv6 address as
	 * an IPv4 compatible address
	 *
	 * Example:	 0:0:0:0:0:0:13.1.68.3
	 *			 0:0:0:0:0:FFFF:129.144.52.38
	 *
	 * @access public
	 * @static
	 * @param string $ip a valid IPv6-address (hex format)
	 * @return array [0] contains the IPv6 part, [1] the IPv4 part (hex format)
	 */
	public static function SplitV64($ip)
	{
		$ip = Net_IPv6::Uncompress($ip);
		if (strstr($ip, '.'))
		{
			$pos = strrpos($ip, ':');
			$ip[$pos] = '_';
			$ipPart = explode('_', $ip);
			return $ipPart;
		}
		else
		{
			return array($ip, '');
		}
	}

	/**
	 * Checks an IPv6 address
	 *
	 * Checks if the given IP is IPv6-compatible
	 *
	 * @access public
	 * @static
	 * @param string $ip a valid IPv6-address
	 * @return bool true if $ip is an IPv6 address
	 */
	public static function checkIPv6($ip)
	{
		$ipPart = Net_IPv6::SplitV64($ip);
		$count = 0;
		if (!empty($ipPart[0]))
		{
			$ipv6 = explode(':', $ipPart[0]);
			for ($i = 0; $i < count($ipv6); $i++)
			{
				$dec = hexdec($ipv6[$i]);
				$hex = strtoupper(preg_replace('/^[0]{1,3}(.*[0-9a-fA-F])$/', '\\1', $ipv6[$i]));
				if ($ipv6[$i] >= 0 && $dec <= 65535 && $hex === strtoupper(dechex($dec)))
				{
					$count++;
				}
			}
			if ($count === 8)
			{
				return true;
			}
			elseif ($count === 6 && !empty($ipPart[1]))
			{
				$ipv4 = explode('.', $ipPart[1]);
				$count = 0;
				foreach ($ipv4 as $ipv4_part)
				{
					if ($ipv4_part >= 0 && $ipv4_part <= 255 && preg_match('/^\d{1,3}$/', $ipv4_part))
					{
						$count++;
					}
				}
				if ($count === 4)
				{
					return true;
				}
			}
			else
			{
				return false;
			}

		}
		else
		{
			return false;
		}
	}
}
