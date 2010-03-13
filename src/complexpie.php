<?php
namespace ComplexPie;

/**
 * ComplexPie
 *
 * A PHP-Based RSS and Atom Feed Framework.
 * Takes the easy work out of managing a complete feed reader.
 *
 * Copyright (c) 2004-2010, Ryan Parman, Geoffrey Sneddon, Ryan McCue, and
 * contributors. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *     * Redistributions of source code must retain the above copyright notice,
 *       this list of conditions and the following disclaimer.
 *
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *
 *     * Neither the name of the SimplePie Team nor the names of its
 *       contributors may be used to endorse or promote products derived from
 *       this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS AND CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @version 2.0-dev
 * @copyright 2004-2010 Ryan Parman, Geoffrey Sneddon, Ryan McCue
 * @author Ryan Parman
 * @author Geoffrey Sneddon
 * @author Ryan McCue
 * @link http://simplepie.org/ SimplePie
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 * @todo phpDoc comments
 */

require_once 'constants.php';
require_once 'nodeToHTML.php';
require_once 'atom10/links.php';
require_once 'xml/lang.php';

if (extension_loaded('spl'))
{
    if (spl_autoload_functions() === false && function_exists('__autoload'))
    {
        spl_autoload_register('__autoload');
    }
    
    function autoload($classname)
    {
        if (substr($classname, 0, 11) === 'ComplexPie\\')
        {
            $file = dirname(__FILE__) . '/' . str_replace('\\', '/', strtolower(substr($classname, 11))) . '.php';
            if (file_exists($file))
            {
                $init = dirname($file) . '/_init.php';
                if (file_exists($init))
                    require_once $init;
                
                require_once $file;
            }
        }
    }
    
    spl_autoload_register('ComplexPie\autoload');
}
else
{
    $files = glob(dirname(__FILE__) . '/*.php');
    foreach ($files as $file)
    {
        if ($file !== __FILE__)
            require_once $file;
    }
}

/**
 * ComplexPie
 */
function ComplexPie($data, $uri = null)
{
    // Create new parser
    $parser = new Parser();
    $dom = new \DOMDocument();
    $dom->documentURI = $uri;

    // If it's parsed fine
    if (@$dom->loadXML($data))
    {
        $parser->parse($data, 'UTF-8');
        $tree = $parser->get_data();
        switch ('{' . $dom->documentElement->namespaceURI . '}' . $dom->documentElement->localName)
        {
            case '{' . NAMESPACE_ATOM_10 . '}feed':
                return new Atom10\Feed($dom->documentElement, $tree);
            
            
            case '{' . NAMESPACE_ATOM_03 . '}feed':
                $element = $dom->documentElement;
                break;
            
            case '{}rss':
                $channels = $dom->getElementsByTagName('channel');
                foreach ($channels as $channel)
                {
                    if ($channel->parentNode === $dom->documentElement)
                    {
                        $element = $channel;
                    }
                }
                if (!isset($element))
                {
                    $channel = $dom->createElement('channel');
                    $dom->documentElement->appendChild($channel);
                    $element = $channel;
                }
                return new RSS20\Feed($element, $tree);
            
            case '{' . NAMESPACE_RDF . '}RDF':
                $channels = $dom->getElementsByTagNameNS(NAMESPACE_RSS_10, 'channel');
                foreach ($channels as $channel)
                {
                    if ($channel->parentNode === $dom->documentElement)
                    {
                        $element = $channel;
                    }
                }
                if (!isset($element))
                {
                    $channels = $dom->getElementsByTagNameNS(NAMESPACE_RSS_090, 'channel');
                    foreach ($channels as $channel)
                    {
                        if ($channel->parentNode === $dom->documentElement)
                        {
                            $element = $channel;
                        }
                    }
                    if (!isset($element))
                    {
                        if ($dom->getElementsByTagNameNS(NAMESPACE_RSS_090, '*')->length >
                            $dom->getElementsByTagNameNS(NAMESPACE_RSS_10, '*')->length)
                        {
                            $channel = $dom->createElementNS(NAMESPACE_RSS_090, 'channel');
                        }
                        else
                        {
                            $channel = $dom->createElementNS(NAMESPACE_RSS_10, 'channel');
                        }
                        $dom->documentElement->appendChild($channel);
                        $element = $channel;
                    }
                }
                break;
            
            default:
                return false;
        }
        $feed = new XML\Feed($element, $tree);
        return $feed;
    }
    else
    {
        // We have an error, just set Misc::error to it and quit
        $error = sprintf('This XML document is invalid, likely due to invalid characters. XML error: %s at line %d, column %d', $parser->get_error_string(), $parser->get_current_line(), $parser->get_current_column());

        Misc::error($error, E_USER_NOTICE, __FILE__, __LINE__);
    
        return false;
    }
}
