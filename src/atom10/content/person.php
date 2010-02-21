<?php
namespace ComplexPie\Atom10\Content;

class Person
{
    protected $node;
    
    protected $name;
    protected $uri;
    protected $email;
    
    public function __construct($node)
    {
        $this->node = $node;
        
        $names = \ComplexPie\Misc::xpath($node, 'atom:name', array('atom' => XMLNS));
        if ($names->length)
        {
            $this->name = \ComplexPie\Content::from_textcontent($names->item(0));
        }
        
        $uris = \ComplexPie\Misc::xpath($node, 'atom:name', array('atom' => XMLNS));
        if ($uris->length)
        {
            $this->uri = new \ComplexPie\Content\IRINode($uris->item(0));
        }
        
        $emails = \ComplexPie\Misc::xpath($node, 'atom:email', array('atom' => XMLNS));
        if ($emails->length)
        {
            $this->email = \ComplexPie\Content::from_textcontent($emails->item(0));
        }
    }
    
    public function __get($name)
    {
        if (
            $name === 'name' ||
            $name === 'uri' ||
            $name === 'email'
        )
        {
            return $this->$name;
        }
    }
}
