<?php

class SimplePie_Absolutize_Test_RFC3986 extends SimplePie_Absolutize_Test
{
    function __construct()
    {
        // Ugly hack so it only applies to this and none of its children
        if (!is_subclass_of($this, 'SimplePie_Absolutize_Test_RFC3986'))
        {
            $this->test = false;
        }
        parent::__construct();
    }
    
    function init()
    {
        $this->data['base'] = 'http://a/b/c/d;p?q';
    }
}

?>