<?php

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

		if (!empty($authors))
		{
			return array_unique($authors);
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
			return array_unique($contributors);
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