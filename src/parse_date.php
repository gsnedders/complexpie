<?php

/**
 * Date Parser
 *
 * @package SimplePie
 */
class SimplePie_Parse_Date
{
	/**
	 * Input data
	 *
	 * @access protected
	 * @var string
	 */
	var $date;

	/**
	 * List of days, calendar day name => ordinal day number in the week
	 *
	 * @access protected
	 * @var array
	 */
	var $day = array(
		'mon' => 1,
		'monday' => 1,
		'tue' => 2,
		'tuesday' => 2,
		'wed' => 3,
		'wednesday' => 3,
		'thu' => 4,
		'thursday' => 4,
		'fri' => 5,
		'friday' => 5,
		'sat' => 6,
		'saturday' => 6,
		'sun' => 7,
		'sunday' => 7,
	);

	/**
	 * List of months, calendar month name => calendar month number
	 *
	 * @access protected
	 * @var array
	 */
	var $month = array(
		'jan' => 1,
		'january' => 1,
		'feb' => 2,
		'february' => 2,
		'mar' => 3,
		'march' => 3,
		'apr' => 4,
		'april' => 4,
		'may' => 5,
		// No long form of May
		'jun' => 6,
		'june' => 6,
		'jul' => 7,
		'july' => 7,
		'aug' => 8,
		'august' => 8,
		'sep' => 9,
		'september' => 8,
		'oct' => 10,
		'october' => 10,
		'nov' => 11,
		'november' => 11,
		'dec' => 12,
		'december' => 12,
	);

	/**
	 * List of timezones, abbreviation => offset from UTC
	 *
	 * @access protected
	 * @var array
	 */
	var $timezone = array(
		'CDT' => -18000,
		'CST' => -21600,
		'EDT' => -14400,
		'EST' => -18000,
		'MDT' => -21600,
		'MST' => -25200,
		'PDT' => -25200,
		'PST' => -28800,
	);

	/**
	 * Cached PCRE for SimplePie_Parse_Date::$day
	 *
	 * @access protected
	 * @var string
	 */
	var $day_pcre;

	/**
	 * Cached PCRE for SimplePie_Parse_Date::$month
	 *
	 * @access protected
	 * @var string
	 */
	var $month_pcre;

	/**
	 * Array of user-added callback methods
	 *
	 * @access private
	 * @var array
	 */
	var $built_in = array();

	/**
	 * Array of user-added callback methods
	 *
	 * @access private
	 * @var array
	 */
	var $user = array();

	/**
	 * Create new SimplePie_Parse_Date object, and set self::day_pcre,
	 * self::month_pcre, and self::built_in
	 *
	 * @access private
	 */
	public function __construct()
	{
		$this->day_pcre = '(' . implode(array_keys($this->day), '|') . ')';
		$this->month_pcre = '(' . implode(array_keys($this->month), '|') . ')';

		static $cache;
		if (!isset($cache[get_class($this)]))
		{
			$all_methods = get_class_methods($this);

			foreach ($all_methods as $method)
			{
				if (strtolower(substr($method, 0, 5)) === 'date_')
				{
					$cache[get_class($this)][] = $method;
				}
			}
		}

		foreach ($cache[get_class($this)] as $method)
		{
			$this->built_in[] = $method;
		}
	}

	/**
	 * Get the object
	 *
	 * @access public
	 */
	public static function get()
	{
		static $object;
		if (!$object)
		{
			$object = new SimplePie_Parse_Date;
		}
		return $object;
	}

	/**
	 * Parse a date
	 *
	 * @final
	 * @access public
	 * @param string $date Date to parse
	 * @return int Timestamp corresponding to date string, or false on failure
	 */
	public function parse($date)
	{
		foreach ($this->user as $method)
		{
			if (($returned = call_user_func($method, $date)) !== false)
			{
				return $returned;
			}
		}

		foreach ($this->built_in as $method)
		{
			if (($returned = call_user_func(array(&$this, $method), $date)) !== false)
			{
				return $returned;
			}
		}

		return false;
	}

	/**
	 * Add a callback method to parse a date
	 *
	 * @final
	 * @access public
	 * @param callback $callback
	 */
	public function add_callback($callback)
	{
		if (is_callable($callback))
		{
			$this->user[] = $callback;
		}
		else
		{
			trigger_error('User-supplied function must be a valid callback', E_USER_WARNING);
		}
	}

	/**
	 * Parse a superset of W3C-DTF (allows hyphens and colons to be omitted, as
	 * well as allowing any of upper or lower case "T", horizontal tabs, or
	 * spaces to be used as the time seperator (including more than one))
	 *
	 * @access protected
	 * @return int Timestamp
	 */
	public function date_w3cdtf($date)
	{
		static $pcre;
		if (!$pcre)
		{
			$year = '([0-9]{4})';
			$month = $day = $hour = $minute = $second = '([0-9]{2})';
			$decimal = '([0-9]*)';
			$zone = '(?:(Z)|([+\-])([0-9]{1,2}):?([0-9]{1,2}))';
			$pcre = '/^' . $year . '(?:-?' . $month . '(?:-?' . $day . '(?:[Tt\x09\x20]+' . $hour . '(?::?' . $minute . '(?::?' . $second . '(?:.' . $decimal . ')?)?)?' . $zone . ')?)?)?$/';
		}
		if (preg_match($pcre, $date, $match))
		{
			/*
			Capturing subpatterns:
			1: Year
			2: Month
			3: Day
			4: Hour
			5: Minute
			6: Second
			7: Decimal fraction of a second
			8: Zulu
			9: Timezone ±
			10: Timezone hours
			11: Timezone minutes
			*/

			// Fill in empty matches
			for ($i = count($match); $i <= 3; $i++)
			{
				$match[$i] = '1';
			}

			for ($i = count($match); $i <= 7; $i++)
			{
				$match[$i] = '0';
			}

			// Numeric timezone
			if (isset($match[9]) && $match[9] !== '')
			{
				$timezone = $match[10] * 3600;
				$timezone += $match[11] * 60;
				if ($match[9] === '-')
				{
					$timezone = 0 - $timezone;
				}
			}
			else
			{
				$timezone = 0;
			}

			// Convert the number of seconds to an integer, taking decimals into account
			$second = round($match[6] + $match[7] / pow(10, strlen($match[7])));

			return gmmktime($match[4], $match[5], $second, $match[2], $match[3], $match[1]) - $timezone;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Remove RFC822 comments
	 *
	 * @access protected
	 * @param string $data Data to strip comments from
	 * @return string Comment stripped string
	 */
	public function remove_rfc2822_comments($string)
	{
		$string = (string) $string;
		$position = 0;
		$length = strlen($string);
		$depth = 0;

		$output = '';

		while ($position < $length && ($pos = strpos($string, '(', $position)) !== false)
		{
			$output .= substr($string, $position, $pos - $position);
			$position = $pos + 1;
			if ($string[$pos - 1] !== '\\')
			{
				$depth++;
				while ($depth && $position < $length)
				{
					$position += strcspn($string, '()', $position);
					if ($string[$position - 1] === '\\')
					{
						$position++;
						continue;
					}
					elseif (isset($string[$position]))
					{
						switch ($string[$position])
						{
							case '(':
								$depth++;
								break;

							case ')':
								$depth--;
								break;
						}
						$position++;
					}
					else
					{
						break;
					}
				}
			}
			else
			{
				$output .= '(';
			}
		}
		$output .= substr($string, $position);

		return $output;
	}

	/**
	 * Parse RFC2822's date format
	 *
	 * @access protected
	 * @return int Timestamp
	 */
	public function date_rfc2822($date)
	{
		static $pcre;
		if (!$pcre)
		{
			$wsp = '[\x09\x20]';
			$fws = '(?:' . $wsp . '+|' . $wsp . '*(?:\x0D\x0A' . $wsp . '+)+)';
			$optional_fws = $fws . '?';
			$day_name = $this->day_pcre;
			$month = $this->month_pcre;
			$day = '([0-9]{1,2})';
			$hour = $minute = $second = '([0-9]{2})';
			$year = '([0-9]{2,4})';
			$num_zone = '([+\-])([0-9]{2})([0-9]{2})';
			$character_zone = '([A-Z]{1,5})';
			$zone = '(?:' . $num_zone . '|' . $character_zone . ')';
			$pcre = '/(?:' . $optional_fws . $day_name . $optional_fws . ',)?' . $optional_fws . $day . $fws . $month . $fws . $year . $fws . $hour . $optional_fws . ':' . $optional_fws . $minute . '(?:' . $optional_fws . ':' . $optional_fws . $second . ')?' . $fws . $zone . '/i';
		}
		if (preg_match($pcre, $this->remove_rfc2822_comments($date), $match))
		{
			/*
			Capturing subpatterns:
			1: Day name
			2: Day
			3: Month
			4: Year
			5: Hour
			6: Minute
			7: Second
			8: Timezone ±
			9: Timezone hours
			10: Timezone minutes
			11: Alphabetic timezone
			*/

			// Find the month number
			$month = $this->month[strtolower($match[3])];

			// Numeric timezone
			if ($match[8] !== '')
			{
				$timezone = $match[9] * 3600;
				$timezone += $match[10] * 60;
				if ($match[8] === '-')
				{
					$timezone = 0 - $timezone;
				}
			}
			// Character timezone
			elseif (isset($this->timezone[strtoupper($match[11])]))
			{
				$timezone = $this->timezone[strtoupper($match[11])];
			}
			// Assume everything else to be -0000
			else
			{
				$timezone = 0;
			}

			// Deal with 2/3 digit years
			if ($match[4] < 50)
			{
				$match[4] += 2000;
			}
			elseif ($match[4] < 1000)
			{
				$match[4] += 1900;
			}

			// Second is optional, if it is empty set it to zero
			if ($match[7] !== '')
			{
				$second = $match[7];
			}
			else
			{
				$second = 0;
			}

			return gmmktime($match[5], $match[6], $second, $month, $match[2], $match[4]) - $timezone;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Parse RFC850's date format
	 *
	 * @access protected
	 * @return int Timestamp
	 */
	public function date_rfc850($date)
	{
		static $pcre;
		if (!$pcre)
		{
			$space = '[\x09\x20]+';
			$day_name = $this->day_pcre;
			$month = $this->month_pcre;
			$day = '([0-9]{1,2})';
			$year = $hour = $minute = $second = '([0-9]{2})';
			$zone = '([A-Z]{1,5})';
			$pcre = '/^' . $day_name . ',' . $space . $day . '-' . $month . '-' . $year . $space . $hour . ':' . $minute . ':' . $second . $space . $zone . '$/i';
		}
		if (preg_match($pcre, $date, $match))
		{
			/*
			Capturing subpatterns:
			1: Day name
			2: Day
			3: Month
			4: Year
			5: Hour
			6: Minute
			7: Second
			8: Timezone
			*/

			// Month
			$month = $this->month[strtolower($match[3])];

			// Character timezone
			if (isset($this->timezone[strtoupper($match[8])]))
			{
				$timezone = $this->timezone[strtoupper($match[8])];
			}
			// Assume everything else to be -0000
			else
			{
				$timezone = 0;
			}

			// Deal with 2 digit year
			if ($match[4] < 50)
			{
				$match[4] += 2000;
			}
			else
			{
				$match[4] += 1900;
			}

			return gmmktime($match[5], $match[6], $match[7], $month, $match[2], $match[4]) - $timezone;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Parse C99's asctime()'s date format
	 *
	 * @access protected
	 * @return int Timestamp
	 */
	public function date_asctime($date)
	{
		static $pcre;
		if (!$pcre)
		{
			$space = '[\x09\x20]+';
			$wday_name = $this->day_pcre;
			$mon_name = $this->month_pcre;
			$day = '([0-9]{1,2})';
			$hour = $sec = $min = '([0-9]{2})';
			$year = '([0-9]{4})';
			$terminator = '\x0A?\x00?';
			$pcre = '/^' . $wday_name . $space . $mon_name . $space . $day . $space . $hour . ':' . $min . ':' . $sec . $space . $year . $terminator . '$/i';
		}
		if (preg_match($pcre, $date, $match))
		{
			/*
			Capturing subpatterns:
			1: Day name
			2: Month
			3: Day
			4: Hour
			5: Minute
			6: Second
			7: Year
			*/

			$month = $this->month[strtolower($match[2])];
			return gmmktime($match[4], $match[5], $match[6], $month, $match[3], $match[7]);
		}
		else
		{
			return false;
		}
	}

	/**
	 * Parse dates using strtotime()
	 *
	 * @access protected
	 * @return int Timestamp
	 */
	public function date_strtotime($date)
	{
		$strtotime = strtotime($date);
		if ($strtotime === -1 || $strtotime === false)
		{
			return false;
		}
		else
		{
			return $strtotime;
		}
	}
}