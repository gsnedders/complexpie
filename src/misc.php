<?php
namespace ComplexPie;

class Misc
{
    public static function absolutize_url($relative, $base)
    {
        $iri = IRI::absolutize($base, $relative);
        if ($iri)
            return $iri->iri;
        else
            return $relative;
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

    public static function atom_03_construct_type($attribs)
    {
        if (isset($attribs['']['mode']) && strtolower(trim($attribs['']['mode']) === 'base64'))
        {
            $mode = CONSTRUCT_BASE64;
        }
        else
        {
            $mode = CONSTRUCT_NONE;
        }
        if (isset($attribs['']['type']))
        {
            switch (strtolower(trim($attribs['']['type'])))
            {
                case 'text':
                case 'text/plain':
                    return CONSTRUCT_TEXT | $mode;

                case 'html':
                case 'text/html':
                    return CONSTRUCT_HTML | $mode;

                case 'xhtml':
                case 'application/xhtml+xml':
                    return CONSTRUCT_XHTML | $mode;

                default:
                    return CONSTRUCT_NONE | $mode;
            }
        }
        else
        {
            return CONSTRUCT_TEXT | $mode;
        }
    }

    public static function is_isegment_nz_nc($string)
    {
        return (bool) preg_match('/^([A-Za-z0-9\-._~\x{A0}-\x{D7FF}\x{F900}-\x{FDCF}\x{FDF0}-\x{FFEF}\x{10000}-\x{1FFFD}\x{20000}-\x{2FFFD}\x{30000}-\x{3FFFD}\x{40000}-\x{4FFFD}\x{50000}-\x{5FFFD}\x{60000}-\x{6FFFD}\x{70000}-\x{7FFFD}\x{80000}-\x{8FFFD}\x{90000}-\x{9FFFD}\x{A0000}-\x{AFFFD}\x{B0000}-\x{BFFFD}\x{C0000}-\x{CFFFD}\x{D0000}-\x{DFFFD}\x{E1000}-\x{EFFFD}!$&\'()*+,;=@]|(%[0-9ABCDEF]{2}))+$/u', $string);
    }
    
    public static function xpath($root, $query, $namespace_map = array())
    {
        $doc = isset($root->ownerDocument) ? $root->ownerDocument : $root;
        $xpath = new \DOMXPath($doc);
        foreach ($namespace_map as $prefix => $uri)
        {
            $xpath->registerNamespace($prefix, $uri);
        }
        $result = $xpath->evaluate($query, $root);
        return $result;
    }
}
