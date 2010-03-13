<?php
namespace ComplexPie\Atom10;

function links($dom, $name)
{
    if ($name === 'links')
    {
        $nodes = \ComplexPie\Misc::xpath($dom,'atom:link[@href]', array('atom' => XMLNS));
        if ($nodes->length !== 0)
        {
            $return = array();
            foreach ($nodes as $node)
            {
                $link = new Content\Link($node);
                $rel = $link->rel->to_text();
                if (!isset($return[$rel]))
                {
                    $return[$rel] = array();
                    if (strpos($rel, \ComplexPie\IANA_LINK_RELATIONS_REGISTRY) === 0)
                    {
                        $return[substr($rel, strlen(\ComplexPie\IANA_LINK_RELATIONS_REGISTRY))] =& $return[$rel];
                    }
                }
                $return[$rel][] = $link;
            }
            return $return;
        }
    }
}
