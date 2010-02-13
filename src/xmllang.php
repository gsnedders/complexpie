<?php
namespace ComplexPie;

function xmllang($dom, $name)
{
    if ($name === 'language')
    {
        $xpath = new \DOMXPath($dom->ownerDocument);
        $xpath->registerNamespace('xml', NAMESPACE_XML);
        $results = $xpath->query('ancestor-or-self::*/@xml:lang', $dom);
        if ($results->length)
        {
            return $results->item($results->length - 1)->value;
        }
    }
}
