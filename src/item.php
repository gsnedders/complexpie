<?php

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

		if (!empty($categories))
		{
			return array_unique($categories);
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
			return array_unique($contributors);
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

		if (!empty($authors))
		{
			return array_unique($authors);
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

			$this->data['enclosures'] = array_values(array_unique($this->data['enclosures']));
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