<?php
namespace ComplexPie\XML;

function lang($dom, $name)
{
    if ($name === 'language')
    {
        $xpath = new \DOMXPath($dom->ownerDocument);
        $xpath->registerNamespace('xml', \ComplexPie\NAMESPACE_XML);
        $results = $xpath->query('ancestor-or-self::*/@xml:lang', $dom);
        if ($results->length)
        {
            return \ComplexPie\Content::from_textcontent($results->item($results->length - 1));
        }
    }
}
