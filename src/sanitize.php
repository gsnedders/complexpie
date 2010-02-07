<?php
namespace ComplexPie;

/**
 * @todo Move to using an actual HTML parser (this will allow tags to be properly stripped, and to switch between HTML and XHTML), this will also make it easier to shorten a string while preserving HTML tags
 */
class Sanitize
{
    // Private vars
    var $base;

    var $replace_url_attributes = array(
        'a' => 'href',
        'area' => 'href',
        'blockquote' => 'cite',
        'del' => 'cite',
        'form' => 'action',
        'img' => array('longdesc', 'src'),
        'input' => 'src',
        'ins' => 'cite',
        'q' => 'cite'
    );

    /**
     * Set element/attribute key/value pairs of HTML attributes
     * containing URLs that need to be resolved relative to the feed
     *
     * @access public
     * @since 1.0
     * @param array $element_attribute Element/attribute key/value pairs
     */
    public function set_url_replacements($element_attribute = array('a' => 'href', 'area' => 'href', 'blockquote' => 'cite', 'del' => 'cite', 'form' => 'action', 'img' => array('longdesc', 'src'), 'input' => 'src', 'ins' => 'cite', 'q' => 'cite'))
    {
        $this->replace_url_attributes = (array) $element_attribute;
    }

    public function dosanitize($data, $type, $base = '')
    {
        $data = trim($data);
        if ($data !== '' || $type & CONSTRUCT_IRI)
        {
            if ($type & CONSTRUCT_BASE64)
            {
                $data = base64_decode($data);
            }

            if ($type & CONSTRUCT_XHTML)
            {
                $data = preg_replace('/^<div' . PCRE_XML_ATTRIBUTE . '>/', '', $data);
                $data = preg_replace('/<\/div>$/', '', $data);
            }

            if ($type & (CONSTRUCT_HTML | CONSTRUCT_XHTML))
            {
                // Replace relative URLs
                $this->base = $base;
                foreach ($this->replace_url_attributes as $element => $attributes)
                {
                    $data = $this->replace_urls($data, $element, $attributes);
                }

                // Having (possibly) taken stuff out, there may now be whitespace at the beginning/end of the data
                $data = trim($data);
            }

            if ($type & CONSTRUCT_IRI)
            {
                $data = Misc::absolutize_url($data, $base);
            }

            if ($type & (CONSTRUCT_TEXT | CONSTRUCT_IRI))
            {
                $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
            }
        }
        return $data;
    }

    public function replace_urls($data, $tag, $attributes)
    {
        $node = new \stdClass;
        $node->textContent = $data;
        $node->baseURI = $this->base;
        //var_dump($this->base);
        return Content::from_escaped_html($node)->to_html();
    }
}
