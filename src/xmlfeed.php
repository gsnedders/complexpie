<?php
namespace ComplexPie;

class XMLFeed extends Feed
{
    protected static $static_ext = array();
}

/* RSS 2.0 is not included here as we don't want to pick up the non-namespaced
   elements unless we are treating the tree as RSS 2.0. */
XMLFeed::add_static_extension('get', '\\ComplexPie\\Atom10\\Feed::get', 10, true);