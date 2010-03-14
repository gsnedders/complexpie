<?php
namespace ComplexPie\RSS20;

function links($data, $dom, $name)
{
    if ($name === 'links')
    {
        $nodes = \ComplexPie\Misc::xpath($dom, 'link');
        if ($nodes->length !== 0)
        {
            $return = array();
            $return[\ComplexPie\IANA_LINK_RELATIONS_REGISTRY . 'alternate'] = array();
            $return['alternate'] =& $return[\ComplexPie\IANA_LINK_RELATIONS_REGISTRY . 'alternate'];
            $return['alternate'][] = new \ComplexPie\Content\IRINode($nodes->item(0));
            return $return;
        }
    }
}
