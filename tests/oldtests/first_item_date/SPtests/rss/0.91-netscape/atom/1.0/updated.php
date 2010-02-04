<?php

class SimplePie_First_Item_Date_Test_RSS_091_Netscape_Atom_10_Updated extends SimplePie_First_Item_Date_Test
{
    function data()
    {
        $this->data = 
'<!DOCTYPE rss SYSTEM "http://my.netscape.com/publish/formats/rss-0.91.dtd">
<rss version="0.91" xmlns:a="http://www.w3.org/2005/Atom">
    <channel>
        <item>
            <a:updated>2007-01-11T16:00:00Z</a:updated>
        </item>
    </channel>
</rss>';
    }
    
    function expected()
    {
        $this->expected = 1168531200;
    }
}

?>