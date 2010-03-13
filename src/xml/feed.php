<?php
namespace ComplexPie\XML;

class Feed extends \ComplexPie\Feed
{
    protected static $static_ext = array();
}

/* RSS 2.0 is not included here as we don't want to pick up the non-namespaced
   elements unless we are treating the tree as RSS 2.0. */
Feed::add_static_extension('get', '\\ComplexPie\\Atom10\\Feed::get', 10, true);
Feed::add_static_extension('get', '\\ComplexPie\\Atom10\\links', 10, true);
Feed::add_static_extension('get', '\\ComplexPie\\XML\\lang', 10, true);
