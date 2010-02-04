<?php
namespace ComplexPie;

/**
 * SimplePie
 *
 * A PHP-Based RSS and Atom Feed Framework.
 * Takes the hard work out of managing a complete RSS/Atom solution.
 *
 * Copyright (c) 2004-2009, Ryan Parman, Geoffrey Sneddon, Ryan McCue, and contributors
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification, are
 * permitted provided that the following conditions are met:
 *
 *     * Redistributions of source code must retain the above copyright notice, this list of
 *       conditions and the following disclaimer.
 *
 *     * Redistributions in binary form must reproduce the above copyright notice, this list
 *       of conditions and the following disclaimer in the documentation and/or other materials
 *       provided with the distribution.
 *
 *     * Neither the name of the SimplePie Team nor the names of its contributors may be used
 *       to endorse or promote products derived from this software without specific prior
 *       written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS
 * OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY
 * AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS
 * AND CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR
 * OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package SimplePie
 * @version 2.0-dev
 * @copyright 2004-2009 Ryan Parman, Geoffrey Sneddon, Ryan McCue
 * @author Ryan Parman
 * @author Geoffrey Sneddon
 * @author Ryan McCue
 * @link http://simplepie.org/ SimplePie
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 * @todo phpDoc comments
 */

if (extension_loaded('spl'))
{
    if (spl_autoload_functions() === false && function_exists('__autoload'))
    {
        spl_autoload_register('__autoload');
    }
    
    function autoload($classname)
    {
        if (substr($classname, 0, 11) === 'ComplexPie\\')
        {
            $file = dirname(__FILE__) . '/' . str_replace('\\', '/', strtolower(substr($classname, 11))) . '.php';
            if (file_exists($file))
                require_once $file;
        }
    }
    
    spl_autoload_register('ComplexPie\autoload');
}
else
{
    $files = glob(dirname(__FILE__) . '/*.php');
    foreach ($files as $file)
    {
        if ($file !== __FILE__)
            require_once $file;
    }
}

/**
 * SimplePie Name
 */
define('NAME', 'SimplePie');

/**
 * SimplePie Version
 */
define('VERSION', '2.0-dev');

/**
 * SimplePie Build
 */
$build = 'unknown';
$foo = array();
exec('git --help', $foo, $return);
if ($return === 0)
{
    $path = __FILE__;
    while (($path = dirname($path)) !== '/')
    {
        if (file_exists($path . '/.git'))
        {
            $build = trim(exec("git --git-dir=$path/.git log -1 --pretty=format:%H"));
            break;
        }
    }
}
define('BUILD', $build);

/**
 * SimplePie Website URL
 */
define('URL', 'http://simplepie.org');

/**
 * SimplePie Useragent
 * This can be passed into whatever HTTP class you use.
 */
define('USERAGENT', NAME . '/' . VERSION . ' (Feed Parser; ' . URL . ') Build/' . BUILD);

/**
 * No known feed type
 */
define('TYPE_NONE', 0);

/**
 * RSS 0.90
 */
define('TYPE_RSS_090', 1);

/**
 * RSS 0.91 (Netscape)
 */
define('TYPE_RSS_091_NETSCAPE', 2);

/**
 * RSS 0.91 (Userland)
 */
define('TYPE_RSS_091_USERLAND', 4);

/**
 * RSS 0.91 (both Netscape and Userland)
 */
define('TYPE_RSS_091', 6);

/**
 * RSS 0.92
 */
define('TYPE_RSS_092', 8);

/**
 * RSS 0.93
 */
define('TYPE_RSS_093', 16);

/**
 * RSS 0.94
 */
define('TYPE_RSS_094', 32);

/**
 * RSS 1.0
 */
define('TYPE_RSS_10', 64);

/**
 * RSS 2.0
 */
define('TYPE_RSS_20', 128);

/**
 * RDF-based RSS
 */
define('TYPE_RSS_RDF', 65);

/**
 * Non-RDF-based RSS (truly intended as syndication format)
 */
define('TYPE_RSS_SYNDICATION', 190);

/**
 * All RSS
 */
define('TYPE_RSS_ALL', 255);

/**
 * Atom 0.3
 */
define('TYPE_ATOM_03', 256);

/**
 * Atom 1.0
 */
define('TYPE_ATOM_10', 512);

/**
 * All Atom
 */
define('TYPE_ATOM_ALL', 768);

/**
 * All feed types
 */
define('TYPE_ALL', 1023);

/**
 * No construct
 */
define('CONSTRUCT_NONE', 0);

/**
 * Text construct
 */
define('CONSTRUCT_TEXT', 1);

/**
 * HTML construct
 */
define('CONSTRUCT_HTML', 2);

/**
 * XHTML construct
 */
define('CONSTRUCT_XHTML', 4);

/**
 * base64-encoded construct
 */
define('CONSTRUCT_BASE64', 8);

/**
 * IRI construct
 */
define('CONSTRUCT_IRI', 16);

/**
 * All constructs
 */
define('CONSTRUCT_ALL', 63);

/**
 * Don't change case
 */
define('SAME_CASE', 1);

/**
 * Change to lowercase
 */
define('LOWERCASE', 2);

/**
 * Change to uppercase
 */
define('UPPERCASE', 4);

/**
 * PCRE for HTML attributes
 */
define('PCRE_HTML_ATTRIBUTE', '((?:[\x09\x0A\x0B\x0C\x0D\x20]+[^\x09\x0A\x0B\x0C\x0D\x20\x2F\x3E][^\x09\x0A\x0B\x0C\x0D\x20\x2F\x3D\x3E]*(?:[\x09\x0A\x0B\x0C\x0D\x20]*=[\x09\x0A\x0B\x0C\x0D\x20]*(?:"(?:[^"]*)"|\'(?:[^\']*)\'|(?:[^\x09\x0A\x0B\x0C\x0D\x20\x22\x27\x3E][^\x09\x0A\x0B\x0C\x0D\x20\x3E]*)?))?)*)[\x09\x0A\x0B\x0C\x0D\x20]*');

/**
 * PCRE for XML attributes
 */
define('PCRE_XML_ATTRIBUTE', '((?:\s+(?:(?:[^\s:]+:)?[^\s:]+)\s*=\s*(?:"(?:[^"]*)"|\'(?:[^\']*)\'))*)\s*');

/**
 * XML Namespace
 */
define('NAMESPACE_XML', 'http://www.w3.org/XML/1998/namespace');

/**
 * Atom 1.0 Namespace
 */
define('NAMESPACE_ATOM_10', 'http://www.w3.org/2005/Atom');

/**
 * Atom 0.3 Namespace
 */
define('NAMESPACE_ATOM_03', 'http://purl.org/atom/ns#');

/**
 * RDF Namespace
 */
define('NAMESPACE_RDF', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');

/**
 * RSS 0.90 Namespace
 */
define('NAMESPACE_RSS_090', 'http://my.netscape.com/rdf/simple/0.9/');

/**
 * RSS 1.0 Namespace
 */
define('NAMESPACE_RSS_10', 'http://purl.org/rss/1.0/');

/**
 * RSS 1.0 Content Module Namespace
 */
define('NAMESPACE_RSS_10_MODULES_CONTENT', 'http://purl.org/rss/1.0/modules/content/');

/**
 * RSS 2.0 Namespace
 * (Stupid, I know, but I'm certain it will confuse people less with support.)
 */
define('NAMESPACE_RSS_20', '');

/**
 * XHTML Namespace
 */
define('NAMESPACE_XHTML', 'http://www.w3.org/1999/xhtml');

/**
 * IANA Link Relations Registry
 */
define('IANA_LINK_RELATIONS_REGISTRY', 'http://www.iana.org/assignments/relation/');

/**
 * SimplePie
 *
 * @package SimplePie
 */
function SimplePie($data, $uri = null)
{
    // Check the xml extension is sane (i.e., libxml 2.7.x issue on PHP < 5.2.9 and libxml 2.7.0 to 2.7.2 on any version) if we don't have xmlreader.
    if (!extension_loaded('xmlreader'))
    {
        static $xml_is_sane = null;
        if ($xml_is_sane === null)
        {
            $parser_check = xml_parser_create();
            xml_parse_into_struct($parser_check, '<foo>&amp;</foo>', $values);
            xml_parser_free($parser_check);
            $xml_is_sane = isset($values[0]['value']);
        }
        if (!$xml_is_sane)
        {
            return false;
        }
    }

    // Create new parser
    $parser = new Parser();
    $dom = new \DOMDocument();
    $dom->documentURI = $uri;

    // If it's parsed fine
    if (@$dom->loadXML($data))
    {
        $parser->parse($data, 'UTF-8');
        $tree = $parser->get_data();
        switch ('{' . $dom->documentElement->namespaceURI . '}' . $dom->documentElement->localName)
        {
            case '{' . NAMESPACE_ATOM_10 . '}feed':
            case '{' . NAMESPACE_ATOM_03 . '}feed':
                $element = $dom->documentElement;
                break;
            
            case '{}rss':
                $channels = $dom->getElementsByTagName('channel');
                foreach ($channels as $channel)
                {
                    if ($channel->parentNode === $dom->documentElement)
                    {
                        $element = $channel;
                    }
                }
                if (!isset($element))
                {
                    $channel = $dom->createElement('channel');
                    $dom->documentElement->appendChild($channel);
                    $element = $channel;
                }
                break;
            
            case '{' . NAMESPACE_RDF . '}RDF':
                $channels = $dom->getElementsByTagNameNS(NAMESPACE_RSS_10, 'channel');
                foreach ($channels as $channel)
                {
                    if ($channel->parentNode === $dom->documentElement)
                    {
                        $element = $channel;
                    }
                }
                if (!isset($element))
                {
                    $channels = $dom->getElementsByTagNameNS(NAMESPACE_RSS_090, 'channel');
                    foreach ($channels as $channel)
                    {
                        if ($channel->parentNode === $dom->documentElement)
                        {
                            $element = $channel;
                        }
                    }
                    if (!isset($element))
                    {
                        if ($dom->getElementsByTagNameNS(NAMESPACE_RSS_090, '*')->length >
                            $dom->getElementsByTagNameNS(NAMESPACE_RSS_10, '*')->length)
                        {
                            $channel = $dom->createElementNS(NAMESPACE_RSS_090, 'channel');
                        }
                        else
                        {
                            $channel = $dom->createElementNS(NAMESPACE_RSS_10, 'channel');
                        }
                        $dom->documentElement->appendChild($channel);
                        $element = $channel;
                    }
                }
                break;
            
            default:
                return false;
        }
        return new Feed($element, $tree);
    }
    else
    {
        // We have an error, just set Misc::error to it and quit
        $error = sprintf('This XML document is invalid, likely due to invalid characters. XML error: %s at line %d, column %d', $parser->get_error_string(), $parser->get_current_line(), $parser->get_current_column());

        Misc::error($error, E_USER_NOTICE, __FILE__, __LINE__);
    
        return false;
    }
}
