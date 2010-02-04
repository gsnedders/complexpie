<?php

class SimplePie_First_Item_Content_Test_RSS_091_Netscape_Atom_03_Content extends SimplePie_First_Item_Content_Test
{
    function data()
    {
        $this->data = 
'<!DOCTYPE rss SYSTEM "http://my.netscape.com/publish/formats/rss-0.91.dtd">
<rss version="0.91" xmlns:a="http://purl.org/atom/ns#">
    <channel>
        <item>
            <a:content>Item Description</a:content>
        </item>
    </channel>
</rss>';
    }
    
    function expected()
    {
        $this->expected = 'Item Description';
    }
}

?>