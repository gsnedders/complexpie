<?php

class SimplePie_Feed_Title_Test_RSS_090_Atom_10_Title extends SimplePie_Feed_Title_Test
{
    function data()
    {
        $this->data = 
'<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://my.netscape.com/rdf/simple/0.9/" xmlns:a="http://www.w3.org/2005/Atom">
    <channel>
        <a:title>Feed Title</a:title>
    </channel>
</rdf:RDF>';
    }
    
    function expected()
    {
        $this->expected = 'Feed Title';
    }
}

?>