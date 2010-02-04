<?php

class SimplePie_First_Item_Author_Name_Test_RSS_091_Netscape_Atom_03_Name extends SimplePie_First_Item_Author_Name_Test
{
    function data()
    {
        $this->data = 
'<!DOCTYPE rss SYSTEM "http://my.netscape.com/publish/formats/rss-0.91.dtd">
<rss version="0.91" xmlns:a="http://purl.org/atom/ns#">
    <channel>
        <item>
            <a:author>
                <a:name>Item Author</a:name>
            </a:author>
        </item>
    </channel>
</rss>';
    }
    
    function expected()
    {
        $this->expected = 'Item Author';
    }
}

?>