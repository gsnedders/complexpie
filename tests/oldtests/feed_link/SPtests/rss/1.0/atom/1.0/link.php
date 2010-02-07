<?php

class SimplePie_Feed_Link_Test_RSS_10_Atom_10_Link extends SimplePie_Feed_Link_Test
{
    function data()
    {
        $this->data = 
'<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://purl.org/rss/1.0/" xmlns:a="http://www.w3.org/2005/Atom">
    <channel>
        <a:link href="http://example.com/"/>
    </channel>
</rdf:RDF>';
    }
    
    function expected()
    {
        $this->expected = 'http://example.com';
    }
}

?>