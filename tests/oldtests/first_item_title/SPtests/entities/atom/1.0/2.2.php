<?php

class SimplePie_First_Item_Title_Test_Atom_10_Title_Text_2 extends SimplePie_First_Item_Title_Test
{
    function data()
    {
        $this->data = 
'<feed xmlns="http://www.w3.org/2005/Atom">
    <entry>
        <title type="text"><![CDATA[This &amp;amp; this]]></title>
    </entry>
</feed>';
    }
    
    function expected()
    {
        $this->expected = 'This &amp;amp;amp; this';
    }
}

?>