<?php
namespace ComplexPie;

class Constants
{
    public static $rawTextElements;
    public static $rcdataElements;
    public static $voidElements;
    private function __construct() {}
}

Constants::$rawTextElements = array_flip(array(
    'script',
    'style'
));

Constants::$rcdataElements = array_flip(array(
    'textarea',
    'title'
));

Constants::$voidElements = array_flip(array(
    'area',
    'base',
    'br',
    'col',
    'command',
    'embed',
    'hr',
    'img',
    'input',
    'keygen',
    'link',
    'meta',
    'param',
    'source'
));

/**
 * ComplexPie Name
 */
const NAME = 'ComplexPie';

/**
 * ComplexPie Version
 */
const VERSION = '2.0-dev';

/**
 * ComplexPie Build
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
 * ComplexPie Website URL
 */
const URL = 'http://simplepie.org';

/**
 * ComplexPie Useragent
 * This can be passed into whatever HTTP class you use.
 */
define('USERAGENT', NAME . '/' . VERSION . ' (Feed Parser; ' . URL . ') Build/' . BUILD);

/**
 * No known feed type
 */
const TYPE_NONE = 0;

/**
 * RSS 0.90
 */
const TYPE_RSS_090 = 1;

/**
 * RSS 0.91 (Netscape)
 */
const TYPE_RSS_091_NETSCAPE = 2;

/**
 * RSS 0.91 (Userland)
 */
const TYPE_RSS_091_USERLAND = 4;

/**
 * RSS 0.91 (both Netscape and Userland)
 */
const TYPE_RSS_091 = 6;

/**
 * RSS 0.92
 */
const TYPE_RSS_092 = 8;

/**
 * RSS 0.93
 */
const TYPE_RSS_093 = 16;

/**
 * RSS 0.94
 */
const TYPE_RSS_094 = 32;

/**
 * RSS 1.0
 */
const TYPE_RSS_10 = 64;

/**
 * RSS 2.0
 */
const TYPE_RSS_20 = 128;

/**
 * RDF-based RSS
 */
const TYPE_RSS_RDF = 65;

/**
 * Non-RDF-based RSS (truly intended as syndication format)
 */
const TYPE_RSS_SYNDICATION = 190;

/**
 * All RSS
 */
const TYPE_RSS_ALL = 255;

/**
 * Atom 0.3
 */
const TYPE_ATOM_03 = 256;

/**
 * Atom 1.0
 */
const TYPE_ATOM_10 = 512;

/**
 * All Atom
 */
const TYPE_ATOM_ALL = 768;

/**
 * All feed types
 */
const TYPE_ALL = 1023;

/**
 * No construct
 */
const CONSTRUCT_NONE = 0;

/**
 * Text construct
 */
const CONSTRUCT_TEXT = 1;

/**
 * HTML construct
 */
const CONSTRUCT_HTML = 2;

/**
 * XHTML construct
 */
const CONSTRUCT_XHTML = 4;

/**
 * base64-encoded construct
 */
const CONSTRUCT_BASE64 = 8;

/**
 * IRI construct
 */
const CONSTRUCT_IRI = 16;

/**
 * All constructs
 */
const CONSTRUCT_ALL = 63;

/**
 * Don't change case
 */
const SAME_CASE = 1;

/**
 * Change to lowercase
 */
const LOWERCASE = 2;

/**
 * Change to uppercase
 */
const UPPERCASE = 4;

/**
 * PCRE for HTML attributes
 */
const PCRE_HTML_ATTRIBUTE = '((?:[\x09\x0A\x0B\x0C\x0D\x20]+[^\x09\x0A\x0B\x0C\x0D\x20\x2F\x3E][^\x09\x0A\x0B\x0C\x0D\x20\x2F\x3D\x3E]*(?:[\x09\x0A\x0B\x0C\x0D\x20]*=[\x09\x0A\x0B\x0C\x0D\x20]*(?:"(?:[^"]*)"|\'(?:[^\']*)\'|(?:[^\x09\x0A\x0B\x0C\x0D\x20\x22\x27\x3E][^\x09\x0A\x0B\x0C\x0D\x20\x3E]*)?))?)*)[\x09\x0A\x0B\x0C\x0D\x20]*';

/**
 * PCRE for XML attributes
 */
const PCRE_XML_ATTRIBUTE = '((?:\s+(?:(?:[^\s:]+:)?[^\s:]+)\s*=\s*(?:"(?:[^"]*)"|\'(?:[^\']*)\'))*)\s*';

/**
 * XML Namespace
 */
const NAMESPACE_XML = 'http://www.w3.org/XML/1998/namespace';

/**
 * Atom 1.0 Namespace
 */
const NAMESPACE_ATOM_10 = 'http://www.w3.org/2005/Atom';

/**
 * Atom 0.3 Namespace
 */
const NAMESPACE_ATOM_03 = 'http://purl.org/atom/ns#';

/**
 * RDF Namespace
 */
const NAMESPACE_RDF = 'http://www.w3.org/1999/02/22-rdf-syntax-ns#';

/**
 * RSS 0.90 Namespace
 */
const NAMESPACE_RSS_090 = 'http://my.netscape.com/rdf/simple/0.9/';

/**
 * RSS 1.0 Namespace
 */
const NAMESPACE_RSS_10 = 'http://purl.org/rss/1.0/';

/**
 * RSS 1.0 Content Module Namespace
 */
const NAMESPACE_RSS_10_MODULES_CONTENT = 'http://purl.org/rss/1.0/modules/content/';

/**
 * RSS 2.0 Namespace
 * (Stupid, I know, but I'm certain it will confuse people less with support.)
 */
const NAMESPACE_RSS_20 = '';

/**
 * XHTML Namespace
 */
const NAMESPACE_XHTML = 'http://www.w3.org/1999/xhtml';

/**
 * IANA Link Relations Registry
 */
const IANA_LINK_RELATIONS_REGISTRY = 'http://www.iana.org/assignments/relation/';