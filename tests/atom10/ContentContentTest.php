<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . '/../../src/complexpie.php';

class Atom10_ContentContentTest extends PHPUnit_Framework_TestCase
{
    protected function getContent($input)
    {
        $dom = new \DOMDocument;
        $dom->loadXML($input);
        $element = $dom->documentElement;
        return \ComplexPie\Atom10\Content::from_content($element);
    }

    public function basicData()
    {
        return array(
            array('<foobar>PASS</foobar>'),
            array('<foobar type="text">PASS</foobar>'),
            array('<foobar type="text/plain">PASS</foobar>'),
            array('<foobar type="TEXT/PLAIN">PASS</foobar>'),
        );
    }
    
    /**
     * @dataProvider basicData
     */
    public function testBasic($input)
    {
        $this->assertSame('PASS', $this->getContent($input)->to_text());
    }
    
    public function testEmpty()
    {
        $this->assertSame('', $this->getContent('<foobar/>')->to_text());
    }
    
    public function bogusMimeData()
    {
        return array(
            array('<foobar type="HTML">&lt;a href="http://example.com">Test&lt;/a></foobar>'),
            array('<foobar type="htMl">&lt;a href="http://example.com">Test&lt;/a></foobar>'),
            array('<foobar type=" html ">&lt;a href="http://example.com">Test&lt;/a></foobar>'),
            array('<foobar type="htm">&lt;a href="http://example.com">Test&lt;/a></foobar>'),
            array('<foobar type="XHTML"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
            array('<foobar type="xhtMl"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
            array('<foobar type=" xhtml "><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
            array('<foobar type="xht"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
            array('<foobar type="totallybogus">&lt;a href="http://example.com">Test&lt;/a></foobar>'),
        );
    }
    
    /**
     * @dataProvider bogusMimeData
     */
    public function testBogusMime($input)
    {
        $this->assertSame(false, $this->getContent($input));
    }
    
    public function looksLikeHtmlData()
    {
        return array(
            array('<foobar>&lt;a href="http://example.com">Test&lt;/a></foobar>'),
            array('<foobar>&#x3C;a href="http://example.com">Test&#x3C;/a></foobar>'),
            array('<foobar><![CDATA[<a href="http://example.com">Test</a>]]></foobar>'),
        );
    }
    
    /**
     * @dataProvider looksLikeHtmlData
     */
    public function testLooksLikeHtml($input)
    {
        $this->assertSame('<a href="http://example.com">Test</a>', $this->getContent($input)->to_text());
    }
    
    public function htmlData()
    {
        return array(
            array('<foobar type="html">&lt;a href="http://example.com">Test&lt;/a></foobar>'),
            array('<foobar type="html">&#x3C;a href="http://example.com">Test&#x3C;/a></foobar>'),
            array('<foobar type="html"><![CDATA[<a href="http://example.com">Test</a>]]></foobar>'),
            array('<foobar type="html" xml:base="http://example.com">&lt;a href="/">Test&lt;/a></foobar>'),
            array('<foobar type="text/html">&lt;a href="http://example.com">Test&lt;/a></foobar>'),
            array('<foobar type="text/html">&#x3C;a href="http://example.com">Test&#x3C;/a></foobar>'),
            array('<foobar type="text/html"><![CDATA[<a href="http://example.com">Test</a>]]></foobar>'),
            array('<foobar type="text/html" xml:base="http://example.com">&lt;a href="/">Test&lt;/a></foobar>'),
        );
    }
    
    /**
     * @dataProvider htmlData
     */
    public function testHtml($input)
    {
        $this->assertSame('<a href="http://example.com">Test</a>', $this->getContent($input)->to_html());
    }
    
    public function testHtmlInDiv()
    {
        $input = '<foobar type="html" xml:base="http://example.com">&lt;div>&lt;a href="/">Test&lt;/a>&lt;/div></foobar>';
        $this->assertSame('<div><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_html());
    }
    
    public function looksLikeXmlData()
    {
        return array(
            array('<foobar><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
        );
    }
    
    /**
     * @dataProvider looksLikeXmlData
     */
    public function testLooksLikeXml($input)
    {
        $this->assertSame('Test', $this->getContent($input)->to_xml());
    }

    public function xhtmlData()
    {
        return array(
            array('<foobar type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
            array('<foobar type="xhtml" xml:base="http://example.com"><div xmlns="http://www.w3.org/1999/xhtml"><a href="/">Test</a></div></foobar>'),
            array(
<<<EOF
<foobar type="xhtml">
    <div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>
</foobar>
EOF
            ),
            array(
<<<EOF
<foobar type="xhtml">
    <div xmlns="http://www.w3.org/1999/xhtml">
        <a href="http://example.com">Test</a>
    </div>
</foobar>
EOF
            ),
            array('<foobar type="xhtml">&#x20;<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>&#x20;</foobar>'),
            array('<foobar type="xhtml"><!--foo--><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
            array('<foobar type="application/xhtml+xml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
            array('<foobar type="APPLICATION/XHTML+XML"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
        );
    }
    
    /**
     * @dataProvider xhtmlData
     */
    public function testXhtml($input)
    {
        $this->assertSame('<a href="http://example.com">Test</a>', $this->getContent($input)->to_html());
    }

    public function xmlData()
    {
        return array(
            array('<foobar type="application/xml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
            array('<foobar type="text/xml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
            array('<foobar type="image/xml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
            array('<foobar type="image/svg+xml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
            array('<foobar type="x-foo/bar+xml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>'),
        );
    }
    
    /**
     * @dataProvider xmlData
     */
    public function testXml($input)
    {
        $this->assertSame('<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_xml());
    }

    public function escapedXmlData()
    {
        return array(
            array('<foobar type="xhtml">&lt;div xmlns="http://www.w3.org/1999/xhtml">&lt;a href="http://example.com">Test&lt;/a>&lt;/div></foobar>'),
            array('<foobar type="xhtml">&#x3C;div xmlns="http://www.w3.org/1999/xhtml">&#x3C;a href="http://example.com">Test&#x3C;/a>&#x3C;/div></foobar>'),
            array('<foobar type="xhtml"><![CDATA[<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>]]></foobar>'),
        );
    }
    
    /**
     * @dataProvider escapedXmlData
     */
    public function testEscapedXml($input)
    {
        $this->assertSame('<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_text());
    }
    
    public function testXmlImportantWhitespace()
    {
        $input = '<foobar type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><span>Hello,</span> <span>world!</span></div></foobar>';
        $this->assertSame('<span>Hello,</span> <span>world!</span>', $this->getContent($input)->to_html());
    }
    
    public function testXmlOnlyWhitespace()
    {
        $input = '<foobar type="xhtml"> </foobar>';
        $this->assertSame('', $this->getContent($input)->to_html());
    }
    
    public function testXmlOnlyComment()
    {
        $input = '<foobar type="xhtml"><!--foo--></foobar>';
        $this->assertSame('<!--foo-->', $this->getContent($input)->to_html());
    }
    
    public function testXmlMultipleDiv()
    {
        $input = '<foobar type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>';
        $this->assertSame('<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_html());
    }
    
    public function testXmlDivAfterText()
    {
        $input = '<foobar type="xhtml">foobar<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>';
        $this->assertSame('foobar<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_html());
    }
    
    public function testXmlDivBeforeText()
    {
        $input = '<foobar type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>foobar</foobar>';
        $this->assertSame('<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>foobar', $this->getContent($input)->to_html());
    }
    
    public function testXmlDivAfterTextStartingWithWhitespace()
    {
        $input = '<foobar type="xhtml">foobar<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>';
        $this->assertSame('foobar<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_html());
    }
    
    public function testXmlDivBeforeTextStartingWithWhitespace()
    {
        $input = '<foobar type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div> foobar</foobar>';
        $this->assertSame('<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div> foobar', $this->getContent($input)->to_html());
    }
    
    public function testXmlDivAfterCDATA()
    {
        $input = '<foobar type="xhtml"><![CDATA[foobar]]><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>';
        $this->assertSame('<![CDATA[foobar]]><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_xml());
    }
    
    public function testXmlDivBeforeCDATA()
    {
        $input = '<foobar type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><![CDATA[foobar]]></foobar>';
        $this->assertSame('<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><![CDATA[foobar]]>', $this->getContent($input)->to_xml());
    }
    
    public function testXmlDivAfterCDATAStartingWithWhitespace()
    {
        $input = '<foobar type="xhtml"><![CDATA[foobar]]><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>';
        $this->assertSame('<![CDATA[foobar]]><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_xml());
    }
    
    public function testXmlDivBeforeCDATAStartingWithWhitespace()
    {
        $input = '<foobar type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><![CDATA[ foobar]]></foobar>';
        $this->assertSame('<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><![CDATA[ foobar]]>', $this->getContent($input)->to_xml());
    }
    
    public function testXmlDivAfterPI()
    {
        $input = '<foobar type="xhtml"><?foo?><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div></foobar>';
        $this->assertSame('<?foo?><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div>', $this->getContent($input)->to_xml());
    }
    
    public function testXmlDivBeforePI()
    {
        $input = '<foobar type="xhtml"><div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><?foo?></foobar>';
        $this->assertSame('<div xmlns="http://www.w3.org/1999/xhtml"><a href="http://example.com">Test</a></div><?foo?>', $this->getContent($input)->to_xml());
    }
    
    public function testJpegBinary()
    {
        $binary = <<<EOF
/9j/4AAQSkZJRgABAgAAZABkAAD/7AARRHVja3kAAQAEAAAAHgAA/+4AIUFkb2JlAGTAAAAAAQMA
EAMCAwYAAAehAAAPBAAAFpn/2wCEABALCwsMCxAMDBAXDw0PFxsUEBAUGx8XFxcXFx8eFxoaGhoX
Hh4jJSclIx4vLzMzLy9AQEBAQEBAQEBAQEBAQEABEQ8PERMRFRISFRQRFBEUGhQWFhQaJhoaHBoa
JjAjHh4eHiMwKy4nJycuKzU1MDA1NUBAP0BAQEBAQEBAQEBAQP/CABEIAZABLAMBIgACEQEDEQH/
xAC3AAEBAQEBAQEAAAAAAAAAAAABAAIDBgQFAQEBAQEBAAAAAAAAAAAAAAAAAQIDBBAAAgECBgIC
AwACAgMAAAAAAAEREAIgITFBAwQSBTAGQBMUJDVQIyI0FREAAQIDBQQJAgYDAQAAAAAAAQACEBEh
IDFRYQNBcZESMECBobHBIjIzYgTRQnKCkhNSIzThEgABAgUCBgAHAAAAAAAAAAABABEgMEAhMRAC
UGBwQVFxYZGhIjIDM//aAAwDAQACEQMRAAAA8MjcTmVcqSJVElDVVVFVY1LIlCVSVVI0pTRVCIDR
yqVqKomkqlSkYSqKYqqmkqpaopqGihBKJoKjnCtUjUskjVLDVTINFUTRVFSVRVVVRVFUtVZCRySV
pKqRGqqKYpCZCqqaKoqaJoqiqqkIaUmsJyckZZIaSVjKllMUwSmbUEplasrQTBLWVING6wbyBoM1
HGqVRFE10+r9K5/CPQaTz16PS+bvT6PLvqdp5N9bo8gey0eMvaR4u9snib26eHfcVeHPch4jfs8H
js+z2nh+f7n4jeBI40y2so7zo/X/AHfwfRXBq0hq0GqhSpqVhgpJKmpIYBAx0DnrQee/F/X/ACLr
E5Xg1iqNO87j9P0vmPUaw6yxqEUlUSqJpaZKYGiqSGsyaAzrJ5r8n9b8lrBrLXBNSyaHeNyfd6ry
XrbnSaJkmpZlRkqSmIZCYJrCZCazOOmTyv5f6f5jec6xLyqV1nRrWdR9HsfGeyudaGF5q9Hkr0eW
zTzwfRc8nd46Olz4n1XDabvl6Wdj5FPqfl2nWSzyf5n6f5jecpLxRlU0Os6Ons/GewTuycH6NL8H
f6dHxfR2V+bH2pwz9THC7py5/TJw6aLOd0LOeeoc3QgMnkfzf0fzrrOUXijK6zqV1nR09d5H1ifZ
q1E2lmVmSaFEaQmQNFmTQmTRZmRIRPH/AJ33/BdYHMvN12l4a+rmvHedLv1XlfTp+prOodCq0qis
yTJVJNJCIGs2GdZQNFhUz4v4Pu+G6zlJcRqau3KNazqXfpfNeit/a0ahZmpFVEmhqGJGKxiZiEKL
mIsiE8T8n0fNdZEzcdcaXrxvpmuRJr9/8H9xr0Ojedzaayso0MQwI2S53c5ndiZ0Yxc9DlmztfPl
n6c/Nys8py1hc0Rjplm9hpbRprX7H5HSb92+IZ19pjxwvruflRPT48zWeiz54Z/f5/h1z+xz/LGf
08fn1n34+IZ+vHz1nXPMTpnEjkIiKiJLQzo6NLbNTb1Pqnfm/VjPXhjvi55Z7c7zwaLky5uEhlHN
yxEUykUkJRSBQUBUml+ydPk1+l1b/K26z17/AKPwfp59fb5/r+V1+bl25OOOfTlcYyl5Yy5vOouE
i5SEYkqkKCisKIhAGs+36Of0Z33zcs99cPop6OfbbOry1gzz3ljHPpzuMFnXKLN5pDKVc1SVSQhC
ISAIQgVJ9/6v4P7U6dT6PonTh+5x9Xn0ee4evLjxefZ8l8hr1HNPwfg9V5Vrzfz/AF/FcRF4sCNV
zUJooqkJAqIghEBDtvm57ff9X5PV1/b/AHfG9sen0/D8DLp+x8/5vNn9Dl8XPXL7uPy5ctYC8ki5
YbmoRqJJGgSqioBEhAErtFntrfPU311yp07HGOuedc6yZZ3kLhiSSZYqakYhqSSshCqgGAoM6K6V
Z7usJqzDBDAiRZohGJFy2MQ1IxDUMSVRVUCREFRWnLOqkrFDEkVVUlQiSlCjUVVjVKwlVZCQlVER
CUTQOVvVmXVmNWUnMjEMSNSNVSQwolQ1FCQg0VFRFVRH/9oACAECAAEFAPwFNVi2dVr8EYnI67kE
0WOPlVN8bIwxh3rFIwZVyxb/APDqm34W3ys3/BZOf4LwZ/O/xtKySST8KJzNqTSCCCEQRhVJpuxj
dJrn8GxJvPxL4Mh6/O1VpCSb8DxRCHGBYGTSKb5/hxSBIggyo1SIdcjak50ii+GMWXz61ikEDo9B
Ycx1VP/aAAgBAwABBQD8fb5dvyH8sZEfito8keR5HkeR5HkeR5M8meTPJkicrA9cEVjFbhepBBGK
MC0wPXDFIxLTA9SCCCMMYFpgfzLTarwQQR8C0pNGIggggjA8CwtCRBBBBBBA1hVEasSFaeJ4nieJ
BA0NUeJUSESO482O+48mO5ksdHhQhIssk8B2jtIGqP4Ioky1HGkXQMY4hjGP4eO1pWpMVrQ2xl0j
Yxv4naWXchdycnHxLu3n9HLcO/lZx+TfJHlJI3jVEWq2bVY7fNIu5C69F143SRurxITFcebPIdw2
P5pJpPzKs0k2xxhVJJ/A/9oACAEBAAEFAIwKk5baLKsmVHqb7DiKZTlXIcURvSM9KRnTMmiIE6ZV
RkbJqaKRYcowaVmrywQ6QyDKDOipAicGVEaU3wImMWY5MyVWJIlECFRYtKaGoqLU1oowLMyrqOCM
jOBZm1NkaGxrXM2dYyRlOVdopLkWuBabQZUWi1rFNjOi0pCoxVg3NxiIw5kZU2iqzFrlGCJolSDd
QPAliVFV01plFUiDfFCpBGUGrggSIzpoOqMjIimRFGQbCpvvlSKLSKrSJUI0IpqRiiRGSIMo8RW0
0Nmb1QqJSeOTShIgisEZwbQiCCBIjOJIIFSCCMjMRkZm9N6LS1ZpDty8TxPFitZ4sVp4MVjPA8Dw
PDPwPA8DwbPA8GfrZ+q4/VcfpvFw3w+Dkb/n5S/jvsHTKm4hSJHreh/bfb6DjF6HgF9f6p/8DqC9
D0i30PRQvRevF6P16F6X1yF6b1qF6n1yF6z16F0Oij+LqI/l6yP5uAXX4BcHCfo4T9PCfq4j9fGe
Fg7LBq2UrZi0+xJfuY4N90jQQi09C3/QrWJUSEhIWCcKxSTR2NvxabPsL/yHqyc4EIRuj0OXc8SB
ISF8k4IIpBBA0e/f+XdhVEI9G47qEhEi+KCPgaqz30/23DN1VC1t09O47yqhE4UQR8rGe+f+cxmc
m6EW6o9W47qF80Y4IIPEu1945792pnKqsxao6DjtIQvmgj4Gxo93/sGOqEZiFp1XHOtFVfDHxzRn
u/8AYM2zNxCEI4XF9mdtHy8drXLxtrscUXc1lqfY4lbbf5FvKrm+1auNcs8i7Vtxzc13Fb2eV8PH
Zyt81/a5LeRct93Y7C5lZd254XfdZ2uzzX8fLyXcq575/q6l/Jydenu/9gx0zFRZJCLHD4XPEJHY
tf7L+O59u3g5f5+bj5OTi/n5lx8HHdZbd1fLlu6V93Hb17rOa3peHHzdZ8vHzda7mss4FbyX9Ky9
/wA1qvdpdwcVyXFarnw8bu/RxIfFxzCVfdf7C4cm+4qIRbJ1HPWEIWBfDGBkDGQQe5z9hcOjEKKI
RYeuc9JISovlY6seBnt3/n3DMqI0IELS3X1LnoIRAkJC+OKR8Htv/fuM0SjWqQhFp6Rz0EKqwpC+
CBjQ8Ptc+9cM3s43cP8AgS6/H63lv5+vdwXCyLT0LnpIQsKF8bGOjpv7Nz3bqb3XNtCOHmdieTRa
fXn/AIyFRCqvkeJs7zntMdILbbmO12vM1EWn1x/9SEL4pJrJJJJI2SSNko7V08zrDOLNcy/60X2u
0Raj6280hVSxzSSSSTyHcO4dw7jyPI8i+6LeVzc2MyLUrzxvtFbfc1w29dNttZCR9cf+QkJEEEY5
PI8jyPIkkdw7x3ofLYh9jiQ+3wD73WRz+y6i4brpG6bxnbfdaLk5GJIQi1H166O6oR+zitH2+paX
ey9faP3HrUXe+9ai77F0UXfZOqh/ZuIf2ZD+zXsu+ydlj+w91j9932P3ffY/c+wH7fvtv2veZd3+
1cPtc7HzcjHy3Md7HcO4bGzZ6biQhCQkWlt11rXJeySR3OfJzI7htksk8iSSSRs8smxvORsnKRvK
c26M2k3WiEZiTLUW2stsg8RpjWbQ0MZMGpJmSSZjJJrM1kbzdNFtnRCVEWo47ZLOOUuFpXcbQ7R2
jtLrRoazeu+Cc2zaaTJOB6tmieryJzokQJFqOG2Tg4pT4YXJxoutQ7UNFyHE3DzdNjYeGXgeDNUV
rufBbxcb4/577+31uHsHg7brEcTSOvyWRdyLx5L0y+5Tdch3S7rst73JJNNlRm7ruya71klHFb/4
2eJb1rrePztT5uGx8atZajjvdo+dl3I2O4bHcO5MbzbG83NNlJI9X8LqyMt7XC6llru5OZ8jXlc7
uNuyzibFwM/S0nYx2sdo7S5MuSLh03dNB42OjN4HScoz63jyW9fr5X+s5BdTmRx9Dl5F6z64uZX+
guRf6HkL/Q84vQ84/Qdllv13tss+u9wlcPe7nH+rsXMnOSScpRlEm5vuh1eDbYtyOl7LkXHZ7h8R
b9i5Dqe+7HJf0edc/XHfYi7s9e0u9l0LS73frLR/YfVou+yevR2ubl7fu/ZX+XeZOeZmZ0WqN3ii
kkGzNocpll7tfD7DmtLPY2nD7OH6/wCzLrK/3ibv9ycnueRl/teZu/2fYY/Y9kv9l2i72Hbm+93N
uTfKs5SI3MxOjFVzTZus55FrLbiy+C3mZ+7J8rafI2O8uvLrx3DdJqponTI3zxtY4SFkJwJwW3Cv
Z+xjvcO88x3EsbJJJJM6ba4JwZVeBm28zSSRM8iTyJzkkljZI4NzYyqhazmPTBODIWkE5CJJJJrn
EjJzmu+hvScLN66UzkZqs51JJMoyJJE4JZtoTmSyciVVQTTKug65GqymkVjOVgVFgeQtTWi11dEb
YprNJw7CpJNdtCSTKmYx0miM8G2dEbbuuRs6byJk0zpIyTWiyFpSWbm6NDSmRJqbm5vI0M2gZnST
UknLYZlTKDLBE01NhZtxXQyT1MsW2+Rkf//aAAgBAgIGPwBCeEV8KESmgEp5ttXlv0fNGaMwtxMI
0Qg8JllZWV5QlvQjgbaep9rR95IkDX//2gAIAQMCBj8A5j7xYWInhPRbxTYWIM0Jm+fVG+7vijwN
ycbQHLPll+O0q36/k6/mfqvvA2szXR9zbhHaQ4OQrBtbcs//2gAIAQEBBj8AXYpx3wMcVOdIZGF9
LAhnGWyINrxWUbo02QrtXlA5QlYpdCVisMrOcJYqcPGzmvOyclJZQyXjKOVgUhXZZxh4xwhnDNTk
bGapC5TXnCkMI/hC5CM9mMK2Jxmpw/FTutGnYpLyj2KqzU7OCr0WViUKxnswhKNIiAUlJb4Utixl
HKzWHlGizWcMFL83eqbF5rCxVeCyslCS8+lpZ3wkidsZXK5V2KtDlC6z4rOOUfCNOl8FdC5blJed
iirDdGqqqxqslTosY1W9UhKMsIyEKq5XdSnHepRuXlCazU1Nfh0GduZV1rNDaFcririvaZbl7TwK
9p4L2GeMiqabuBUnNLTg6iK8lLbDGy5vPycgBNJquuf4qR1ndjQvmeewL3v7l7nntX5+Kuf/ACXs
d/Ir4yf3FfF3lfAO9U0GqmgzgqaLOAXxM/iF8bf4hfG3gF8beAXxt4BfG3gF7G8AvY3gF7RwXtHB
XBXBXBaUh+U+K3WPKBi8YtVet6Y+jzhKG5UjMKq3tPXGjBg6JoxB65L6RAxzs6ec/Drh/SI3RmFl
HROcuuPyDR3WvFSjpH6h1zVG7whfDNThgqw0ztDh49c1uzw6JpzHigchGRcATSS5QfVKcssU1wdM
PMmkbSgTMAnlu2p7iT/r94lUKgIpMEohonynlOR3J+pymTHchG2c5J2mwczmAF1aVuC0iwTGq4t/
SRfNc3KD6wzjtXOBP1ASOZkn6Dx62AOBFxBWowAHke1oF0w7NamjOXLLkMsROqB0Zf2T9puOS/t0
7y5rOU/kcaGaZoz5majSdxatVvMQ0MBadjXEymclpMPq5tMlzRdOlQtPT5jyHTcTXaNqa7U91RPE
A0MdbePCFF52awB4Jh+keEdFwE+V8zLYCE1wmG8hBcAtJnK4OZqTIF/LO9BrGklrmkE0JAvK19Mj
nOpVmptM9jtyDS0gSm4kzqhqgcmoHe9p9zcHBazPTzaj+dpwE9qfqsl/sADmnY4bVphrvXpvLyTc
Sb1yl3KeYPnuRY58gSCJC6RmnapM9RwAJwA2LU5nHl1SC9v6bk94cQdQAO7LpJv0p4LRLUkXDMbV
zXulLmN8kXFsy4crp7RgmkN9ok04DBA8tQJDcpC6OtvHgqwywRwt6R+keHW9ff5KcM+g0T9I63r/
AKo5IrLCNI6WQl1vX/WVkha8IsyJHW9f9ZscxPKzaT5Icv8Aa920nlaOzauXV1X/AG4/zc3mHbyq
Uw5h9j2mbXDERClg49b1/wBZjJZbAtqpsRYasdsNwOIUovGDut6xxe7xjlD0gnbReoSMBCa1h9Q8
Ot6pxc7xWOEJLcpC/BAm/ZjAA3ymRvjrN3HrTjgCe5OOJJjLar5OxxVQRmFcXE4IP15HUvbogzM8
X4IuNSUV5rUGLR1W8L3DiqvbxC+RvEKuq3itSWq0u5TIA7ZWcl6XGSM3FZxmuX/JpVSB2quo0fuC
rrsH7gq/cM7Kr5p7gV7nO3NVGvPYAqaTz2hSGg7+QVPt+LlTQHa4qmkwcSqBg7F7mj9q+QDcAvmP
AL5nDgpHXeq6z+KrqO4le93Eq88VevGErNULU2kjMUKq4neSq32ZWZ9AOkrbnt6DfY3dPNZxC8YG
MldY77c+ipZCysYQxsXV6CUbukwWUM142KcUHHSGqcX3cAg7V0QZmoBLUHfZ6Q0uUVZOZPab0Wm8
QEKRIVOly6HcqwzQCAlMnYv7XSDd6pVf3NI5iZOZ52MTCvQSsY27o4RlC9BHUdsFAq002bESaTuA
wRIFAhJXKqusTV4jWNIzXlYntt1gYcpMnNx2hBj2ycO8ZKenVorymhVWFNa1pAF+aLtUljWi8CpP
aqabiNyl/TqSyC9P22qVX7LUd2kKn2Lu0r/hb2n/ANX/AB6QwmQh9lqfbaTdTm5HekXrV0yKse4S
7bFYdls252J8ENN7W6zRc11HDc5U0dRuUwR3qYY8djfwQaP7JGlSAO4Jr68wo6d84VcBvK9Wqwfu
Crrt4zVdYHcD+C+Qnc0qg1HbmoffDTcGHUaQNoaKCa+4dKp1HHvjnCnTyVId8AQZHYuU+oYFV0W8
SgRpNHFPbqafMHCgBlXFUnX6l7Z7zNUa0L8vBXjgqPluAXyFAjWcJVEiiSZk1JN8MrOPUJSqjavR
M7FVlYvs1jSyLFYYyRU+9ZZwqs9lqdjJdy32qUsmNId0POxLugLE4UVb152LpjoR0HhAZwKmdtua
vhlYJtS6AWcsYA3wxU1ks8IiBU+hr2wlsgISQsC3RYxyUp1sU2R3xkpKkKdsD4IQyh5WRCUd8Llv
uWe0KcJIoeCmsEYXdB4oKkJLttzV0KKkJwMZw7kVSBkvKzNZ2slOxOAyjXsgNsN8J2BmhjtWCuVV
5qkApisZhVWSzhS3NSiJbFKFN8KXKXepXKSuX//Z
EOF;
        $input = "<foobar type='image/jpeg'>$binary</foobar>";
        $this->assertSame(base64_decode($binary), $this->getContent($input)->get_data());
    }

    public function testInvalidBinary()
    {
        $input = "<foobar type='foo/bar'>Y***Q==</foobar>";
        $this->assertSame(false, $this->getContent($input));
    }

    public function testArbitaryText()
    {
        $input = "<foobar type='text/foobar'>YQ==</foobar>";
        $this->assertSame('YQ==', $this->getContent($input)->get_data());
    }
}

?>
