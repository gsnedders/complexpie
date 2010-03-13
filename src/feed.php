<?php
namespace ComplexPie;

class Feed extends XMLData
{
    // The actual data
    protected $dom;
    protected $data;
    protected $sanitize;
    
    // tmp stuff for this class
    protected static $elements = array();
    protected static $aliases = array();
    
    public function __construct($dom, $oldtree)
    {
        // Start data stuff
        parent::__construct();
        
        // Get this own object rolling
        $this->dom = $dom;
        $this->data = $oldtree;
        $this->sanitize = new Sanitize();
        
        // For some odd reason documentURI defaults to $cwd below.
        $cwd = getcwd();
        if (substr($cwd, -1) !== \DIRECTORY_SEPARATOR)
        {
            $cwd .= \DIRECTORY_SEPARATOR;
        }
        
        // If we don't have a documentURI and we have links, set it to be the
        // first alternate link so that baseURI magically becomes valid.
        if ($this->dom->ownerDocument->documentURI === $cwd && $links = $this->links)
        {
            $links = $this->links;
            if (isset($links['alternate']))
            {
                $link = $links['alternate'][0];
            }
            elseif (isset($links[0]))
            {
                $link = $links[0];
            }
            else
            {
                $link = '';
            }
            
            if (is_string($link))
            {
                $this->dom->ownerDocument->documentURI = html_entity_decode($link, ENT_QUOTES, 'UTF-8');
            }
            else
            {
                $this->dom->ownerDocument->documentURI = $link->get_iri()->uri;
            }
        }
    }
    
    protected function get_type()
    {
        if (!isset($this->data['type']))
        {
            $this->data['type'] = TYPE_ALL;
            if (isset($this->data['child'][NAMESPACE_ATOM_10]['feed']))
            {
                $this->data['type'] &= TYPE_ATOM_10;
            }
            elseif (isset($this->data['child'][NAMESPACE_ATOM_03]['feed']))
            {
                $this->data['type'] &= TYPE_ATOM_03;
            }
            elseif (isset($this->data['child'][NAMESPACE_RDF]['RDF']))
            {
                if (isset($this->data['child'][NAMESPACE_RDF]['RDF'][0]['child'][NAMESPACE_RSS_10]['channel'])
                || isset($this->data['child'][NAMESPACE_RDF]['RDF'][0]['child'][NAMESPACE_RSS_10]['image'])
                || isset($this->data['child'][NAMESPACE_RDF]['RDF'][0]['child'][NAMESPACE_RSS_10]['item'])
                || isset($this->data['child'][NAMESPACE_RDF]['RDF'][0]['child'][NAMESPACE_RSS_10]['textinput']))
                {
                    $this->data['type'] &= TYPE_RSS_10;
                }
                if (isset($this->data['child'][NAMESPACE_RDF]['RDF'][0]['child'][NAMESPACE_RSS_090]['channel'])
                || isset($this->data['child'][NAMESPACE_RDF]['RDF'][0]['child'][NAMESPACE_RSS_090]['image'])
                || isset($this->data['child'][NAMESPACE_RDF]['RDF'][0]['child'][NAMESPACE_RSS_090]['item'])
                || isset($this->data['child'][NAMESPACE_RDF]['RDF'][0]['child'][NAMESPACE_RSS_090]['textinput']))
                {
                    $this->data['type'] &= TYPE_RSS_090;
                }
            }
            elseif (isset($this->data['child'][NAMESPACE_RSS_20]['rss']))
            {
                $this->data['type'] &= TYPE_RSS_ALL;
                if (isset($this->data['child'][NAMESPACE_RSS_20]['rss'][0]['attribs']['']['version']))
                {
                    switch (trim($this->data['child'][NAMESPACE_RSS_20]['rss'][0]['attribs']['']['version']))
                    {
                        case '0.91':
                            $this->data['type'] &= TYPE_RSS_091;
                            if (isset($this->data['child'][NAMESPACE_RSS_20]['rss'][0]['child'][NAMESPACE_RSS_20]['skiphours']['hour'][0]['data']))
                            {
                                switch (trim($this->data['child'][NAMESPACE_RSS_20]['rss'][0]['child'][NAMESPACE_RSS_20]['skiphours']['hour'][0]['data']))
                                {
                                    case '0':
                                        $this->data['type'] &= TYPE_RSS_091_NETSCAPE;
                                        break;

                                    case '24':
                                        $this->data['type'] &= TYPE_RSS_091_USERLAND;
                                        break;
                                }
                            }
                            break;

                        case '0.92':
                            $this->data['type'] &= TYPE_RSS_092;
                            break;

                        case '0.93':
                            $this->data['type'] &= TYPE_RSS_093;
                            break;

                        case '0.94':
                            $this->data['type'] &= TYPE_RSS_094;
                            break;

                        case '2.0':
                            $this->data['type'] &= TYPE_RSS_20;
                            break;
                    }
                }
            }
            else
            {
                $this->data['type'] = TYPE_NONE;
            }
        }
        return $this->data['type'];
    }

    protected function get_feed_tags($namespace, $tag)
    {
        $type = $this->get_type();
        if ($type & TYPE_ATOM_10)
        {
            if (isset($this->data['child'][NAMESPACE_ATOM_10]['feed'][0]['child'][$namespace][$tag]))
            {
                return $this->data['child'][NAMESPACE_ATOM_10]['feed'][0]['child'][$namespace][$tag];
            }
        }
        if ($type & TYPE_ATOM_03)
        {
            if (isset($this->data['child'][NAMESPACE_ATOM_03]['feed'][0]['child'][$namespace][$tag]))
            {
                return $this->data['child'][NAMESPACE_ATOM_03]['feed'][0]['child'][$namespace][$tag];
            }
        }
        if ($type & TYPE_RSS_RDF)
        {
            if (isset($this->data['child'][NAMESPACE_RDF]['RDF'][0]['child'][$namespace][$tag]))
            {
                return $this->data['child'][NAMESPACE_RDF]['RDF'][0]['child'][$namespace][$tag];
            }
        }
        if ($type & TYPE_RSS_SYNDICATION)
        {
            if (isset($this->data['child'][NAMESPACE_RSS_20]['rss'][0]['child'][$namespace][$tag]))
            {
                return $this->data['child'][NAMESPACE_RSS_20]['rss'][0]['child'][$namespace][$tag];
            }
        }
        return null;
    }

    protected function get_channel_tags($namespace, $tag)
    {
        $type = $this->get_type();
        if ($type & TYPE_ATOM_ALL)
        {
            if ($return = $this->get_feed_tags($namespace, $tag))
            {
                return $return;
            }
        }
        if ($type & TYPE_RSS_10)
        {
            if ($channel = $this->get_feed_tags(NAMESPACE_RSS_10, 'channel'))
            {
                if (isset($channel[0]['child'][$namespace][$tag]))
                {
                    return $channel[0]['child'][$namespace][$tag];
                }
            }
        }
        if ($type & TYPE_RSS_090)
        {
            if ($channel = $this->get_feed_tags(NAMESPACE_RSS_090, 'channel'))
            {
                if (isset($channel[0]['child'][$namespace][$tag]))
                {
                    return $channel[0]['child'][$namespace][$tag];
                }
            }
        }
        if ($type & TYPE_RSS_SYNDICATION)
        {
            if ($channel = $this->get_feed_tags(NAMESPACE_RSS_20, 'channel'))
            {
                if (isset($channel[0]['child'][$namespace][$tag]))
                {
                    return $channel[0]['child'][$namespace][$tag];
                }
            }
        }
        return null;
    }

    protected function get_image_tags($namespace, $tag)
    {
        $type = $this->get_type();
        if ($type & TYPE_RSS_10)
        {
            if ($image = $this->get_feed_tags(NAMESPACE_RSS_10, 'image'))
            {
                if (isset($image[0]['child'][$namespace][$tag]))
                {
                    return $image[0]['child'][$namespace][$tag];
                }
            }
        }
        if ($type & TYPE_RSS_090)
        {
            if ($image = $this->get_feed_tags(NAMESPACE_RSS_090, 'image'))
            {
                if (isset($image[0]['child'][$namespace][$tag]))
                {
                    return $image[0]['child'][$namespace][$tag];
                }
            }
        }
        if ($type & TYPE_RSS_SYNDICATION)
        {
            if ($image = $this->get_channel_tags(NAMESPACE_RSS_20, 'image'))
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
        $links = $this->get_links();
        if (!($this->get_type() & TYPE_RSS_SYNDICATION) && !empty($element['xml_base_explicit']) && isset($element['xml_base']))
        {
            return $element['xml_base'];
        }
        elseif (isset($links['alternate']))
        {
            return $links['alternate'][0];
        }
        else
        {
            return '';
        }
    }

    public function sanitize($data, $type, $base = '')
    {
        return $this->sanitize->dosanitize($data, $type, $base);
    }

    protected function get_title()
    {
        if ($return = $this->get_channel_tags(NAMESPACE_ATOM_03, 'title'))
        {
            return $this->sanitize($return[0]['data'], Misc::atom_03_construct_type($return[0]['attribs']), $this->get_base($return[0]));
        }
        elseif ($return = $this->get_channel_tags(NAMESPACE_RSS_10, 'title'))
        {
            return $this->sanitize($return[0]['data'], CONSTRUCT_HTML, $this->get_base($return[0]));
        }
        elseif ($return = $this->get_channel_tags(NAMESPACE_RSS_090, 'title'))
        {
            return $this->sanitize($return[0]['data'], CONSTRUCT_HTML, $this->get_base($return[0]));
        }
        elseif ($return = $this->get_channel_tags(NAMESPACE_RSS_20, 'title'))
        {
            return $this->sanitize($return[0]['data'], CONSTRUCT_HTML, $this->get_base($return[0]));
        }
        else
        {
            return null;
        }
    }

    protected function get_categories()
    {
        $categories = array();

        foreach ((array) $this->get_channel_tags(NAMESPACE_RSS_20, 'category') as $category)
        {
            // This is really the label, but keep this as the term also for BC.
            // Label will also work on retrieving because that falls back to term.
            $term = $this->sanitize($category['data'], CONSTRUCT_TEXT);
            if (isset($category['attribs']['']['domain']))
            {
                $scheme = $this->sanitize($category['attribs']['']['domain'], CONSTRUCT_TEXT);
            }
            else
            {
                $scheme = null;
            }
            $categories[] = new Category($term, $scheme, null);
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

    protected function get_authors()
    {
        $authors = array();
        if ($author = $this->get_channel_tags(NAMESPACE_ATOM_03, 'author'))
        {
            $name = null;
            $url = null;
            $email = null;
            if (isset($author[0]['child'][NAMESPACE_ATOM_03]['name'][0]['data']))
            {
                $name = $this->sanitize($author[0]['child'][NAMESPACE_ATOM_03]['name'][0]['data'], CONSTRUCT_TEXT);
            }
            if (isset($author[0]['child'][NAMESPACE_ATOM_03]['url'][0]['data']))
            {
                $url = $this->sanitize($author[0]['child'][NAMESPACE_ATOM_03]['url'][0]['data'], CONSTRUCT_IRI, $this->get_base($author[0]['child'][NAMESPACE_ATOM_03]['url'][0]));
            }
            if (isset($author[0]['child'][NAMESPACE_ATOM_03]['email'][0]['data']))
            {
                $email = $this->sanitize($author[0]['child'][NAMESPACE_ATOM_03]['email'][0]['data'], CONSTRUCT_TEXT);
            }
            if ($name !== null || $email !== null || $url !== null)
            {
                $authors[] = new Author($name, $url, $email);
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

    protected function get_contributors()
    {
        $contributors = array();
        foreach ((array) $this->get_channel_tags(NAMESPACE_ATOM_03, 'contributor') as $contributor)
        {
            $name = null;
            $url = null;
            $email = null;
            if (isset($contributor['child'][NAMESPACE_ATOM_03]['name'][0]['data']))
            {
                $name = $this->sanitize($contributor['child'][NAMESPACE_ATOM_03]['name'][0]['data'], CONSTRUCT_TEXT);
            }
            if (isset($contributor['child'][NAMESPACE_ATOM_03]['url'][0]['data']))
            {
                $url = $this->sanitize($contributor['child'][NAMESPACE_ATOM_03]['url'][0]['data'], CONSTRUCT_IRI, $this->get_base($contributor['child'][NAMESPACE_ATOM_03]['url'][0]));
            }
            if (isset($contributor['child'][NAMESPACE_ATOM_03]['email'][0]['data']))
            {
                $email = $this->sanitize($contributor['child'][NAMESPACE_ATOM_03]['email'][0]['data'], CONSTRUCT_TEXT);
            }
            if ($name !== null || $email !== null || $url !== null)
            {
                $contributors[] = new Author($name, $url, $email);
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

    protected function get_links()
    {
        if (!isset($this->data['links']))
        {
            $this->data['links'] = array();
            if ($links = $this->get_channel_tags(NAMESPACE_ATOM_03, 'link'))
            {
                foreach ($links as $link)
                {
                    if (isset($link['attribs']['']['href']))
                    {
                        $link_rel = (isset($link['attribs']['']['rel'])) ? $link['attribs']['']['rel'] : 'alternate';
                        $this->data['links'][$link_rel][] = $this->sanitize($link['attribs']['']['href'], CONSTRUCT_IRI, $this->get_base($link));

                    }
                }
            }
            if ($links = $this->get_channel_tags(NAMESPACE_RSS_10, 'link'))
            {
                $this->data['links']['alternate'][] = $this->sanitize($links[0]['data'], CONSTRUCT_IRI, $this->get_base($links[0]));
            }
            if ($links = $this->get_channel_tags(NAMESPACE_RSS_090, 'link'))
            {
                $this->data['links']['alternate'][] = $this->sanitize($links[0]['data'], CONSTRUCT_IRI, $this->get_base($links[0]));
            }
            if ($links = $this->get_channel_tags(NAMESPACE_RSS_20, 'link'))
            {
                $this->data['links']['alternate'][] = $this->sanitize($links[0]['data'], CONSTRUCT_IRI, $this->get_base($links[0]));
            }

            $keys = array_keys($this->data['links']);
            foreach ($keys as $key)
            {
                if (Misc::is_isegment_nz_nc($key))
                {
                    if (isset($this->data['links'][IANA_LINK_RELATIONS_REGISTRY . $key]))
                    {
                        $this->data['links'][IANA_LINK_RELATIONS_REGISTRY . $key] = array_merge($this->data['links'][$key], $this->data['links'][IANA_LINK_RELATIONS_REGISTRY . $key]);
                        $this->data['links'][$key] =& $this->data['links'][IANA_LINK_RELATIONS_REGISTRY . $key];
                    }
                    else
                    {
                        $this->data['links'][IANA_LINK_RELATIONS_REGISTRY . $key] =& $this->data['links'][$key];
                    }
                }
                elseif (substr($key, 0, 41) === IANA_LINK_RELATIONS_REGISTRY)
                {
                    $this->data['links'][substr($key, 41)] =& $this->data['links'][$key];
                }
                $this->data['links'][$key] = array_unique($this->data['links'][$key]);
            }
        }

        if (isset($this->data['links']))
        {
            return $this->data['links'];
        }
        else
        {
            return null;
        }
    }

    protected function get_description()
    {
        if ($return = $this->get_channel_tags(NAMESPACE_ATOM_03, 'tagline'))
        {
            return $this->sanitize($return[0]['data'], Misc::atom_03_construct_type($return[0]['attribs']), $this->get_base($return[0]));
        }
        elseif ($return = $this->get_channel_tags(NAMESPACE_RSS_10, 'description'))
        {
            return $this->sanitize($return[0]['data'], CONSTRUCT_HTML, $this->get_base($return[0]));
        }
        elseif ($return = $this->get_channel_tags(NAMESPACE_RSS_090, 'description'))
        {
            return $this->sanitize($return[0]['data'], CONSTRUCT_HTML, $this->get_base($return[0]));
        }
        elseif ($return = $this->get_channel_tags(NAMESPACE_RSS_20, 'description'))
        {
            return $this->sanitize($return[0]['data'], CONSTRUCT_HTML, $this->get_base($return[0]));
        }
        else
        {
            return null;
        }
    }

    protected function get_copyright()
    {
        if ($return = $this->get_channel_tags(NAMESPACE_ATOM_03, 'copyright'))
        {
            return $this->sanitize($return[0]['data'], Misc::atom_03_construct_type($return[0]['attribs']), $this->get_base($return[0]));
        }
        elseif ($return = $this->get_channel_tags(NAMESPACE_RSS_20, 'copyright'))
        {
            return $this->sanitize($return[0]['data'], CONSTRUCT_TEXT);
        }
        else
        {
            return null;
        }
    }

    protected function get_language()
    {
        if ($return = $this->get_channel_tags(NAMESPACE_RSS_20, 'language'))
        {
            return $this->sanitize($return[0]['data'], CONSTRUCT_TEXT);
        }
        elseif (isset($this->data['headers']['content-language']))
        {
            return $this->sanitize($this->data['headers']['content-language'], CONSTRUCT_TEXT);
        }
        else
        {
            return null;
        }
    }

    protected function get_image_title()
    {
        if ($return = $this->get_image_tags(NAMESPACE_RSS_10, 'title'))
        {
            return $this->sanitize($return[0]['data'], CONSTRUCT_TEXT);
        }
        elseif ($return = $this->get_image_tags(NAMESPACE_RSS_090, 'title'))
        {
            return $this->sanitize($return[0]['data'], CONSTRUCT_TEXT);
        }
        elseif ($return = $this->get_image_tags(NAMESPACE_RSS_20, 'title'))
        {
            return $this->sanitize($return[0]['data'], CONSTRUCT_TEXT);
        }
        else
        {
            return null;
        }
    }

    protected function get_image_url()
    {
        if ($return = $this->get_channel_tags(NAMESPACE_ATOM_10, 'logo'))
        {
            return $this->sanitize($return[0]['data'], CONSTRUCT_IRI, $this->get_base($return[0]));
        }
        elseif ($return = $this->get_channel_tags(NAMESPACE_ATOM_10, 'icon'))
        {
            return $this->sanitize($return[0]['data'], CONSTRUCT_IRI, $this->get_base($return[0]));
        }
        elseif ($return = $this->get_image_tags(NAMESPACE_RSS_10, 'url'))
        {
            return $this->sanitize($return[0]['data'], CONSTRUCT_IRI, $this->get_base($return[0]));
        }
        elseif ($return = $this->get_image_tags(NAMESPACE_RSS_090, 'url'))
        {
            return $this->sanitize($return[0]['data'], CONSTRUCT_IRI, $this->get_base($return[0]));
        }
        elseif ($return = $this->get_image_tags(NAMESPACE_RSS_20, 'url'))
        {
            return $this->sanitize($return[0]['data'], CONSTRUCT_IRI, $this->get_base($return[0]));
        }
        else
        {
            return null;
        }
    }

    protected function get_image_link()
    {
        if ($return = $this->get_image_tags(NAMESPACE_RSS_10, 'link'))
        {
            return $this->sanitize($return[0]['data'], CONSTRUCT_IRI, $this->get_base($return[0]));
        }
        elseif ($return = $this->get_image_tags(NAMESPACE_RSS_090, 'link'))
        {
            return $this->sanitize($return[0]['data'], CONSTRUCT_IRI, $this->get_base($return[0]));
        }
        elseif ($return = $this->get_image_tags(NAMESPACE_RSS_20, 'link'))
        {
            return $this->sanitize($return[0]['data'], CONSTRUCT_IRI, $this->get_base($return[0]));
        }
        else
        {
            return null;
        }
    }

    protected function get_image_width()
    {
        if ($return = $this->get_image_tags(NAMESPACE_RSS_20, 'width'))
        {
            return round($return[0]['data']);
        }
        elseif ($this->get_type() & TYPE_RSS_SYNDICATION && $this->get_image_tags(NAMESPACE_RSS_20, 'url'))
        {
            return 88.0;
        }
        else
        {
            return null;
        }
    }

    protected function get_image_height()
    {
        if ($return = $this->get_image_tags(NAMESPACE_RSS_20, 'height'))
        {
            return round($return[0]['data']);
        }
        elseif ($this->get_type() & TYPE_RSS_SYNDICATION && $this->get_image_tags(NAMESPACE_RSS_20, 'url'))
        {
            return 31.0;
        }
        else
        {
            return null;
        }
    }

    protected function get_items()
    {
        if (!isset($this->data['items']))
        {
            $this->data['items'] = array();
            if ($items = $this->get_feed_tags(NAMESPACE_ATOM_10, 'entry'))
            {
                $keys = array_keys($items);
                foreach ($keys as $key)
                {
                    $this->data['items'][] = new Item($this, $items[$key]);
                }
            }
            if ($items = $this->get_feed_tags(NAMESPACE_ATOM_03, 'entry'))
            {
                $keys = array_keys($items);
                foreach ($keys as $key)
                {
                    $this->data['items'][] = new Item($this, $items[$key]);
                }
            }
            if ($items = $this->get_feed_tags(NAMESPACE_RSS_10, 'item'))
            {
                $keys = array_keys($items);
                foreach ($keys as $key)
                {
                    $this->data['items'][] = new Item($this, $items[$key]);
                }
            }
            if ($items = $this->get_feed_tags(NAMESPACE_RSS_090, 'item'))
            {
                $keys = array_keys($items);
                foreach ($keys as $key)
                {
                    $this->data['items'][] = new Item($this, $items[$key]);
                }
            }
            if ($items = $this->get_channel_tags(NAMESPACE_RSS_20, 'item'))
            {
                $keys = array_keys($items);
                foreach ($keys as $key)
                {
                    $this->data['items'][] = new Item($this, $items[$key]);
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

Feed::add_static_extension('get', '\\ComplexPie\\xmllang', 10);
