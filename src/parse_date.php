<?php
namespace ComplexPie;

/**
 * Date Parser
 *
 * @package SimplePie
 */
class Parse_Date
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
     * Cached PCRE for Parse_Date::$day
     *
     * @access protected
     * @var string
     */
    var $day_pcre;

    /**
     * Cached PCRE for Parse_Date::$month
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
     * Create new Parse_Date object, and set self::day_pcre,
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
            $object = new Parse_Date;
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
        foreach ($this->built_in as $method)
        {
            if (($returned = call_user_func(array(&$this, $method), $date)) !== false)
            {
                if ($returned instanceof \DateTime)
                {
                    return $returned;
                }
                else
                {
                    $date = new \DateTime();
                    $date->setTimestamp($returned);
                    return $date;
                }
            }
        }

        return false;
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
     * @param string $data Data to strip comments from
     * @return string Comment stripped string
     */
    protected function remove_rfc2822_comments($string)
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
            $depth++;
            while ($depth && ($position += strcspn($string, '()\\', $position)) < $length)
            {
                switch ($string[$position++])
                {
                    case '(':
                        $depth++;
                        break;

                    case ')':
                        $depth--;
                        break;
                    
                    case '\\':
                        $position++;
                        break;
                }
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
            $month = $this->month_pcre;
            $day = '([0-9]{1,2})';
            $hour = $minute = $second = '([0-9]{2})';
            $year = '([0-9]{2,4})';
            $num_zone = '([+\-])([0-9]{2})([0-9]{2})';
            $character_zone = '([A-Z]{1,5})';
            $zone = '(?:' . $num_zone . '|' . $character_zone . ')';
            $pcre = '/' . $day . $fws . $month . $fws . $year . $fws . $hour . $optional_fws . ':' . $optional_fws . $minute . '(?:' . $optional_fws . ':' . $optional_fws . $second . ')?' . $fws . $zone . '/i';
        }
        if (preg_match($pcre, $this->remove_rfc2822_comments($date), $match))
        {
            /*
            Capturing subpatterns:
            1: Day
            2: Month
            3: Year
            4: Hour
            5: Minute
            6: Second
            7: Timezone ±
            8: Timezone hours
            9: Timezone minutes
            10: Alphabetic timezone
            */

            // Find the month number
            $month = $this->month[strtolower($match[2])];

            // Numeric timezone
            if ($match[7] !== '')
            {
                $timezone = $match[8] * 3600;
                $timezone += $match[9] * 60;
                if ($match[7] === '-')
                {
                    $timezone = -$timezone;
                }
            }
            // Character timezone
            elseif (isset($this->timezone[strtoupper($match[10])]))
            {
                $timezone = $this->timezone[strtoupper($match[10])];
            }
            // Assume everything else to be -0000
            else
            {
                $timezone = 0;
            }

            // Deal with 2/3 digit years
            if ($match[3] < 50)
            {
                $match[3] += 2000;
            }
            elseif ($match[3] < 1000)
            {
                $match[3] += 1900;
            }

            // Second is optional, if it is empty set it to zero
            if ($match[6] !== '')
            {
                $second = $match[6];
            }
            else
            {
                $second = 0;
            }
            
            $date = new \DateTime();
            if ($timezone % 3600 === 0)
            {
                // It would appear ETC/GMT+1 is what most people would call GMT-1.
                $tz = new \DateTimeZone(sprintf('ETC/GMT%+d', -$timezone / 3600));
                $date->setTimezone($tz);
            }
            else
            {
                $tz = new \DateTimeZone('UTC');
                $date->setTimezone($tz);
                $second -= $timezone;
            }
            $date->setDate($match[3], $month, $match[1]);
            $date->setTime($match[4], $match[5], $second);

            return $date;
        }
        else
        {
            return false;
        }
    }

    /**
     * Parse dates using strtotime()
     *
     * @return \DateTime|false Parsed date
     */
    protected function date_strtotime($date)
    {
        try
        {
            return new \DateTime($date);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }
}
