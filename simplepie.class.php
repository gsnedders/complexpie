<?php
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
 * 	* Redistributions of source code must retain the above copyright notice, this list of
 * 	  conditions and the following disclaimer.
 *
 * 	* Redistributions in binary form must reproduce the above copyright notice, this list
 * 	  of conditions and the following disclaimer in the documentation and/or other materials
 * 	  provided with the distribution.
 *
 * 	* Neither the name of the SimplePie Team nor the names of its contributors may be used
 * 	  to endorse or promote products derived from this software without specific prior
 * 	  written permission.
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

/**
 * SimplePie Name
 */
define('SIMPLEPIE_NAME', 'SimplePie');

/**
 * SimplePie Version
 */
define('SIMPLEPIE_VERSION', '2.0-dev');

/**
 * SimplePie Build
 * @todo Hardcode for release (there's no need to have to call SimplePie_Misc::parse_date() only every load of simplepie.inc)
 */
define('SIMPLEPIE_BUILD', gmdate('YmdHis', SimplePie_Misc::parse_date(substr('$Date$', 7, 25)) ? SimplePie_Misc::parse_date(substr('$Date$', 7, 25)) : filemtime(__FILE__)));

/**
 * SimplePie Website URL
 */
define('SIMPLEPIE_URL', 'http://simplepie.org');

/**
 * SimplePie Useragent
 * This can be passed into whatever HTTP class you use.
 */
define('SIMPLEPIE_USERAGENT', SIMPLEPIE_NAME . '/' . SIMPLEPIE_VERSION . ' (Feed Parser; ' . SIMPLEPIE_URL . ') Build/' . SIMPLEPIE_BUILD);

/**
 * No known feed type
 */
define('SIMPLEPIE_TYPE_NONE', 0);

/**
 * RSS 0.90
 */
define('SIMPLEPIE_TYPE_RSS_090', 1);

/**
 * RSS 0.91 (Netscape)
 */
define('SIMPLEPIE_TYPE_RSS_091_NETSCAPE', 2);

/**
 * RSS 0.91 (Userland)
 */
define('SIMPLEPIE_TYPE_RSS_091_USERLAND', 4);

/**
 * RSS 0.91 (both Netscape and Userland)
 */
define('SIMPLEPIE_TYPE_RSS_091', 6);

/**
 * RSS 0.92
 */
define('SIMPLEPIE_TYPE_RSS_092', 8);

/**
 * RSS 0.93
 */
define('SIMPLEPIE_TYPE_RSS_093', 16);

/**
 * RSS 0.94
 */
define('SIMPLEPIE_TYPE_RSS_094', 32);

/**
 * RSS 1.0
 */
define('SIMPLEPIE_TYPE_RSS_10', 64);

/**
 * RSS 2.0
 */
define('SIMPLEPIE_TYPE_RSS_20', 128);

/**
 * RDF-based RSS
 */
define('SIMPLEPIE_TYPE_RSS_RDF', 65);

/**
 * Non-RDF-based RSS (truly intended as syndication format)
 */
define('SIMPLEPIE_TYPE_RSS_SYNDICATION', 190);

/**
 * All RSS
 */
define('SIMPLEPIE_TYPE_RSS_ALL', 255);

/**
 * Atom 0.3
 */
define('SIMPLEPIE_TYPE_ATOM_03', 256);

/**
 * Atom 1.0
 */
define('SIMPLEPIE_TYPE_ATOM_10', 512);

/**
 * All Atom
 */
define('SIMPLEPIE_TYPE_ATOM_ALL', 768);

/**
 * All feed types
 */
define('SIMPLEPIE_TYPE_ALL', 1023);

/**
 * No construct
 */
define('SIMPLEPIE_CONSTRUCT_NONE', 0);

/**
 * Text construct
 */
define('SIMPLEPIE_CONSTRUCT_TEXT', 1);

/**
 * HTML construct
 */
define('SIMPLEPIE_CONSTRUCT_HTML', 2);

/**
 * XHTML construct
 */
define('SIMPLEPIE_CONSTRUCT_XHTML', 4);

/**
 * base64-encoded construct
 */
define('SIMPLEPIE_CONSTRUCT_BASE64', 8);

/**
 * IRI construct
 */
define('SIMPLEPIE_CONSTRUCT_IRI', 16);

/**
 * All constructs
 */
define('SIMPLEPIE_CONSTRUCT_ALL', 63);

/**
 * Don't change case
 */
define('SIMPLEPIE_SAME_CASE', 1);

/**
 * Change to lowercase
 */
define('SIMPLEPIE_LOWERCASE', 2);

/**
 * Change to uppercase
 */
define('SIMPLEPIE_UPPERCASE', 4);

/**
 * PCRE for HTML attributes
 */
define('SIMPLEPIE_PCRE_HTML_ATTRIBUTE', '((?:[\x09\x0A\x0B\x0C\x0D\x20]+[^\x09\x0A\x0B\x0C\x0D\x20\x2F\x3E][^\x09\x0A\x0B\x0C\x0D\x20\x2F\x3D\x3E]*(?:[\x09\x0A\x0B\x0C\x0D\x20]*=[\x09\x0A\x0B\x0C\x0D\x20]*(?:"(?:[^"]*)"|\'(?:[^\']*)\'|(?:[^\x09\x0A\x0B\x0C\x0D\x20\x22\x27\x3E][^\x09\x0A\x0B\x0C\x0D\x20\x3E]*)?))?)*)[\x09\x0A\x0B\x0C\x0D\x20]*');

/**
 * PCRE for XML attributes
 */
define('SIMPLEPIE_PCRE_XML_ATTRIBUTE', '((?:\s+(?:(?:[^\s:]+:)?[^\s:]+)\s*=\s*(?:"(?:[^"]*)"|\'(?:[^\']*)\'))*)\s*');

/**
 * XML Namespace
 */
define('SIMPLEPIE_NAMESPACE_XML', 'http://www.w3.org/XML/1998/namespace');

/**
 * Atom 1.0 Namespace
 */
define('SIMPLEPIE_NAMESPACE_ATOM_10', 'http://www.w3.org/2005/Atom');

/**
 * Atom 0.3 Namespace
 */
define('SIMPLEPIE_NAMESPACE_ATOM_03', 'http://purl.org/atom/ns#');

/**
 * RDF Namespace
 */
define('SIMPLEPIE_NAMESPACE_RDF', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');

/**
 * RSS 0.90 Namespace
 */
define('SIMPLEPIE_NAMESPACE_RSS_090', 'http://my.netscape.com/rdf/simple/0.9/');

/**
 * RSS 1.0 Namespace
 */
define('SIMPLEPIE_NAMESPACE_RSS_10', 'http://purl.org/rss/1.0/');

/**
 * RSS 1.0 Content Module Namespace
 */
define('SIMPLEPIE_NAMESPACE_RSS_10_MODULES_CONTENT', 'http://purl.org/rss/1.0/modules/content/');

/**
 * RSS 2.0 Namespace
 * (Stupid, I know, but I'm certain it will confuse people less with support.)
 */
define('SIMPLEPIE_NAMESPACE_RSS_20', '');

/**
 * DC 1.0 Namespace
 */
define('SIMPLEPIE_NAMESPACE_DC_10', 'http://purl.org/dc/elements/1.0/');

/**
 * DC 1.1 Namespace
 */
define('SIMPLEPIE_NAMESPACE_DC_11', 'http://purl.org/dc/elements/1.1/');

/**
 * XHTML Namespace
 */
define('SIMPLEPIE_NAMESPACE_XHTML', 'http://www.w3.org/1999/xhtml');

/**
 * IANA Link Relations Registry
 */
define('SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY', 'http://www.iana.org/assignments/relation/');

/**
 * SimplePie
 *
 * @package SimplePie
 */
function SimplePie($data)
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
	$parser = new SimplePie_Parser();
	$dom = new DOMDocument();

	// If it's parsed fine
	if (@$dom->loadXML($data))
	{
		$parser->parse($data, 'UTF-8');
		$tree = $parser->get_data();
		return new SimplePie_Feed($dom->documentElement, $tree);
	}
	else
	{
		// We have an error, just set SimplePie_Misc::error to it and quit
		$error = sprintf('This XML document is invalid, likely due to invalid characters. XML error: %s at line %d, column %d', $parser->get_error_string(), $parser->get_current_line(), $parser->get_current_column());

		SimplePie_Misc::error($error, E_USER_NOTICE, __FILE__, __LINE__);
	
		return false;
	}
}

class SimplePie_Feed
{
	public function __construct($dom, $oldtree)
	{
		$this->dom = $dom;
		$this->data = $oldtree;
		$this->sanitize = new SimplePie_Sanitize();
	}
	
	public function get_type()
	{
		if (!isset($this->data['type']))
		{
			$this->data['type'] = SIMPLEPIE_TYPE_ALL;
			if (isset($this->data['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['feed']))
			{
				$this->data['type'] &= SIMPLEPIE_TYPE_ATOM_10;
			}
			elseif (isset($this->data['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['feed']))
			{
				$this->data['type'] &= SIMPLEPIE_TYPE_ATOM_03;
			}
			elseif (isset($this->data['child'][SIMPLEPIE_NAMESPACE_RDF]['RDF']))
			{
				if (isset($this->data['child'][SIMPLEPIE_NAMESPACE_RDF]['RDF'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_10]['channel'])
				|| isset($this->data['child'][SIMPLEPIE_NAMESPACE_RDF]['RDF'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_10]['image'])
				|| isset($this->data['child'][SIMPLEPIE_NAMESPACE_RDF]['RDF'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_10]['item'])
				|| isset($this->data['child'][SIMPLEPIE_NAMESPACE_RDF]['RDF'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_10]['textinput']))
				{
					$this->data['type'] &= SIMPLEPIE_TYPE_RSS_10;
				}
				if (isset($this->data['child'][SIMPLEPIE_NAMESPACE_RDF]['RDF'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_090]['channel'])
				|| isset($this->data['child'][SIMPLEPIE_NAMESPACE_RDF]['RDF'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_090]['image'])
				|| isset($this->data['child'][SIMPLEPIE_NAMESPACE_RDF]['RDF'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_090]['item'])
				|| isset($this->data['child'][SIMPLEPIE_NAMESPACE_RDF]['RDF'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_090]['textinput']))
				{
					$this->data['type'] &= SIMPLEPIE_TYPE_RSS_090;
				}
			}
			elseif (isset($this->data['child'][SIMPLEPIE_NAMESPACE_RSS_20]['rss']))
			{
				$this->data['type'] &= SIMPLEPIE_TYPE_RSS_ALL;
				if (isset($this->data['child'][SIMPLEPIE_NAMESPACE_RSS_20]['rss'][0]['attribs']['']['version']))
				{
					switch (trim($this->data['child'][SIMPLEPIE_NAMESPACE_RSS_20]['rss'][0]['attribs']['']['version']))
					{
						case '0.91':
							$this->data['type'] &= SIMPLEPIE_TYPE_RSS_091;
							if (isset($this->data['child'][SIMPLEPIE_NAMESPACE_RSS_20]['rss'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_20]['skiphours']['hour'][0]['data']))
							{
								switch (trim($this->data['child'][SIMPLEPIE_NAMESPACE_RSS_20]['rss'][0]['child'][SIMPLEPIE_NAMESPACE_RSS_20]['skiphours']['hour'][0]['data']))
								{
									case '0':
										$this->data['type'] &= SIMPLEPIE_TYPE_RSS_091_NETSCAPE;
										break;

									case '24':
										$this->data['type'] &= SIMPLEPIE_TYPE_RSS_091_USERLAND;
										break;
								}
							}
							break;

						case '0.92':
							$this->data['type'] &= SIMPLEPIE_TYPE_RSS_092;
							break;

						case '0.93':
							$this->data['type'] &= SIMPLEPIE_TYPE_RSS_093;
							break;

						case '0.94':
							$this->data['type'] &= SIMPLEPIE_TYPE_RSS_094;
							break;

						case '2.0':
							$this->data['type'] &= SIMPLEPIE_TYPE_RSS_20;
							break;
					}
				}
			}
			else
			{
				$this->data['type'] = SIMPLEPIE_TYPE_NONE;
			}
		}
		return $this->data['type'];
	}

	public function get_feed_tags($namespace, $tag)
	{
		$type = $this->get_type();
		if ($type & SIMPLEPIE_TYPE_ATOM_10)
		{
			if (isset($this->data['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['feed'][0]['child'][$namespace][$tag]))
			{
				return $this->data['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['feed'][0]['child'][$namespace][$tag];
			}
		}
		if ($type & SIMPLEPIE_TYPE_ATOM_03)
		{
			if (isset($this->data['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['feed'][0]['child'][$namespace][$tag]))
			{
				return $this->data['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['feed'][0]['child'][$namespace][$tag];
			}
		}
		if ($type & SIMPLEPIE_TYPE_RSS_RDF)
		{
			if (isset($this->data['child'][SIMPLEPIE_NAMESPACE_RDF]['RDF'][0]['child'][$namespace][$tag]))
			{
				return $this->data['child'][SIMPLEPIE_NAMESPACE_RDF]['RDF'][0]['child'][$namespace][$tag];
			}
		}
		if ($type & SIMPLEPIE_TYPE_RSS_SYNDICATION)
		{
			if (isset($this->data['child'][SIMPLEPIE_NAMESPACE_RSS_20]['rss'][0]['child'][$namespace][$tag]))
			{
				return $this->data['child'][SIMPLEPIE_NAMESPACE_RSS_20]['rss'][0]['child'][$namespace][$tag];
			}
		}
		return null;
	}

	public function get_channel_tags($namespace, $tag)
	{
		$type = $this->get_type();
		if ($type & SIMPLEPIE_TYPE_ATOM_ALL)
		{
			if ($return = $this->get_feed_tags($namespace, $tag))
			{
				return $return;
			}
		}
		if ($type & SIMPLEPIE_TYPE_RSS_10)
		{
			if ($channel = $this->get_feed_tags(SIMPLEPIE_NAMESPACE_RSS_10, 'channel'))
			{
				if (isset($channel[0]['child'][$namespace][$tag]))
				{
					return $channel[0]['child'][$namespace][$tag];
				}
			}
		}
		if ($type & SIMPLEPIE_TYPE_RSS_090)
		{
			if ($channel = $this->get_feed_tags(SIMPLEPIE_NAMESPACE_RSS_090, 'channel'))
			{
				if (isset($channel[0]['child'][$namespace][$tag]))
				{
					return $channel[0]['child'][$namespace][$tag];
				}
			}
		}
		if ($type & SIMPLEPIE_TYPE_RSS_SYNDICATION)
		{
			if ($channel = $this->get_feed_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'channel'))
			{
				if (isset($channel[0]['child'][$namespace][$tag]))
				{
					return $channel[0]['child'][$namespace][$tag];
				}
			}
		}
		return null;
	}

	public function get_image_tags($namespace, $tag)
	{
		$type = $this->get_type();
		if ($type & SIMPLEPIE_TYPE_RSS_10)
		{
			if ($image = $this->get_feed_tags(SIMPLEPIE_NAMESPACE_RSS_10, 'image'))
			{
				if (isset($image[0]['child'][$namespace][$tag]))
				{
					return $image[0]['child'][$namespace][$tag];
				}
			}
		}
		if ($type & SIMPLEPIE_TYPE_RSS_090)
		{
			if ($image = $this->get_feed_tags(SIMPLEPIE_NAMESPACE_RSS_090, 'image'))
			{
				if (isset($image[0]['child'][$namespace][$tag]))
				{
					return $image[0]['child'][$namespace][$tag];
				}
			}
		}
		if ($type & SIMPLEPIE_TYPE_RSS_SYNDICATION)
		{
			if ($image = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'image'))
			{
				if (isset($image[0]['child'][$namespace][$tag]))
				{
					return $image[0]['child'][$namespace][$tag];
				}
			}
		}
		return null;
	}

	public function get_base($element = array())
	{
		if (!($this->get_type() & SIMPLEPIE_TYPE_RSS_SYNDICATION) && !empty($element['xml_base_explicit']) && isset($element['xml_base']))
		{
			return $element['xml_base'];
		}
		elseif ($this->get_link() !== null)
		{
			return $this->get_link();
		}
		else
		{
			return '';
		}
	}

	public function sanitize($data, $type, $base = '')
	{
		return $this->sanitize->sanitize($data, $type, $base);
	}

	public function get_title()
	{
		if ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'title'))
		{
			return $this->sanitize($return[0]['data'], SimplePie_Misc::atom_10_construct_type($return[0]['attribs']), $this->get_base($return[0]));
		}
		elseif ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'title'))
		{
			return $this->sanitize($return[0]['data'], SimplePie_Misc::atom_03_construct_type($return[0]['attribs']), $this->get_base($return[0]));
		}
		elseif ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_RSS_10, 'title'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_HTML, $this->get_base($return[0]));
		}
		elseif ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_RSS_090, 'title'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_HTML, $this->get_base($return[0]));
		}
		elseif ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'title'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_HTML, $this->get_base($return[0]));
		}
		elseif ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_DC_11, 'title'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_DC_10, 'title'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		else
		{
			return null;
		}
	}

	public function get_category($key = 0)
	{
		$categories = $this->get_categories();
		if (isset($categories[$key]))
		{
			return $categories[$key];
		}
		else
		{
			return null;
		}
	}

	public function get_categories()
	{
		$categories = array();

		foreach ((array) $this->get_channel_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'category') as $category)
		{
			$term = null;
			$scheme = null;
			$label = null;
			if (isset($category['attribs']['']['term']))
			{
				$term = $this->sanitize($category['attribs']['']['term'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if (isset($category['attribs']['']['scheme']))
			{
				$scheme = $this->sanitize($category['attribs']['']['scheme'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if (isset($category['attribs']['']['label']))
			{
				$label = $this->sanitize($category['attribs']['']['label'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			$categories[] = new SimplePie_Category($term, $scheme, $label);
		}
		foreach ((array) $this->get_channel_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'category') as $category)
		{
			// This is really the label, but keep this as the term also for BC.
			// Label will also work on retrieving because that falls back to term.
			$term = $this->sanitize($category['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			if (isset($category['attribs']['']['domain']))
			{
				$scheme = $this->sanitize($category['attribs']['']['domain'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			else
			{
				$scheme = null;
			}
			$categories[] = new SimplePie_Category($term, $scheme, null);
		}
		foreach ((array) $this->get_channel_tags(SIMPLEPIE_NAMESPACE_DC_11, 'subject') as $category)
		{
			$categories[] = new SimplePie_Category($this->sanitize($category['data'], SIMPLEPIE_CONSTRUCT_TEXT), null, null);
		}
		foreach ((array) $this->get_channel_tags(SIMPLEPIE_NAMESPACE_DC_10, 'subject') as $category)
		{
			$categories[] = new SimplePie_Category($this->sanitize($category['data'], SIMPLEPIE_CONSTRUCT_TEXT), null, null);
		}

		if (!empty($categories))
		{
			return SimplePie_Misc::array_unique($categories);
		}
		else
		{
			return null;
		}
	}

	public function get_author($key = 0)
	{
		$authors = $this->get_authors();
		if (isset($authors[$key]))
		{
			return $authors[$key];
		}
		else
		{
			return null;
		}
	}

	public function get_authors()
	{
		$authors = array();
		foreach ((array) $this->get_channel_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'author') as $author)
		{
			$name = null;
			$uri = null;
			$email = null;
			if (isset($author['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['name'][0]['data']))
			{
				$name = $this->sanitize($author['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['name'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if (isset($author['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['uri'][0]['data']))
			{
				$uri = $this->sanitize($author['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['uri'][0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($author['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['uri'][0]));
			}
			if (isset($author['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['email'][0]['data']))
			{
				$email = $this->sanitize($author['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['email'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if ($name !== null || $email !== null || $uri !== null)
			{
				$authors[] = new SimplePie_Author($name, $uri, $email);
			}
		}
		if ($author = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'author'))
		{
			$name = null;
			$url = null;
			$email = null;
			if (isset($author[0]['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['name'][0]['data']))
			{
				$name = $this->sanitize($author[0]['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['name'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if (isset($author[0]['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['url'][0]['data']))
			{
				$url = $this->sanitize($author[0]['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['url'][0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($author[0]['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['url'][0]));
			}
			if (isset($author[0]['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['email'][0]['data']))
			{
				$email = $this->sanitize($author[0]['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['email'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if ($name !== null || $email !== null || $url !== null)
			{
				$authors[] = new SimplePie_Author($name, $url, $email);
			}
		}
		foreach ((array) $this->get_channel_tags(SIMPLEPIE_NAMESPACE_DC_11, 'creator') as $author)
		{
			$authors[] = new SimplePie_Author($this->sanitize($author['data'], SIMPLEPIE_CONSTRUCT_TEXT), null, null);
		}
		foreach ((array) $this->get_channel_tags(SIMPLEPIE_NAMESPACE_DC_10, 'creator') as $author)
		{
			$authors[] = new SimplePie_Author($this->sanitize($author['data'], SIMPLEPIE_CONSTRUCT_TEXT), null, null);
		}

		if (!empty($authors))
		{
			return SimplePie_Misc::array_unique($authors);
		}
		else
		{
			return null;
		}
	}

	public function get_contributor($key = 0)
	{
		$contributors = $this->get_contributors();
		if (isset($contributors[$key]))
		{
			return $contributors[$key];
		}
		else
		{
			return null;
		}
	}

	public function get_contributors()
	{
		$contributors = array();
		foreach ((array) $this->get_channel_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'contributor') as $contributor)
		{
			$name = null;
			$uri = null;
			$email = null;
			if (isset($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['name'][0]['data']))
			{
				$name = $this->sanitize($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['name'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if (isset($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['uri'][0]['data']))
			{
				$uri = $this->sanitize($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['uri'][0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['uri'][0]));
			}
			if (isset($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['email'][0]['data']))
			{
				$email = $this->sanitize($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['email'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if ($name !== null || $email !== null || $uri !== null)
			{
				$contributors[] = new SimplePie_Author($name, $uri, $email);
			}
		}
		foreach ((array) $this->get_channel_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'contributor') as $contributor)
		{
			$name = null;
			$url = null;
			$email = null;
			if (isset($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['name'][0]['data']))
			{
				$name = $this->sanitize($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['name'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if (isset($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['url'][0]['data']))
			{
				$url = $this->sanitize($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['url'][0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['url'][0]));
			}
			if (isset($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['email'][0]['data']))
			{
				$email = $this->sanitize($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['email'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if ($name !== null || $email !== null || $url !== null)
			{
				$contributors[] = new SimplePie_Author($name, $url, $email);
			}
		}

		if (!empty($contributors))
		{
			return SimplePie_Misc::array_unique($contributors);
		}
		else
		{
			return null;
		}
	}

	public function get_link($key = 0, $rel = 'alternate')
	{
		$links = $this->get_links($rel);
		if (isset($links[$key]))
		{
			return $links[$key];
		}
		else
		{
			return null;
		}
	}

	/**
	 * Added for parity between the parent-level and the item/entry-level.
	 */
	public function get_permalink()
	{
		return $this->get_link(0);
	}

	public function get_links($rel = 'alternate')
	{
		if (!isset($this->data['links']))
		{
			$this->data['links'] = array();
			if ($links = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'link'))
			{
				foreach ($links as $link)
				{
					if (isset($link['attribs']['']['href']))
					{
						$link_rel = (isset($link['attribs']['']['rel'])) ? $link['attribs']['']['rel'] : 'alternate';
						$this->data['links'][$link_rel][] = $this->sanitize($link['attribs']['']['href'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($link));
					}
				}
			}
			if ($links = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'link'))
			{
				foreach ($links as $link)
				{
					if (isset($link['attribs']['']['href']))
					{
						$link_rel = (isset($link['attribs']['']['rel'])) ? $link['attribs']['']['rel'] : 'alternate';
						$this->data['links'][$link_rel][] = $this->sanitize($link['attribs']['']['href'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($link));

					}
				}
			}
			if ($links = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_RSS_10, 'link'))
			{
				$this->data['links']['alternate'][] = $this->sanitize($links[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($links[0]));
			}
			if ($links = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_RSS_090, 'link'))
			{
				$this->data['links']['alternate'][] = $this->sanitize($links[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($links[0]));
			}
			if ($links = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'link'))
			{
				$this->data['links']['alternate'][] = $this->sanitize($links[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($links[0]));
			}

			$keys = array_keys($this->data['links']);
			foreach ($keys as $key)
			{
				if (SimplePie_Misc::is_isegment_nz_nc($key))
				{
					if (isset($this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key]))
					{
						$this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key] = array_merge($this->data['links'][$key], $this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key]);
						$this->data['links'][$key] =& $this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key];
					}
					else
					{
						$this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key] =& $this->data['links'][$key];
					}
				}
				elseif (substr($key, 0, 41) === SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY)
				{
					$this->data['links'][substr($key, 41)] =& $this->data['links'][$key];
				}
				$this->data['links'][$key] = array_unique($this->data['links'][$key]);
			}
		}

		if (isset($this->data['links'][$rel]))
		{
			return $this->data['links'][$rel];
		}
		else
		{
			return null;
		}
	}

	public function get_description()
	{
		if ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'subtitle'))
		{
			return $this->sanitize($return[0]['data'], SimplePie_Misc::atom_10_construct_type($return[0]['attribs']), $this->get_base($return[0]));
		}
		elseif ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'tagline'))
		{
			return $this->sanitize($return[0]['data'], SimplePie_Misc::atom_03_construct_type($return[0]['attribs']), $this->get_base($return[0]));
		}
		elseif ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_RSS_10, 'description'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_HTML, $this->get_base($return[0]));
		}
		elseif ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_RSS_090, 'description'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_HTML, $this->get_base($return[0]));
		}
		elseif ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'description'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_HTML, $this->get_base($return[0]));
		}
		elseif ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_DC_11, 'description'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_DC_10, 'description'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		else
		{
			return null;
		}
	}

	public function get_copyright()
	{
		if ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'rights'))
		{
			return $this->sanitize($return[0]['data'], SimplePie_Misc::atom_10_construct_type($return[0]['attribs']), $this->get_base($return[0]));
		}
		elseif ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'copyright'))
		{
			return $this->sanitize($return[0]['data'], SimplePie_Misc::atom_03_construct_type($return[0]['attribs']), $this->get_base($return[0]));
		}
		elseif ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'copyright'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_DC_11, 'rights'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_DC_10, 'rights'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		else
		{
			return null;
		}
	}

	public function get_language()
	{
		if ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'language'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_DC_11, 'language'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_DC_10, 'language'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif (isset($this->data['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['feed'][0]['xml_lang']))
		{
			return $this->sanitize($this->data['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['feed'][0]['xml_lang'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif (isset($this->data['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['feed'][0]['xml_lang']))
		{
			return $this->sanitize($this->data['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['feed'][0]['xml_lang'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif (isset($this->data['child'][SIMPLEPIE_NAMESPACE_RDF]['RDF'][0]['xml_lang']))
		{
			return $this->sanitize($this->data['child'][SIMPLEPIE_NAMESPACE_RDF]['RDF'][0]['xml_lang'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif (isset($this->data['headers']['content-language']))
		{
			return $this->sanitize($this->data['headers']['content-language'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		else
		{
			return null;
		}
	}

	public function get_image_title()
	{
		if ($return = $this->get_image_tags(SIMPLEPIE_NAMESPACE_RSS_10, 'title'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif ($return = $this->get_image_tags(SIMPLEPIE_NAMESPACE_RSS_090, 'title'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif ($return = $this->get_image_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'title'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif ($return = $this->get_image_tags(SIMPLEPIE_NAMESPACE_DC_11, 'title'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif ($return = $this->get_image_tags(SIMPLEPIE_NAMESPACE_DC_10, 'title'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		else
		{
			return null;
		}
	}

	public function get_image_url()
	{
		if ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'logo'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($return[0]));
		}
		elseif ($return = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'icon'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($return[0]));
		}
		elseif ($return = $this->get_image_tags(SIMPLEPIE_NAMESPACE_RSS_10, 'url'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($return[0]));
		}
		elseif ($return = $this->get_image_tags(SIMPLEPIE_NAMESPACE_RSS_090, 'url'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($return[0]));
		}
		elseif ($return = $this->get_image_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'url'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($return[0]));
		}
		else
		{
			return null;
		}
	}

	public function get_image_link()
	{
		if ($return = $this->get_image_tags(SIMPLEPIE_NAMESPACE_RSS_10, 'link'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($return[0]));
		}
		elseif ($return = $this->get_image_tags(SIMPLEPIE_NAMESPACE_RSS_090, 'link'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($return[0]));
		}
		elseif ($return = $this->get_image_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'link'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($return[0]));
		}
		else
		{
			return null;
		}
	}

	public function get_image_width()
	{
		if ($return = $this->get_image_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'width'))
		{
			return round($return[0]['data']);
		}
		elseif ($this->get_type() & SIMPLEPIE_TYPE_RSS_SYNDICATION && $this->get_image_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'url'))
		{
			return 88.0;
		}
		else
		{
			return null;
		}
	}

	public function get_image_height()
	{
		if ($return = $this->get_image_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'height'))
		{
			return round($return[0]['data']);
		}
		elseif ($this->get_type() & SIMPLEPIE_TYPE_RSS_SYNDICATION && $this->get_image_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'url'))
		{
			return 31.0;
		}
		else
		{
			return null;
		}
	}

	public function get_item_quantity($max = 0)
	{
		$max = (int) $max;
		$qty = count($this->get_items());
		if ($max === 0)
		{
			return $qty;
		}
		else
		{
			return ($qty > $max) ? $max : $qty;
		}
	}

	public function get_item($key = 0)
	{
		$items = $this->get_items();
		if (isset($items[$key]))
		{
			return $items[$key];
		}
		else
		{
			return null;
		}
	}

	public function get_items()
	{
		if (!isset($this->data['items']))
		{
            $this->data['items'] = array();
            if ($items = $this->get_feed_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'entry'))
            {
                $keys = array_keys($items);
                foreach ($keys as $key)
                {
                    $this->data['items'][] = new SimplePie_Item($this, $items[$key]);
                }
            }
            if ($items = $this->get_feed_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'entry'))
            {
                $keys = array_keys($items);
                foreach ($keys as $key)
                {
                    $this->data['items'][] = new SimplePie_Item($this, $items[$key]);
                }
            }
            if ($items = $this->get_feed_tags(SIMPLEPIE_NAMESPACE_RSS_10, 'item'))
            {
                $keys = array_keys($items);
                foreach ($keys as $key)
                {
                    $this->data['items'][] = new SimplePie_Item($this, $items[$key]);
                }
            }
            if ($items = $this->get_feed_tags(SIMPLEPIE_NAMESPACE_RSS_090, 'item'))
            {
                $keys = array_keys($items);
                foreach ($keys as $key)
                {
                    $this->data['items'][] = new SimplePie_Item($this, $items[$key]);
                }
            }
            if ($items = $this->get_channel_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'item'))
            {
                $keys = array_keys($items);
                foreach ($keys as $key)
                {
                    $this->data['items'][] = new SimplePie_Item($this, $items[$key]);
                }
            }
		}

		if (!empty($this->data['items']))
		{
            return $this->data['items'];
		}
		else
		{
			return array();
		}
	}
}

class SimplePie_Item
{
	var $feed;
	var $data = array();

	public function __construct($feed, $data)
	{
		$this->feed = $feed;
		$this->data = $data;
	}

	public function __toString()
	{
		return md5(serialize($this->data));
	}

	/**
	 * Remove items that link back to this before destroying this object
	 */
	public function __destruct()
	{
		if ((version_compare(PHP_VERSION, '5.3', '<') || !gc_enabled()) && !ini_get('zend.ze1_compatibility_mode'))
		{
			unset($this->feed);
		}
	}

	public function get_item_tags($namespace, $tag)
	{
		if (isset($this->data['child'][$namespace][$tag]))
		{
			return $this->data['child'][$namespace][$tag];
		}
		else
		{
			return null;
		}
	}

	public function get_base($element = array())
	{
		return $this->feed->get_base($element);
	}

	public function sanitize($data, $type, $base = '')
	{
		return $this->feed->sanitize($data, $type, $base);
	}

	public function get_feed()
	{
		return $this->feed;
	}

	public function get_id($hash = false)
	{
		if (!$hash)
		{
			if ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'id'))
			{
				return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'id'))
			{
				return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'guid'))
			{
				return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_DC_11, 'identifier'))
			{
				return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_DC_10, 'identifier'))
			{
				return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			elseif (($return = $this->get_permalink()) !== null)
			{
				return $return;
			}
			elseif (($return = $this->get_title()) !== null)
			{
				return $return;
			}
		}
		if ($this->get_permalink() !== null || $this->get_title() !== null)
		{
			return md5($this->get_permalink() . $this->get_title());
		}
		else
		{
			return md5(serialize($this->data));
		}
	}

	public function get_title()
	{
		if (!isset($this->data['title']))
		{
			if ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'title'))
			{
				$this->data['title'] = $this->sanitize($return[0]['data'], SimplePie_Misc::atom_10_construct_type($return[0]['attribs']), $this->get_base($return[0]));
			}
			elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'title'))
			{
				$this->data['title'] = $this->sanitize($return[0]['data'], SimplePie_Misc::atom_03_construct_type($return[0]['attribs']), $this->get_base($return[0]));
			}
			elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_10, 'title'))
			{
				$this->data['title'] = $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_HTML, $this->get_base($return[0]));
			}
			elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_090, 'title'))
			{
				$this->data['title'] = $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_HTML, $this->get_base($return[0]));
			}
			elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'title'))
			{
				$this->data['title'] = $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_HTML, $this->get_base($return[0]));
			}
			elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_DC_11, 'title'))
			{
				$this->data['title'] = $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_DC_10, 'title'))
			{
				$this->data['title'] = $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			else
			{
				$this->data['title'] = null;
			}
		}
		return $this->data['title'];
	}

	public function get_description($description_only = false)
	{
		if ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'summary'))
		{
			return $this->sanitize($return[0]['data'], SimplePie_Misc::atom_10_construct_type($return[0]['attribs']), $this->get_base($return[0]));
		}
		elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'summary'))
		{
			return $this->sanitize($return[0]['data'], SimplePie_Misc::atom_03_construct_type($return[0]['attribs']), $this->get_base($return[0]));
		}
		elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_10, 'description'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_HTML, $this->get_base($return[0]));
		}
		elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'description'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_HTML, $this->get_base($return[0]));
		}
		elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_DC_11, 'description'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_DC_10, 'description'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif (!$description_only)
		{
			return $this->get_content(true);
		}
		else
		{
			return null;
		}
	}

	public function get_content($content_only = false)
	{
		if ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'content'))
		{
			return $this->sanitize($return[0]['data'], SimplePie_Misc::atom_10_content_construct_type($return[0]['attribs']), $this->get_base($return[0]));
		}
		elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'content'))
		{
			return $this->sanitize($return[0]['data'], SimplePie_Misc::atom_03_construct_type($return[0]['attribs']), $this->get_base($return[0]));
		}
		elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_10_MODULES_CONTENT, 'encoded'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_HTML, $this->get_base($return[0]));
		}
		elseif (!$content_only)
		{
			return $this->get_description(true);
		}
		else
		{
			return null;
		}
	}

	public function get_category($key = 0)
	{
		$categories = $this->get_categories();
		if (isset($categories[$key]))
		{
			return $categories[$key];
		}
		else
		{
			return null;
		}
	}

	public function get_categories()
	{
		$categories = array();

		foreach ((array) $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'category') as $category)
		{
			$term = null;
			$scheme = null;
			$label = null;
			if (isset($category['attribs']['']['term']))
			{
				$term = $this->sanitize($category['attribs']['']['term'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if (isset($category['attribs']['']['scheme']))
			{
				$scheme = $this->sanitize($category['attribs']['']['scheme'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if (isset($category['attribs']['']['label']))
			{
				$label = $this->sanitize($category['attribs']['']['label'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			$categories[] = new SimplePie_Category($term, $scheme, $label);
		}
		foreach ((array) $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'category') as $category)
		{
			// This is really the label, but keep this as the term also for BC.
			// Label will also work on retrieving because that falls back to term.
			$term = $this->sanitize($category['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			if (isset($category['attribs']['']['domain']))
			{
				$scheme = $this->sanitize($category['attribs']['']['domain'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			else
			{
				$scheme = null;
			}
			$categories[] = new SimplePie_Category($term, $scheme, null);
		}
		foreach ((array) $this->get_item_tags(SIMPLEPIE_NAMESPACE_DC_11, 'subject') as $category)
		{
			$categories[] = new SimplePie_Category($this->sanitize($category['data'], SIMPLEPIE_CONSTRUCT_TEXT), null, null);
		}
		foreach ((array) $this->get_item_tags(SIMPLEPIE_NAMESPACE_DC_10, 'subject') as $category)
		{
			$categories[] = new SimplePie_Category($this->sanitize($category['data'], SIMPLEPIE_CONSTRUCT_TEXT), null, null);
		}

		if (!empty($categories))
		{
			return SimplePie_Misc::array_unique($categories);
		}
		else
		{
			return null;
		}
	}

	public function get_author($key = 0)
	{
		$authors = $this->get_authors();
		if (isset($authors[$key]))
		{
			return $authors[$key];
		}
		else
		{
			return null;
		}
	}

	public function get_contributor($key = 0)
	{
		$contributors = $this->get_contributors();
		if (isset($contributors[$key]))
		{
			return $contributors[$key];
		}
		else
		{
			return null;
		}
	}

	public function get_contributors()
	{
		$contributors = array();
		foreach ((array) $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'contributor') as $contributor)
		{
			$name = null;
			$uri = null;
			$email = null;
			if (isset($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['name'][0]['data']))
			{
				$name = $this->sanitize($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['name'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if (isset($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['uri'][0]['data']))
			{
				$uri = $this->sanitize($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['uri'][0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['uri'][0]));
			}
			if (isset($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['email'][0]['data']))
			{
				$email = $this->sanitize($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['email'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if ($name !== null || $email !== null || $uri !== null)
			{
				$contributors[] = new SimplePie_Author($name, $uri, $email);
			}
		}
		foreach ((array) $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'contributor') as $contributor)
		{
			$name = null;
			$url = null;
			$email = null;
			if (isset($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['name'][0]['data']))
			{
				$name = $this->sanitize($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['name'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if (isset($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['url'][0]['data']))
			{
				$url = $this->sanitize($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['url'][0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['url'][0]));
			}
			if (isset($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['email'][0]['data']))
			{
				$email = $this->sanitize($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['email'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if ($name !== null || $email !== null || $url !== null)
			{
				$contributors[] = new SimplePie_Author($name, $url, $email);
			}
		}

		if (!empty($contributors))
		{
			return SimplePie_Misc::array_unique($contributors);
		}
		else
		{
			return null;
		}
	}

	public function get_authors()
	{
		$authors = array();
		foreach ((array) $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'author') as $author)
		{
			$name = null;
			$uri = null;
			$email = null;
			if (isset($author['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['name'][0]['data']))
			{
				$name = $this->sanitize($author['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['name'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if (isset($author['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['uri'][0]['data']))
			{
				$uri = $this->sanitize($author['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['uri'][0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($author['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['uri'][0]));
			}
			if (isset($author['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['email'][0]['data']))
			{
				$email = $this->sanitize($author['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['email'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if ($name !== null || $email !== null || $uri !== null)
			{
				$authors[] = new SimplePie_Author($name, $uri, $email);
			}
		}
		if ($author = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'author'))
		{
			$name = null;
			$url = null;
			$email = null;
			if (isset($author[0]['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['name'][0]['data']))
			{
				$name = $this->sanitize($author[0]['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['name'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if (isset($author[0]['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['url'][0]['data']))
			{
				$url = $this->sanitize($author[0]['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['url'][0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($author[0]['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['url'][0]));
			}
			if (isset($author[0]['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['email'][0]['data']))
			{
				$email = $this->sanitize($author[0]['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['email'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if ($name !== null || $email !== null || $url !== null)
			{
				$authors[] = new SimplePie_Author($name, $url, $email);
			}
		}
		if ($author = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'author'))
		{
			$authors[] = new SimplePie_Author(null, null, $this->sanitize($author[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT));
		}
		foreach ((array) $this->get_item_tags(SIMPLEPIE_NAMESPACE_DC_11, 'creator') as $author)
		{
			$authors[] = new SimplePie_Author($this->sanitize($author['data'], SIMPLEPIE_CONSTRUCT_TEXT), null, null);
		}
		foreach ((array) $this->get_item_tags(SIMPLEPIE_NAMESPACE_DC_10, 'creator') as $author)
		{
			$authors[] = new SimplePie_Author($this->sanitize($author['data'], SIMPLEPIE_CONSTRUCT_TEXT), null, null);
		}

		if (!empty($authors))
		{
			return SimplePie_Misc::array_unique($authors);
		}
		elseif (($source = $this->get_source()) && ($authors = $source->get_authors()))
		{
			return $authors;
		}
		elseif ($authors = $this->feed->get_authors())
		{
			return $authors;
		}
		else
		{
			return null;
		}
	}

	public function get_copyright()
	{
		if ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'rights'))
		{
			return $this->sanitize($return[0]['data'], SimplePie_Misc::atom_10_construct_type($return[0]['attribs']), $this->get_base($return[0]));
		}
		elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_DC_11, 'rights'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_DC_10, 'rights'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		else
		{
			return null;
		}
	}

	public function get_date($date_format = 'j F Y, g:i a')
	{
		if (!isset($this->data['date']))
		{
			if ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'published'))
			{
				$this->data['date']['raw'] = $return[0]['data'];
			}
			elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'updated'))
			{
				$this->data['date']['raw'] = $return[0]['data'];
			}
			elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'issued'))
			{
				$this->data['date']['raw'] = $return[0]['data'];
			}
			elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'created'))
			{
				$this->data['date']['raw'] = $return[0]['data'];
			}
			elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'modified'))
			{
				$this->data['date']['raw'] = $return[0]['data'];
			}
			elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'pubDate'))
			{
				$this->data['date']['raw'] = $return[0]['data'];
			}
			elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_DC_11, 'date'))
			{
				$this->data['date']['raw'] = $return[0]['data'];
			}
			elseif ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_DC_10, 'date'))
			{
				$this->data['date']['raw'] = $return[0]['data'];
			}

			if (!empty($this->data['date']['raw']))
			{
				$parser = SimplePie_Parse_Date::get();
				$this->data['date']['parsed'] = $parser->parse($this->data['date']['raw']);
			}
			else
			{
				$this->data['date'] = null;
			}
		}
		if ($this->data['date'])
		{
			$date_format = (string) $date_format;
			switch ($date_format)
			{
				case '':
					return $this->sanitize($this->data['date']['raw'], SIMPLEPIE_CONSTRUCT_TEXT);

				case 'U':
					return $this->data['date']['parsed'];

				default:
					return date($date_format, $this->data['date']['parsed']);
			}
		}
		else
		{
			return null;
		}
	}

	public function get_local_date($date_format = '%c')
	{
		if (!$date_format)
		{
			return $this->sanitize($this->get_date(''), SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif (($date = $this->get_date('U')) !== null)
		{
			return strftime($date_format, $date);
		}
		else
		{
			return null;
		}
	}

	public function get_permalink()
	{
		$link = $this->get_link();
		$enclosure = $this->get_enclosure(0);
		if ($link !== null)
		{
			return $link;
		}
		elseif ($enclosure !== null)
		{
			return $enclosure->get_link();
		}
		else
		{
			return null;
		}
	}

	public function get_link($key = 0, $rel = 'alternate')
	{
		$links = $this->get_links($rel);
		if ($links[$key] !== null)
		{
			return $links[$key];
		}
		else
		{
			return null;
		}
	}

	public function get_links($rel = 'alternate')
	{
		if (!isset($this->data['links']))
		{
			$this->data['links'] = array();
			foreach ((array) $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'link') as $link)
			{
				if (isset($link['attribs']['']['href']))
				{
					$link_rel = (isset($link['attribs']['']['rel'])) ? $link['attribs']['']['rel'] : 'alternate';
					$this->data['links'][$link_rel][] = $this->sanitize($link['attribs']['']['href'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($link));

				}
			}
			foreach ((array) $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'link') as $link)
			{
				if (isset($link['attribs']['']['href']))
				{
					$link_rel = (isset($link['attribs']['']['rel'])) ? $link['attribs']['']['rel'] : 'alternate';
					$this->data['links'][$link_rel][] = $this->sanitize($link['attribs']['']['href'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($link));
				}
			}
			if ($links = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_10, 'link'))
			{
				$this->data['links']['alternate'][] = $this->sanitize($links[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($links[0]));
			}
			if ($links = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_090, 'link'))
			{
				$this->data['links']['alternate'][] = $this->sanitize($links[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($links[0]));
			}
			if ($links = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'link'))
			{
				$this->data['links']['alternate'][] = $this->sanitize($links[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($links[0]));
			}
			if ($links = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'guid'))
			{
				if (!isset($links[0]['attribs']['']['isPermaLink']) || strtolower(trim($links[0]['attribs']['']['isPermaLink'])) === 'true')
				{
					$this->data['links']['alternate'][] = $this->sanitize($links[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($links[0]));
				}
			}

			$keys = array_keys($this->data['links']);
			foreach ($keys as $key)
			{
				if (SimplePie_Misc::is_isegment_nz_nc($key))
				{
					if (isset($this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key]))
					{
						$this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key] = array_merge($this->data['links'][$key], $this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key]);
						$this->data['links'][$key] =& $this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key];
					}
					else
					{
						$this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key] =& $this->data['links'][$key];
					}
				}
				elseif (substr($key, 0, 41) === SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY)
				{
					$this->data['links'][substr($key, 41)] =& $this->data['links'][$key];
				}
				$this->data['links'][$key] = array_unique($this->data['links'][$key]);
			}
		}
		if (isset($this->data['links'][$rel]))
		{
			return $this->data['links'][$rel];
		}
		else
		{
			return null;
		}
	}

	/**
	 * @todo Add ability to prefer one type of content over another (in a media group).
	 */
	public function get_enclosure($key = 0, $prefer = null)
	{
		$enclosures = $this->get_enclosures();
		if (isset($enclosures[$key]))
		{
			return $enclosures[$key];
		}
		else
		{
			return null;
		}
	}

	/**
	 * Grabs all available enclosures (podcasts, etc.)
	 *
	 * Supports the <enclosure> RSS tag.
	 *
	 * At this point, we're pretty much assuming that all enclosures for an item are the same content.	 Anything else is too complicated to properly support.
	 *
	 * @todo Add support for end-user defined sorting of enclosures by type/handler (so we can prefer the faster-loading FLV over MP4).
	 * @todo If an element exists at a level, but it's value is empty, we should fall back to the value from the parent (if it exists).
	 */
	public function get_enclosures()
	{
		if (!isset($this->data['enclosures']))
		{
			$this->data['enclosures'] = array();

			// Elements
			$captions_parent = null;
			$categories_parent = null;
			$copyrights_parent = null;
			$credits_parent = null;
			$description_parent = null;
			$duration_parent = null;
			$hashes_parent = null;
			$keywords_parent = null;
			$player_parent = null;
			$ratings_parent = null;
			$restrictions_parent = null;
			$thumbnails_parent = null;
			$title_parent = null;

			// Let's do the channel and item-level ones first, and just re-use them if we need to.
			$parent = $this->get_feed();

			foreach ((array) $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'link') as $link)
			{
				if (isset($link['attribs']['']['href']) && !empty($link['attribs']['']['rel']) && $link['attribs']['']['rel'] === 'enclosure')
				{
					$url = $this->sanitize($link['attribs']['']['href'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($link));
					if (isset($link['attribs']['']['type']))
					{
						$type = $this->sanitize($link['attribs']['']['type'], SIMPLEPIE_CONSTRUCT_TEXT);
					}
					else
					{
						$type = null;
					}
					if (isset($link['attribs']['']['length']))
					{
						$length = ceil($link['attribs']['']['length']);
					}
					else
					{
						$length = null;
					}

					// Since we don't have group or content for these, we'll just pass the '*_parent' variables directly to the constructor
					$this->data['enclosures'][] = new SimplePie_Enclosure($url, $type, $length);
				}
			}

			foreach ((array) $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'link') as $link)
			{
				if (isset($link['attribs']['']['href']) && !empty($link['attribs']['']['rel']) && $link['attribs']['']['rel'] === 'enclosure')
				{
					$url = $this->sanitize($link['attribs']['']['href'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($link));
					if (isset($link['attribs']['']['type']))
					{
						$type = $this->sanitize($link['attribs']['']['type'], SIMPLEPIE_CONSTRUCT_TEXT);
					}
					else
					{
						$type = null;
					}
					if (isset($link['attribs']['']['length']))
					{
						$length = ceil($link['attribs']['']['length']);
					}
					else
					{
						$length = null;
					}

					// Since we don't have group or content for these, we'll just pass the '*_parent' variables directly to the constructor
					$this->data['enclosures'][] = new SimplePie_Enclosure($url, $type, $length);
				}
			}

			if ($enclosure = $this->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'enclosure'))
			{
				if (isset($enclosure[0]['attribs']['']['url']))
				{
					$url = $this->sanitize($enclosure[0]['attribs']['']['url'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($enclosure[0]));
					if (isset($enclosure[0]['attribs']['']['type']))
					{
						$type = $this->sanitize($enclosure[0]['attribs']['']['type'], SIMPLEPIE_CONSTRUCT_TEXT);
					}
					else
					{
						$type = null;
					}
					if (isset($enclosure[0]['attribs']['']['length']))
					{
						$length = ceil($enclosure[0]['attribs']['']['length']);
					}
					else
					{
						$length = null;
					}

					// Since we don't have group or content for these, we'll just pass the '*_parent' variables directly to the constructor
					$this->data['enclosures'][] = new SimplePie_Enclosure($url, $type, $length);
				}
			}

			$this->data['enclosures'] = array_values(SimplePie_Misc::array_unique($this->data['enclosures']));
		}
		if (!empty($this->data['enclosures']))
		{
			return $this->data['enclosures'];
		}
		else
		{
			return null;
		}
	}

	public function get_source()
	{
		if ($return = $this->get_item_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'source'))
		{
			return new SimplePie_Source($this, $return[0]);
		}
		else
		{
			return null;
		}
	}
}

class SimplePie_Source
{
	var $item;
	var $data = array();

	public function __construct($item, $data)
	{
		$this->item = $item;
		$this->data = $data;
	}

	public function __toString()
	{
		return md5(serialize($this->data));
	}

	public function get_source_tags($namespace, $tag)
	{
		if (isset($this->data['child'][$namespace][$tag]))
		{
			return $this->data['child'][$namespace][$tag];
		}
		else
		{
			return null;
		}
	}

	public function get_base($element = array())
	{
		return $this->item->get_base($element);
	}

	public function sanitize($data, $type, $base = '')
	{
		return $this->item->sanitize($data, $type, $base);
	}

	public function get_item()
	{
		return $this->item;
	}

	public function get_title()
	{
		if ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'title'))
		{
			return $this->sanitize($return[0]['data'], SimplePie_Misc::atom_10_construct_type($return[0]['attribs']), $this->get_base($return[0]));
		}
		elseif ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'title'))
		{
			return $this->sanitize($return[0]['data'], SimplePie_Misc::atom_03_construct_type($return[0]['attribs']), $this->get_base($return[0]));
		}
		elseif ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_RSS_10, 'title'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_HTML, $this->get_base($return[0]));
		}
		elseif ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_RSS_090, 'title'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_HTML, $this->get_base($return[0]));
		}
		elseif ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'title'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_HTML, $this->get_base($return[0]));
		}
		elseif ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_DC_11, 'title'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_DC_10, 'title'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		else
		{
			return null;
		}
	}

	public function get_category($key = 0)
	{
		$categories = $this->get_categories();
		if (isset($categories[$key]))
		{
			return $categories[$key];
		}
		else
		{
			return null;
		}
	}

	public function get_categories()
	{
		$categories = array();

		foreach ((array) $this->get_source_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'category') as $category)
		{
			$term = null;
			$scheme = null;
			$label = null;
			if (isset($category['attribs']['']['term']))
			{
				$term = $this->sanitize($category['attribs']['']['term'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if (isset($category['attribs']['']['scheme']))
			{
				$scheme = $this->sanitize($category['attribs']['']['scheme'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if (isset($category['attribs']['']['label']))
			{
				$label = $this->sanitize($category['attribs']['']['label'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			$categories[] = new SimplePie_Category($term, $scheme, $label);
		}
		foreach ((array) $this->get_source_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'category') as $category)
		{
			// This is really the label, but keep this as the term also for BC.
			// Label will also work on retrieving because that falls back to term.
			$term = $this->sanitize($category['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			if (isset($category['attribs']['']['domain']))
			{
				$scheme = $this->sanitize($category['attribs']['']['domain'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			else
			{
				$scheme = null;
			}
			$categories[] = new SimplePie_Category($term, $scheme, null);
		}
		foreach ((array) $this->get_source_tags(SIMPLEPIE_NAMESPACE_DC_11, 'subject') as $category)
		{
			$categories[] = new SimplePie_Category($this->sanitize($category['data'], SIMPLEPIE_CONSTRUCT_TEXT), null, null);
		}
		foreach ((array) $this->get_source_tags(SIMPLEPIE_NAMESPACE_DC_10, 'subject') as $category)
		{
			$categories[] = new SimplePie_Category($this->sanitize($category['data'], SIMPLEPIE_CONSTRUCT_TEXT), null, null);
		}

		if (!empty($categories))
		{
			return SimplePie_Misc::array_unique($categories);
		}
		else
		{
			return null;
		}
	}

	public function get_author($key = 0)
	{
		$authors = $this->get_authors();
		if (isset($authors[$key]))
		{
			return $authors[$key];
		}
		else
		{
			return null;
		}
	}

	public function get_authors()
	{
		$authors = array();
		foreach ((array) $this->get_source_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'author') as $author)
		{
			$name = null;
			$uri = null;
			$email = null;
			if (isset($author['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['name'][0]['data']))
			{
				$name = $this->sanitize($author['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['name'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if (isset($author['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['uri'][0]['data']))
			{
				$uri = $this->sanitize($author['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['uri'][0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($author['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['uri'][0]));
			}
			if (isset($author['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['email'][0]['data']))
			{
				$email = $this->sanitize($author['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['email'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if ($name !== null || $email !== null || $uri !== null)
			{
				$authors[] = new SimplePie_Author($name, $uri, $email);
			}
		}
		if ($author = $this->get_source_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'author'))
		{
			$name = null;
			$url = null;
			$email = null;
			if (isset($author[0]['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['name'][0]['data']))
			{
				$name = $this->sanitize($author[0]['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['name'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if (isset($author[0]['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['url'][0]['data']))
			{
				$url = $this->sanitize($author[0]['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['url'][0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($author[0]['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['url'][0]));
			}
			if (isset($author[0]['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['email'][0]['data']))
			{
				$email = $this->sanitize($author[0]['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['email'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if ($name !== null || $email !== null || $url !== null)
			{
				$authors[] = new SimplePie_Author($name, $url, $email);
			}
		}
		foreach ((array) $this->get_source_tags(SIMPLEPIE_NAMESPACE_DC_11, 'creator') as $author)
		{
			$authors[] = new SimplePie_Author($this->sanitize($author['data'], SIMPLEPIE_CONSTRUCT_TEXT), null, null);
		}
		foreach ((array) $this->get_source_tags(SIMPLEPIE_NAMESPACE_DC_10, 'creator') as $author)
		{
			$authors[] = new SimplePie_Author($this->sanitize($author['data'], SIMPLEPIE_CONSTRUCT_TEXT), null, null);
		}

		if (!empty($authors))
		{
			return SimplePie_Misc::array_unique($authors);
		}
		else
		{
			return null;
		}
	}

	public function get_contributor($key = 0)
	{
		$contributors = $this->get_contributors();
		if (isset($contributors[$key]))
		{
			return $contributors[$key];
		}
		else
		{
			return null;
		}
	}

	public function get_contributors()
	{
		$contributors = array();
		foreach ((array) $this->get_source_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'contributor') as $contributor)
		{
			$name = null;
			$uri = null;
			$email = null;
			if (isset($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['name'][0]['data']))
			{
				$name = $this->sanitize($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['name'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if (isset($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['uri'][0]['data']))
			{
				$uri = $this->sanitize($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['uri'][0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['uri'][0]));
			}
			if (isset($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['email'][0]['data']))
			{
				$email = $this->sanitize($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['email'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if ($name !== null || $email !== null || $uri !== null)
			{
				$contributors[] = new SimplePie_Author($name, $uri, $email);
			}
		}
		foreach ((array) $this->get_source_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'contributor') as $contributor)
		{
			$name = null;
			$url = null;
			$email = null;
			if (isset($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['name'][0]['data']))
			{
				$name = $this->sanitize($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['name'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if (isset($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['url'][0]['data']))
			{
				$url = $this->sanitize($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['url'][0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['url'][0]));
			}
			if (isset($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['email'][0]['data']))
			{
				$email = $this->sanitize($contributor['child'][SIMPLEPIE_NAMESPACE_ATOM_03]['email'][0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
			}
			if ($name !== null || $email !== null || $url !== null)
			{
				$contributors[] = new SimplePie_Author($name, $url, $email);
			}
		}

		if (!empty($contributors))
		{
			return SimplePie_Misc::array_unique($contributors);
		}
		else
		{
			return null;
		}
	}

	public function get_link($key = 0, $rel = 'alternate')
	{
		$links = $this->get_links($rel);
		if (isset($links[$key]))
		{
			return $links[$key];
		}
		else
		{
			return null;
		}
	}

	/**
	 * Added for parity between the parent-level and the item/entry-level.
	 */
	public function get_permalink()
	{
		return $this->get_link(0);
	}

	public function get_links($rel = 'alternate')
	{
		if (!isset($this->data['links']))
		{
			$this->data['links'] = array();
			if ($links = $this->get_source_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'link'))
			{
				foreach ($links as $link)
				{
					if (isset($link['attribs']['']['href']))
					{
						$link_rel = (isset($link['attribs']['']['rel'])) ? $link['attribs']['']['rel'] : 'alternate';
						$this->data['links'][$link_rel][] = $this->sanitize($link['attribs']['']['href'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($link));
					}
				}
			}
			if ($links = $this->get_source_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'link'))
			{
				foreach ($links as $link)
				{
					if (isset($link['attribs']['']['href']))
					{
						$link_rel = (isset($link['attribs']['']['rel'])) ? $link['attribs']['']['rel'] : 'alternate';
						$this->data['links'][$link_rel][] = $this->sanitize($link['attribs']['']['href'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($link));

					}
				}
			}
			if ($links = $this->get_source_tags(SIMPLEPIE_NAMESPACE_RSS_10, 'link'))
			{
				$this->data['links']['alternate'][] = $this->sanitize($links[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($links[0]));
			}
			if ($links = $this->get_source_tags(SIMPLEPIE_NAMESPACE_RSS_090, 'link'))
			{
				$this->data['links']['alternate'][] = $this->sanitize($links[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($links[0]));
			}
			if ($links = $this->get_source_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'link'))
			{
				$this->data['links']['alternate'][] = $this->sanitize($links[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($links[0]));
			}

			$keys = array_keys($this->data['links']);
			foreach ($keys as $key)
			{
				if (SimplePie_Misc::is_isegment_nz_nc($key))
				{
					if (isset($this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key]))
					{
						$this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key] = array_merge($this->data['links'][$key], $this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key]);
						$this->data['links'][$key] =& $this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key];
					}
					else
					{
						$this->data['links'][SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY . $key] =& $this->data['links'][$key];
					}
				}
				elseif (substr($key, 0, 41) === SIMPLEPIE_IANA_LINK_RELATIONS_REGISTRY)
				{
					$this->data['links'][substr($key, 41)] =& $this->data['links'][$key];
				}
				$this->data['links'][$key] = array_unique($this->data['links'][$key]);
			}
		}

		if (isset($this->data['links'][$rel]))
		{
			return $this->data['links'][$rel];
		}
		else
		{
			return null;
		}
	}

	public function get_description()
	{
		if ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'subtitle'))
		{
			return $this->sanitize($return[0]['data'], SimplePie_Misc::atom_10_construct_type($return[0]['attribs']), $this->get_base($return[0]));
		}
		elseif ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'tagline'))
		{
			return $this->sanitize($return[0]['data'], SimplePie_Misc::atom_03_construct_type($return[0]['attribs']), $this->get_base($return[0]));
		}
		elseif ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_RSS_10, 'description'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_HTML, $this->get_base($return[0]));
		}
		elseif ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_RSS_090, 'description'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_HTML, $this->get_base($return[0]));
		}
		elseif ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'description'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_HTML, $this->get_base($return[0]));
		}
		elseif ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_DC_11, 'description'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_DC_10, 'description'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		else
		{
			return null;
		}
	}

	public function get_copyright()
	{
		if ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'rights'))
		{
			return $this->sanitize($return[0]['data'], SimplePie_Misc::atom_10_construct_type($return[0]['attribs']), $this->get_base($return[0]));
		}
		elseif ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_ATOM_03, 'copyright'))
		{
			return $this->sanitize($return[0]['data'], SimplePie_Misc::atom_03_construct_type($return[0]['attribs']), $this->get_base($return[0]));
		}
		elseif ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'copyright'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_DC_11, 'rights'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_DC_10, 'rights'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		else
		{
			return null;
		}
	}

	public function get_language()
	{
		if ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'language'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_DC_11, 'language'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_DC_10, 'language'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		elseif (isset($this->data['xml_lang']))
		{
			return $this->sanitize($this->data['xml_lang'], SIMPLEPIE_CONSTRUCT_TEXT);
		}
		else
		{
			return null;
		}
	}

	public function get_image_url()
	{
		if ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'logo'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($return[0]));
		}
		elseif ($return = $this->get_source_tags(SIMPLEPIE_NAMESPACE_ATOM_10, 'icon'))
		{
			return $this->sanitize($return[0]['data'], SIMPLEPIE_CONSTRUCT_IRI, $this->get_base($return[0]));
		}
		else
		{
			return null;
		}
	}
}

class SimplePie_Author
{
	var $name;
	var $link;
	var $email;

	// Constructor, used to input the data
	public function __construct($name = null, $link = null, $email = null)
	{
		$this->name = $name;
		$this->link = $link;
		$this->email = $email;
	}

	public function __toString()
	{
		// There is no $this->data here
		return md5(serialize($this));
	}

	public function get_name()
	{
		if ($this->name !== null)
		{
			return $this->name;
		}
		else
		{
			return null;
		}
	}

	public function get_link()
	{
		if ($this->link !== null)
		{
			return $this->link;
		}
		else
		{
			return null;
		}
	}

	public function get_email()
	{
		if ($this->email !== null)
		{
			return $this->email;
		}
		else
		{
			return null;
		}
	}
}

class SimplePie_Category
{
	var $term;
	var $scheme;
	var $label;

	// Constructor, used to input the data
	public function __construct($term = null, $scheme = null, $label = null)
	{
		$this->term = $term;
		$this->scheme = $scheme;
		$this->label = $label;
	}

	public function __toString()
	{
		// There is no $this->data here
		return md5(serialize($this));
	}

	public function get_term()
	{
		if ($this->term !== null)
		{
			return $this->term;
		}
		else
		{
			return null;
		}
	}

	public function get_scheme()
	{
		if ($this->scheme !== null)
		{
			return $this->scheme;
		}
		else
		{
			return null;
		}
	}

	public function get_label()
	{
		if ($this->label !== null)
		{
			return $this->label;
		}
		else
		{
			return $this->get_term();
		}
	}
}

class SimplePie_Enclosure
{
	var $length;
	var $link;
	var $type;

	// Constructor, used to input the data
	public function __construct($link = null, $type = null, $length = null)
	{
		$this->length = $length;
		$this->link = $link;
		$this->type = $type;

		if (class_exists('idna_convert'))
		{
			$idn = new idna_convert();
			$parsed = SimplePie_Misc::parse_url($link);
			$this->link = SimplePie_Misc::compress_parse_url($parsed['scheme'], $idn->encode($parsed['authority']), $parsed['path'], $parsed['query'], $parsed['fragment']);
		}
	}

	public function __toString()
	{
		// There is no $this->data here
		return md5(serialize($this));
	}

	public function get_length()
	{
		if ($this->length !== null)
		{
			return $this->length;
		}
		else
		{
			return null;
		}
	}

	public function get_link()
	{
		if ($this->link !== null)
		{
			return urldecode($this->link);
		}
		else
		{
			return null;
		}
	}

	public function get_type()
	{
		if ($this->type !== null)
		{
			return $this->type;
		}
		else
		{
			return null;
		}
	}
}

class SimplePie_Misc
{
	public static function absolutize_url($relative, $base)
	{
		$iri = SimplePie_IRI::absolutize(new SimplePie_IRI($base), $relative);
		return $iri->get_iri();
	}

	public static function remove_dot_segments($input)
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

	public static function parse_url($url)
	{
		$iri = new SimplePie_IRI($url);
		return array(
			'scheme' => (string) $iri->get_scheme(),
			'authority' => (string) $iri->get_authority(),
			'path' => (string) $iri->get_path(),
			'query' => (string) $iri->get_query(),
			'fragment' => (string) $iri->get_fragment()
		);
	}

	public static function compress_parse_url($scheme = '', $authority = '', $path = '', $query = '', $fragment = '')
	{
		$iri = new SimplePie_IRI('');
		$iri->set_scheme($scheme);
		$iri->set_authority($authority);
		$iri->set_path($path);
		$iri->set_query($query);
		$iri->set_fragment($fragment);
		return $iri->get_iri();
	}

	public static function normalize_url($url)
	{
		$iri = new SimplePie_IRI($url);
		return $iri->get_iri();
	}

	public static function percent_encoding_normalization($match)
	{
		$integer = hexdec($match[1]);
		if ($integer >= 0x41 && $integer <= 0x5A || $integer >= 0x61 && $integer <= 0x7A || $integer >= 0x30 && $integer <= 0x39 || $integer === 0x2D || $integer === 0x2E || $integer === 0x5F || $integer === 0x7E)
		{
			return chr($integer);
		}
		else
		{
			return strtoupper($match[0]);
		}
	}

	public static function get_curl_version()
	{
		if (is_array($curl = curl_version()))
		{
			$curl = $curl['version'];
		}
		elseif (substr($curl, 0, 5) === 'curl/')
		{
			$curl = substr($curl, 5, strcspn($curl, "\x09\x0A\x0B\x0C\x0D", 5));
		}
		elseif (substr($curl, 0, 8) === 'libcurl/')
		{
			$curl = substr($curl, 8, strcspn($curl, "\x09\x0A\x0B\x0C\x0D", 8));
		}
		else
		{
			$curl = 0;
		}
		return $curl;
	}

	public static function is_subclass_of($class1, $class2)
	{
		if (func_num_args() !== 2)
		{
			trigger_error('Wrong parameter count for SimplePie_Misc::is_subclass_of()', E_USER_WARNING);
		}
		elseif (version_compare(PHP_VERSION, '5.0.3', '>=') || is_object($class1))
		{
			return is_subclass_of($class1, $class2);
		}
		elseif (is_string($class1) && is_string($class2))
		{
			if (class_exists($class1))
			{
				if (class_exists($class2))
				{
					$class2 = strtolower($class2);
					while ($class1 = strtolower(get_parent_class($class1)))
					{
						if ($class1 === $class2)
						{
							return true;
						}
					}
				}
			}
			else
			{
				trigger_error('Unknown class passed as parameter', E_USER_WARNNG);
			}
		}
		return false;
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

	/**
	 * Remove RFC822 comments
	 *
	 * @param string $data Data to strip comments from
	 * @return string Comment stripped string
	 */
	public static function uncomment_rfc822($string)
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

	public static function parse_mime($mime)
	{
		if (($pos = strpos($mime, ';')) === false)
		{
			return trim($mime);
		}
		else
		{
			return trim(substr($mime, 0, $pos));
		}
	}

	public static function htmlspecialchars_decode($string, $quote_style)
	{
		if (function_exists('htmlspecialchars_decode'))
		{
			return htmlspecialchars_decode($string, $quote_style);
		}
		else
		{
			return strtr($string, array_flip(get_html_translation_table(HTML_SPECIALCHARS, $quote_style)));
		}
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

	public static function space_seperated_tokens($string)
	{
		$space_characters = "\x20\x09\x0A\x0B\x0C\x0D";
		$string_length = strlen($string);

		$position = strspn($string, $space_characters);
		$tokens = array();

		while ($position < $string_length)
		{
			$len = strcspn($string, $space_characters, $position);
			$tokens[] = substr($string, $position, $len);
			$position += $len;
			$position += strspn($string, $space_characters, $position);
		}

		return $tokens;
	}

	public static function array_unique($array)
	{
		if (version_compare(PHP_VERSION, '5.2', '>='))
		{
			return array_unique($array);
		}
		else
		{
			$array = (array) $array;
			$new_array = array();
			$new_array_strings = array();
			foreach ($array as $key => $value)
			{
				if (is_object($value))
				{
					if (method_exists($value, '__toString'))
					{
						$cmp = $value->__toString();
					}
					else
					{
						trigger_error('Object of class ' . get_class($value) . ' could not be converted to string', E_USER_ERROR);
					}
				}
				elseif (is_array($value))
				{
					$cmp = (string) reset($value);
				}
				else
				{
					$cmp = (string) $value;
				}
				if (!in_array($cmp, $new_array_strings))
				{
					$new_array[$key] = $value;
					$new_array_strings[] = $cmp;
				}
			}
			return $new_array;
		}
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

	/**
	 * Re-implementation of PHP 5's stripos()
	 *
	 * Returns the numeric position of the first occurrence of needle in the
	 * haystack string.
	 *
	 * @param object $haystack
	 * @param string $needle Note that the needle may be a string of one or more
	 *		characters. If needle is not a string, it is converted to an integer
	 *		and applied as the ordinal value of a character.
	 * @param int $offset The optional offset parameter allows you to specify which
	 *		character in haystack to start searching. The position returned is still
	 *		relative to the beginning of haystack.
	 * @return bool If needle is not found, stripos() will return boolean false.
	 */
	public static function stripos($haystack, $needle, $offset = 0)
	{
		if (function_exists('stripos'))
		{
			return stripos($haystack, $needle, $offset);
		}
		else
		{
			if (is_string($needle))
			{
				$needle = strtolower($needle);
			}
			elseif (is_int($needle) || is_bool($needle) || is_double($needle))
			{
				$needle = strtolower(chr($needle));
			}
			else
			{
				trigger_error('needle is not a string or an integer', E_USER_WARNING);
				return false;
			}

			return strpos(strtolower($haystack), $needle, $offset);
		}
	}

	/**
	 * Similar to parse_str()
	 *
	 * Returns an associative array of name/value pairs, where the value is an
	 * array of values that have used the same name
	 *
	 * @access string
	 * @param string $str The input string.
	 * @return array
	 */
	public static function parse_str($str)
	{
		$return = array();
		$str = explode('&', $str);

		foreach ($str as $section)
		{
			if (strpos($section, '=') !== false)
			{
				list($name, $value) = explode('=', $section, 2);
				$return[urldecode($name)][] = urldecode($value);
			}
			else
			{
				$return[urldecode($section)][] = null;
			}
		}

		return $return;
	}
}

/**
 * Decode HTML Entities
 *
 * This implements HTML5 as of revision 967 (2007-06-28)
 *
 * @package SimplePie
 */
class SimplePie_Decode_HTML_Entities
{
	/**
	 * Data to be parsed
	 *
	 * @access private
	 * @var string
	 */
	var $data = '';

	/**
	 * Currently consumed bytes
	 *
	 * @access private
	 * @var string
	 */
	var $consumed = '';

	/**
	 * Position of the current byte being parsed
	 *
	 * @access private
	 * @var int
	 */
	var $position = 0;

	/**
	 * Create an instance of the class with the input data
	 *
	 * @access public
	 * @param string $data Input data
	 */
	public function __construct($data)
	{
		$this->data = $data;
	}

	/**
	 * Parse the input data
	 *
	 * @access public
	 * @return string Output data
	 */
	public function parse()
	{
		while (($this->position = strpos($this->data, '&', $this->position)) !== false)
		{
			$this->consume();
			$this->entity();
			$this->consumed = '';
		}
		return $this->data;
	}

	/**
	 * Consume the next byte
	 *
	 * @access private
	 * @return mixed The next byte, or false, if there is no more data
	 */
	public function consume()
	{
		if (isset($this->data[$this->position]))
		{
			$this->consumed .= $this->data[$this->position];
			return $this->data[$this->position++];
		}
		else
		{
			return false;
		}
	}

	/**
	 * Consume a range of characters
	 *
	 * @access private
	 * @param string $chars Characters to consume
	 * @return mixed A series of characters that match the range, or false
	 */
	public function consume_range($chars)
	{
		if ($len = strspn($this->data, $chars, $this->position))
		{
			$data = substr($this->data, $this->position, $len);
			$this->consumed .= $data;
			$this->position += $len;
			return $data;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Unconsume one byte
	 *
	 * @access private
	 */
	public function unconsume()
	{
		$this->consumed = substr($this->consumed, 0, -1);
		$this->position--;
	}

	/**
	 * Decode an entity
	 *
	 * @access private
	 */
	public function entity()
	{
		switch ($this->consume())
		{
			case "\x09":
			case "\x0A":
			case "\x0B":
			case "\x0B":
			case "\x0C":
			case "\x20":
			case "\x3C":
			case "\x26":
			case false:
				break;

			case "\x23":
				switch ($this->consume())
				{
					case "\x78":
					case "\x58":
						$range = '0123456789ABCDEFabcdef';
						$hex = true;
						break;

					default:
						$range = '0123456789';
						$hex = false;
						$this->unconsume();
						break;
				}

				if ($codepoint = $this->consume_range($range))
				{
					static $windows_1252_specials = array(0x0D => "\x0A", 0x80 => "\xE2\x82\xAC", 0x81 => "\xEF\xBF\xBD", 0x82 => "\xE2\x80\x9A", 0x83 => "\xC6\x92", 0x84 => "\xE2\x80\x9E", 0x85 => "\xE2\x80\xA6", 0x86 => "\xE2\x80\xA0", 0x87 => "\xE2\x80\xA1", 0x88 => "\xCB\x86", 0x89 => "\xE2\x80\xB0", 0x8A => "\xC5\xA0", 0x8B => "\xE2\x80\xB9", 0x8C => "\xC5\x92", 0x8D => "\xEF\xBF\xBD", 0x8E => "\xC5\xBD", 0x8F => "\xEF\xBF\xBD", 0x90 => "\xEF\xBF\xBD", 0x91 => "\xE2\x80\x98", 0x92 => "\xE2\x80\x99", 0x93 => "\xE2\x80\x9C", 0x94 => "\xE2\x80\x9D", 0x95 => "\xE2\x80\xA2", 0x96 => "\xE2\x80\x93", 0x97 => "\xE2\x80\x94", 0x98 => "\xCB\x9C", 0x99 => "\xE2\x84\xA2", 0x9A => "\xC5\xA1", 0x9B => "\xE2\x80\xBA", 0x9C => "\xC5\x93", 0x9D => "\xEF\xBF\xBD", 0x9E => "\xC5\xBE", 0x9F => "\xC5\xB8");

					if ($hex)
					{
						$codepoint = hexdec($codepoint);
					}
					else
					{
						$codepoint = intval($codepoint);
					}

					if (isset($windows_1252_specials[$codepoint]))
					{
						$replacement = $windows_1252_specials[$codepoint];
					}
					else
					{
						$replacement = SimplePie_Misc::codepoint_to_utf8($codepoint);
					}

					if (!in_array($this->consume(), array(';', false), true))
					{
						$this->unconsume();
					}

					$consumed_length = strlen($this->consumed);
					$this->data = substr_replace($this->data, $replacement, $this->position - $consumed_length, $consumed_length);
					$this->position += strlen($replacement) - $consumed_length;
				}
				break;

			default:
				static $entities = array('Aacute' => "\xC3\x81", 'aacute' => "\xC3\xA1", 'Aacute;' => "\xC3\x81", 'aacute;' => "\xC3\xA1", 'Acirc' => "\xC3\x82", 'acirc' => "\xC3\xA2", 'Acirc;' => "\xC3\x82", 'acirc;' => "\xC3\xA2", 'acute' => "\xC2\xB4", 'acute;' => "\xC2\xB4", 'AElig' => "\xC3\x86", 'aelig' => "\xC3\xA6", 'AElig;' => "\xC3\x86", 'aelig;' => "\xC3\xA6", 'Agrave' => "\xC3\x80", 'agrave' => "\xC3\xA0", 'Agrave;' => "\xC3\x80", 'agrave;' => "\xC3\xA0", 'alefsym;' => "\xE2\x84\xB5", 'Alpha;' => "\xCE\x91", 'alpha;' => "\xCE\xB1", 'AMP' => "\x26", 'amp' => "\x26", 'AMP;' => "\x26", 'amp;' => "\x26", 'and;' => "\xE2\x88\xA7", 'ang;' => "\xE2\x88\xA0", 'apos;' => "\x27", 'Aring' => "\xC3\x85", 'aring' => "\xC3\xA5", 'Aring;' => "\xC3\x85", 'aring;' => "\xC3\xA5", 'asymp;' => "\xE2\x89\x88", 'Atilde' => "\xC3\x83", 'atilde' => "\xC3\xA3", 'Atilde;' => "\xC3\x83", 'atilde;' => "\xC3\xA3", 'Auml' => "\xC3\x84", 'auml' => "\xC3\xA4", 'Auml;' => "\xC3\x84", 'auml;' => "\xC3\xA4", 'bdquo;' => "\xE2\x80\x9E", 'Beta;' => "\xCE\x92", 'beta;' => "\xCE\xB2", 'brvbar' => "\xC2\xA6", 'brvbar;' => "\xC2\xA6", 'bull;' => "\xE2\x80\xA2", 'cap;' => "\xE2\x88\xA9", 'Ccedil' => "\xC3\x87", 'ccedil' => "\xC3\xA7", 'Ccedil;' => "\xC3\x87", 'ccedil;' => "\xC3\xA7", 'cedil' => "\xC2\xB8", 'cedil;' => "\xC2\xB8", 'cent' => "\xC2\xA2", 'cent;' => "\xC2\xA2", 'Chi;' => "\xCE\xA7", 'chi;' => "\xCF\x87", 'circ;' => "\xCB\x86", 'clubs;' => "\xE2\x99\xA3", 'cong;' => "\xE2\x89\x85", 'COPY' => "\xC2\xA9", 'copy' => "\xC2\xA9", 'COPY;' => "\xC2\xA9", 'copy;' => "\xC2\xA9", 'crarr;' => "\xE2\x86\xB5", 'cup;' => "\xE2\x88\xAA", 'curren' => "\xC2\xA4", 'curren;' => "\xC2\xA4", 'Dagger;' => "\xE2\x80\xA1", 'dagger;' => "\xE2\x80\xA0", 'dArr;' => "\xE2\x87\x93", 'darr;' => "\xE2\x86\x93", 'deg' => "\xC2\xB0", 'deg;' => "\xC2\xB0", 'Delta;' => "\xCE\x94", 'delta;' => "\xCE\xB4", 'diams;' => "\xE2\x99\xA6", 'divide' => "\xC3\xB7", 'divide;' => "\xC3\xB7", 'Eacute' => "\xC3\x89", 'eacute' => "\xC3\xA9", 'Eacute;' => "\xC3\x89", 'eacute;' => "\xC3\xA9", 'Ecirc' => "\xC3\x8A", 'ecirc' => "\xC3\xAA", 'Ecirc;' => "\xC3\x8A", 'ecirc;' => "\xC3\xAA", 'Egrave' => "\xC3\x88", 'egrave' => "\xC3\xA8", 'Egrave;' => "\xC3\x88", 'egrave;' => "\xC3\xA8", 'empty;' => "\xE2\x88\x85", 'emsp;' => "\xE2\x80\x83", 'ensp;' => "\xE2\x80\x82", 'Epsilon;' => "\xCE\x95", 'epsilon;' => "\xCE\xB5", 'equiv;' => "\xE2\x89\xA1", 'Eta;' => "\xCE\x97", 'eta;' => "\xCE\xB7", 'ETH' => "\xC3\x90", 'eth' => "\xC3\xB0", 'ETH;' => "\xC3\x90", 'eth;' => "\xC3\xB0", 'Euml' => "\xC3\x8B", 'euml' => "\xC3\xAB", 'Euml;' => "\xC3\x8B", 'euml;' => "\xC3\xAB", 'euro;' => "\xE2\x82\xAC", 'exist;' => "\xE2\x88\x83", 'fnof;' => "\xC6\x92", 'forall;' => "\xE2\x88\x80", 'frac12' => "\xC2\xBD", 'frac12;' => "\xC2\xBD", 'frac14' => "\xC2\xBC", 'frac14;' => "\xC2\xBC", 'frac34' => "\xC2\xBE", 'frac34;' => "\xC2\xBE", 'frasl;' => "\xE2\x81\x84", 'Gamma;' => "\xCE\x93", 'gamma;' => "\xCE\xB3", 'ge;' => "\xE2\x89\xA5", 'GT' => "\x3E", 'gt' => "\x3E", 'GT;' => "\x3E", 'gt;' => "\x3E", 'hArr;' => "\xE2\x87\x94", 'harr;' => "\xE2\x86\x94", 'hearts;' => "\xE2\x99\xA5", 'hellip;' => "\xE2\x80\xA6", 'Iacute' => "\xC3\x8D", 'iacute' => "\xC3\xAD", 'Iacute;' => "\xC3\x8D", 'iacute;' => "\xC3\xAD", 'Icirc' => "\xC3\x8E", 'icirc' => "\xC3\xAE", 'Icirc;' => "\xC3\x8E", 'icirc;' => "\xC3\xAE", 'iexcl' => "\xC2\xA1", 'iexcl;' => "\xC2\xA1", 'Igrave' => "\xC3\x8C", 'igrave' => "\xC3\xAC", 'Igrave;' => "\xC3\x8C", 'igrave;' => "\xC3\xAC", 'image;' => "\xE2\x84\x91", 'infin;' => "\xE2\x88\x9E", 'int;' => "\xE2\x88\xAB", 'Iota;' => "\xCE\x99", 'iota;' => "\xCE\xB9", 'iquest' => "\xC2\xBF", 'iquest;' => "\xC2\xBF", 'isin;' => "\xE2\x88\x88", 'Iuml' => "\xC3\x8F", 'iuml' => "\xC3\xAF", 'Iuml;' => "\xC3\x8F", 'iuml;' => "\xC3\xAF", 'Kappa;' => "\xCE\x9A", 'kappa;' => "\xCE\xBA", 'Lambda;' => "\xCE\x9B", 'lambda;' => "\xCE\xBB", 'lang;' => "\xE3\x80\x88", 'laquo' => "\xC2\xAB", 'laquo;' => "\xC2\xAB", 'lArr;' => "\xE2\x87\x90", 'larr;' => "\xE2\x86\x90", 'lceil;' => "\xE2\x8C\x88", 'ldquo;' => "\xE2\x80\x9C", 'le;' => "\xE2\x89\xA4", 'lfloor;' => "\xE2\x8C\x8A", 'lowast;' => "\xE2\x88\x97", 'loz;' => "\xE2\x97\x8A", 'lrm;' => "\xE2\x80\x8E", 'lsaquo;' => "\xE2\x80\xB9", 'lsquo;' => "\xE2\x80\x98", 'LT' => "\x3C", 'lt' => "\x3C", 'LT;' => "\x3C", 'lt;' => "\x3C", 'macr' => "\xC2\xAF", 'macr;' => "\xC2\xAF", 'mdash;' => "\xE2\x80\x94", 'micro' => "\xC2\xB5", 'micro;' => "\xC2\xB5", 'middot' => "\xC2\xB7", 'middot;' => "\xC2\xB7", 'minus;' => "\xE2\x88\x92", 'Mu;' => "\xCE\x9C", 'mu;' => "\xCE\xBC", 'nabla;' => "\xE2\x88\x87", 'nbsp' => "\xC2\xA0", 'nbsp;' => "\xC2\xA0", 'ndash;' => "\xE2\x80\x93", 'ne;' => "\xE2\x89\xA0", 'ni;' => "\xE2\x88\x8B", 'not' => "\xC2\xAC", 'not;' => "\xC2\xAC", 'notin;' => "\xE2\x88\x89", 'nsub;' => "\xE2\x8A\x84", 'Ntilde' => "\xC3\x91", 'ntilde' => "\xC3\xB1", 'Ntilde;' => "\xC3\x91", 'ntilde;' => "\xC3\xB1", 'Nu;' => "\xCE\x9D", 'nu;' => "\xCE\xBD", 'Oacute' => "\xC3\x93", 'oacute' => "\xC3\xB3", 'Oacute;' => "\xC3\x93", 'oacute;' => "\xC3\xB3", 'Ocirc' => "\xC3\x94", 'ocirc' => "\xC3\xB4", 'Ocirc;' => "\xC3\x94", 'ocirc;' => "\xC3\xB4", 'OElig;' => "\xC5\x92", 'oelig;' => "\xC5\x93", 'Ograve' => "\xC3\x92", 'ograve' => "\xC3\xB2", 'Ograve;' => "\xC3\x92", 'ograve;' => "\xC3\xB2", 'oline;' => "\xE2\x80\xBE", 'Omega;' => "\xCE\xA9", 'omega;' => "\xCF\x89", 'Omicron;' => "\xCE\x9F", 'omicron;' => "\xCE\xBF", 'oplus;' => "\xE2\x8A\x95", 'or;' => "\xE2\x88\xA8", 'ordf' => "\xC2\xAA", 'ordf;' => "\xC2\xAA", 'ordm' => "\xC2\xBA", 'ordm;' => "\xC2\xBA", 'Oslash' => "\xC3\x98", 'oslash' => "\xC3\xB8", 'Oslash;' => "\xC3\x98", 'oslash;' => "\xC3\xB8", 'Otilde' => "\xC3\x95", 'otilde' => "\xC3\xB5", 'Otilde;' => "\xC3\x95", 'otilde;' => "\xC3\xB5", 'otimes;' => "\xE2\x8A\x97", 'Ouml' => "\xC3\x96", 'ouml' => "\xC3\xB6", 'Ouml;' => "\xC3\x96", 'ouml;' => "\xC3\xB6", 'para' => "\xC2\xB6", 'para;' => "\xC2\xB6", 'part;' => "\xE2\x88\x82", 'permil;' => "\xE2\x80\xB0", 'perp;' => "\xE2\x8A\xA5", 'Phi;' => "\xCE\xA6", 'phi;' => "\xCF\x86", 'Pi;' => "\xCE\xA0", 'pi;' => "\xCF\x80", 'piv;' => "\xCF\x96", 'plusmn' => "\xC2\xB1", 'plusmn;' => "\xC2\xB1", 'pound' => "\xC2\xA3", 'pound;' => "\xC2\xA3", 'Prime;' => "\xE2\x80\xB3", 'prime;' => "\xE2\x80\xB2", 'prod;' => "\xE2\x88\x8F", 'prop;' => "\xE2\x88\x9D", 'Psi;' => "\xCE\xA8", 'psi;' => "\xCF\x88", 'QUOT' => "\x22", 'quot' => "\x22", 'QUOT;' => "\x22", 'quot;' => "\x22", 'radic;' => "\xE2\x88\x9A", 'rang;' => "\xE3\x80\x89", 'raquo' => "\xC2\xBB", 'raquo;' => "\xC2\xBB", 'rArr;' => "\xE2\x87\x92", 'rarr;' => "\xE2\x86\x92", 'rceil;' => "\xE2\x8C\x89", 'rdquo;' => "\xE2\x80\x9D", 'real;' => "\xE2\x84\x9C", 'REG' => "\xC2\xAE", 'reg' => "\xC2\xAE", 'REG;' => "\xC2\xAE", 'reg;' => "\xC2\xAE", 'rfloor;' => "\xE2\x8C\x8B", 'Rho;' => "\xCE\xA1", 'rho;' => "\xCF\x81", 'rlm;' => "\xE2\x80\x8F", 'rsaquo;' => "\xE2\x80\xBA", 'rsquo;' => "\xE2\x80\x99", 'sbquo;' => "\xE2\x80\x9A", 'Scaron;' => "\xC5\xA0", 'scaron;' => "\xC5\xA1", 'sdot;' => "\xE2\x8B\x85", 'sect' => "\xC2\xA7", 'sect;' => "\xC2\xA7", 'shy' => "\xC2\xAD", 'shy;' => "\xC2\xAD", 'Sigma;' => "\xCE\xA3", 'sigma;' => "\xCF\x83", 'sigmaf;' => "\xCF\x82", 'sim;' => "\xE2\x88\xBC", 'spades;' => "\xE2\x99\xA0", 'sub;' => "\xE2\x8A\x82", 'sube;' => "\xE2\x8A\x86", 'sum;' => "\xE2\x88\x91", 'sup;' => "\xE2\x8A\x83", 'sup1' => "\xC2\xB9", 'sup1;' => "\xC2\xB9", 'sup2' => "\xC2\xB2", 'sup2;' => "\xC2\xB2", 'sup3' => "\xC2\xB3", 'sup3;' => "\xC2\xB3", 'supe;' => "\xE2\x8A\x87", 'szlig' => "\xC3\x9F", 'szlig;' => "\xC3\x9F", 'Tau;' => "\xCE\xA4", 'tau;' => "\xCF\x84", 'there4;' => "\xE2\x88\xB4", 'Theta;' => "\xCE\x98", 'theta;' => "\xCE\xB8", 'thetasym;' => "\xCF\x91", 'thinsp;' => "\xE2\x80\x89", 'THORN' => "\xC3\x9E", 'thorn' => "\xC3\xBE", 'THORN;' => "\xC3\x9E", 'thorn;' => "\xC3\xBE", 'tilde;' => "\xCB\x9C", 'times' => "\xC3\x97", 'times;' => "\xC3\x97", 'TRADE;' => "\xE2\x84\xA2", 'trade;' => "\xE2\x84\xA2", 'Uacute' => "\xC3\x9A", 'uacute' => "\xC3\xBA", 'Uacute;' => "\xC3\x9A", 'uacute;' => "\xC3\xBA", 'uArr;' => "\xE2\x87\x91", 'uarr;' => "\xE2\x86\x91", 'Ucirc' => "\xC3\x9B", 'ucirc' => "\xC3\xBB", 'Ucirc;' => "\xC3\x9B", 'ucirc;' => "\xC3\xBB", 'Ugrave' => "\xC3\x99", 'ugrave' => "\xC3\xB9", 'Ugrave;' => "\xC3\x99", 'ugrave;' => "\xC3\xB9", 'uml' => "\xC2\xA8", 'uml;' => "\xC2\xA8", 'upsih;' => "\xCF\x92", 'Upsilon;' => "\xCE\xA5", 'upsilon;' => "\xCF\x85", 'Uuml' => "\xC3\x9C", 'uuml' => "\xC3\xBC", 'Uuml;' => "\xC3\x9C", 'uuml;' => "\xC3\xBC", 'weierp;' => "\xE2\x84\x98", 'Xi;' => "\xCE\x9E", 'xi;' => "\xCE\xBE", 'Yacute' => "\xC3\x9D", 'yacute' => "\xC3\xBD", 'Yacute;' => "\xC3\x9D", 'yacute;' => "\xC3\xBD", 'yen' => "\xC2\xA5", 'yen;' => "\xC2\xA5", 'yuml' => "\xC3\xBF", 'Yuml;' => "\xC5\xB8", 'yuml;' => "\xC3\xBF", 'Zeta;' => "\xCE\x96", 'zeta;' => "\xCE\xB6", 'zwj;' => "\xE2\x80\x8D", 'zwnj;' => "\xE2\x80\x8C");

				for ($i = 0, $match = null; $i < 9 && $this->consume() !== false; $i++)
				{
					$consumed = substr($this->consumed, 1);
					if (isset($entities[$consumed]))
					{
						$match = $consumed;
					}
				}

				if ($match !== null)
				{
 					$this->data = substr_replace($this->data, $entities[$match], $this->position - strlen($consumed) - 1, strlen($match) + 1);
					$this->position += strlen($entities[$match]) - strlen($consumed) - 1;
				}
				break;
		}
	}
}

/**
 * IRI parser/serialiser
 *
 * @package SimplePie
 */
class SimplePie_IRI
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
	 * @return SimplePie_IRI
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
	 * @param SimplePie_IRI $base Base IRI
	 * @param string $relative Relative IRI
	 * @return SimplePie_IRI
	 */
	public static function absolutize($base, $relative)
	{
		$relative = (string) $relative;
		if ($relative !== '')
		{
			$relative = new SimplePie_IRI($relative);
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
					$target = new SimplePie_IRI('');
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
	public function replace_invalid_with_pct_encoding($string, $valid_chars, $case = SIMPLEPIE_SAME_CASE)
	{
		// Normalise case
		if ($case & SIMPLEPIE_LOWERCASE)
		{
			$string = strtolower($string);
		}
		elseif ($case & SIMPLEPIE_UPPERCASE)
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
						if ($case & SIMPLEPIE_LOWERCASE)
						{
							$chr = strtolower($chr);
						}
						elseif ($case & SIMPLEPIE_UPPERCASE)
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
			$this->host = $this->replace_invalid_with_pct_encoding($host, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-._~!$&\'()*+,;=', SIMPLEPIE_LOWERCASE);
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
class SimplePie_Net_IPv6
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
		$uip = SimplePie_Net_IPv6::removeNetmaskSpec($ip);
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
		$ip = SimplePie_Net_IPv6::Uncompress($ip);
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
		$ipPart = SimplePie_Net_IPv6::SplitV64($ip);
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

class SimplePie_Parser
{
	var $error_code;
	var $error_string;
	var $current_line;
	var $current_column;
	var $current_byte;
	var $separator = ' ';
	var $namespace = array('');
	var $element = array('');
	var $xml_base = array('');
	var $xml_base_explicit = array(false);
	var $xml_lang = array('');
	var $data = array();
	var $datas = array(array());
	var $current_xhtml_construct = -1;

	public function parse(&$data)
	{
		$return = true;

		static $xml_is_sane = null;
		if ($xml_is_sane === null)
		{
			$parser_check = xml_parser_create();
			xml_parse_into_struct($parser_check, '<foo>&amp;</foo>', $values);
			xml_parser_free($parser_check);
			$xml_is_sane = isset($values[0]['value']);
		}

		// Create the parser
		if ($xml_is_sane)
		{
			$xml = xml_parser_create_ns('UTF-8', $this->separator);
			xml_parser_set_option($xml, XML_OPTION_SKIP_WHITE, 1);
			xml_parser_set_option($xml, XML_OPTION_CASE_FOLDING, 0);
			xml_set_object($xml, $this);
			xml_set_character_data_handler($xml, 'cdata');
			xml_set_element_handler($xml, 'tag_open', 'tag_close');

			// Parse!
			if (!xml_parse($xml, $data, true))
			{
				$this->error_code = xml_get_error_code($xml);
				$this->error_string = xml_error_string($this->error_code);
				$return = false;
			}
			$this->current_line = xml_get_current_line_number($xml);
			$this->current_column = xml_get_current_column_number($xml);
			$this->current_byte = xml_get_current_byte_index($xml);
			xml_parser_free($xml);
			return $return;
		}
		else
		{
			libxml_clear_errors();
			$xml = new XMLReader();
			$xml->xml($data);
			while (@$xml->read())
			{
				switch ($xml->nodeType)
				{

					case constant('XMLReader::END_ELEMENT'):
						if ($xml->namespaceURI !== '')
						{
							$tagName = "{$xml->namespaceURI}{$this->separator}{$xml->localName}";
						}
						else
						{
							$tagName = $xml->localName;
						}
						$this->tag_close(null, $tagName);
						break;
					case constant('XMLReader::ELEMENT'):
						$empty = $xml->isEmptyElement;
						if ($xml->namespaceURI !== '')
						{
							$tagName = "{$xml->namespaceURI}{$this->separator}{$xml->localName}";
						}
						else
						{
							$tagName = $xml->localName;
						}
						$attributes = array();
						while ($xml->moveToNextAttribute())
						{
							if ($xml->namespaceURI !== '')
							{
								$attrName = "{$xml->namespaceURI}{$this->separator}{$xml->localName}";
							}
							else
							{
								$attrName = $xml->localName;
							}
							$attributes[$attrName] = $xml->value;
						}
						$this->tag_open(null, $tagName, $attributes);
						if ($empty)
						{
							$this->tag_close(null, $tagName);
						}
						break;
					case constant('XMLReader::TEXT'):

					case constant('XMLReader::CDATA'):
						$this->cdata(null, $xml->value);
						break;
				}
			}
			if ($error = libxml_get_last_error())
			{
				$this->error_code = $error->code;
				$this->error_string = $error->message;
				$this->current_line = $error->line;
				$this->current_column = $error->column;
				return false;
			}
			else
			{
				return true;
			}
		}
	}

	public function get_error_code()
	{
		return $this->error_code;
	}

	public function get_error_string()
	{
		return $this->error_string;
	}

	public function get_current_line()
	{
		return $this->current_line;
	}

	public function get_current_column()
	{
		return $this->current_column;
	}

	public function get_current_byte()
	{
		return $this->current_byte;
	}

	public function get_data()
	{
		return $this->data;
	}

	public function tag_open($parser, $tag, $attributes)
	{
		list($this->namespace[], $this->element[]) = $this->split_ns($tag);

		$attribs = array();
		foreach ($attributes as $name => $value)
		{
			list($attrib_namespace, $attribute) = $this->split_ns($name);
			$attribs[$attrib_namespace][$attribute] = $value;
		}

		if (isset($attribs[SIMPLEPIE_NAMESPACE_XML]['base']))
		{
			$this->xml_base[] = SimplePie_Misc::absolutize_url($attribs[SIMPLEPIE_NAMESPACE_XML]['base'], end($this->xml_base));
			$this->xml_base_explicit[] = true;
		}
		else
		{
			$this->xml_base[] = end($this->xml_base);
			$this->xml_base_explicit[] = end($this->xml_base_explicit);
		}

		if (isset($attribs[SIMPLEPIE_NAMESPACE_XML]['lang']))
		{
			$this->xml_lang[] = $attribs[SIMPLEPIE_NAMESPACE_XML]['lang'];
		}
		else
		{
			$this->xml_lang[] = end($this->xml_lang);
		}

		if ($this->current_xhtml_construct >= 0)
		{
			$this->current_xhtml_construct++;
			if (end($this->namespace) === SIMPLEPIE_NAMESPACE_XHTML)
			{
				$this->data['data'] .= '<' . end($this->element);
				if (isset($attribs['']))
				{
					foreach ($attribs[''] as $name => $value)
					{
						$this->data['data'] .= ' ' . $name . '="' . htmlspecialchars($value, ENT_COMPAT, 'UTF-8') . '"';
					}
				}
				$this->data['data'] .= '>';
			}
		}
		else
		{
			$this->datas[] =& $this->data;
			$this->data =& $this->data['child'][end($this->namespace)][end($this->element)][];
			$this->data = array('data' => '', 'attribs' => $attribs, 'xml_base' => end($this->xml_base), 'xml_base_explicit' => end($this->xml_base_explicit), 'xml_lang' => end($this->xml_lang));
			if ((end($this->namespace) === SIMPLEPIE_NAMESPACE_ATOM_03 && in_array(end($this->element), array('title', 'tagline', 'copyright', 'info', 'summary', 'content')) && isset($attribs['']['mode']) && $attribs['']['mode'] === 'xml')
			|| (end($this->namespace) === SIMPLEPIE_NAMESPACE_ATOM_10 && in_array(end($this->element), array('rights', 'subtitle', 'summary', 'info', 'title', 'content')) && isset($attribs['']['type']) && $attribs['']['type'] === 'xhtml'))
			{
				$this->current_xhtml_construct = 0;
			}
		}
	}

	public function cdata($parser, $cdata)
	{
		if ($this->current_xhtml_construct >= 0)
		{
			$this->data['data'] .= htmlspecialchars($cdata, ENT_QUOTES, 'UTF-8');
		}
		else
		{
			$this->data['data'] .= $cdata;
		}
	}

	public function tag_close($parser, $tag)
	{
		if ($this->current_xhtml_construct >= 0)
		{
			$this->current_xhtml_construct--;
			if (end($this->namespace) === SIMPLEPIE_NAMESPACE_XHTML && !in_array(end($this->element), array('area', 'base', 'basefont', 'br', 'col', 'frame', 'hr', 'img', 'input', 'isindex', 'link', 'meta', 'param')))
			{
				$this->data['data'] .= '</' . end($this->element) . '>';
			}
		}
		if ($this->current_xhtml_construct === -1)
		{
			$this->data =& $this->datas[count($this->datas) - 1];
			array_pop($this->datas);
		}

		array_pop($this->element);
		array_pop($this->namespace);
		array_pop($this->xml_base);
		array_pop($this->xml_base_explicit);
		array_pop($this->xml_lang);
	}

	public function split_ns($string)
	{
		static $cache = array();
		if (!isset($cache[$string]))
		{
			if ($pos = strpos($string, $this->separator))
			{
				static $separator_length;
				if (!$separator_length)
				{
					$separator_length = strlen($this->separator);
				}
				$namespace = substr($string, 0, $pos);
				$local_name = substr($string, $pos + $separator_length);
				$cache[$string] = array($namespace, $local_name);
			}
			else
			{
				$cache[$string] = array('', $string);
			}
		}
		return $cache[$string];
	}
}

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
