<?php

/**
 * Net_IPv6 test cases
 *
 * Copyright (c) 2008-2010 Geoffrey Sneddon.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * 	* Redistributions of source code must retain the above copyright notice,
 *	  this list of conditions and the following disclaimer.
 *
 * 	* Redistributions in binary form must reproduce the above copyright notice,
 *	  this list of conditions and the following disclaimer in the documentation
 *	  and/or other materials provided with the distribution.
 *
 * 	* Neither the name of the SimplePie Team nor the names of its contributors
 *	  may be used to endorse or promote products derived from this software
 *	  without specific prior written permission.
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
 * @package IRI
 * @author Geoffrey Sneddon
 * @copyright 2008-2010 Geoffrey Sneddon
 * @license http://www.opensource.org/licenses/bsd-license.php
 * @link http://hg.gsnedders.com/iri/
 *
 */

require_once 'PHPUnit/Framework.php';
require_once '../src/complexpie.php';
 
class NetIPv6Test extends PHPUnit_Framework_TestCase
{
	public static function compress_tests()
	{
		return array(
			array('2001:ec8:1:1:1:1:1:1', '2001:ec8:1:1:1:1:1:1'),
			array('ffff::FFFF:129.144.52.38', 'ffff::FFFF:129.144.52.38'),
			array('ffff:0:0:0:0:FFFF:129.144.52.38', 'ffff::FFFF:129.144.52.38'),
			array('2010:0588:0000:faef:1428:0000:0000:57ab', '2010:588:0:faef:1428::57ab'),
			array('0000:0000:0000:588:0000:FAEF:1428:57AB', '::588:0:faef:1428:57ab'),
			array('0:0:0:0588:0:FAEF:1428:57AB', '::588:0:faef:1428:57ab'),
			array('FF01:0:0:0:0:0:0:101', 'ff01::101'),
			array('0:0:0:0:0:0:0:0', '::'),
			array('0:0:0:0:0:0:0:1', '::1'),
			array('1:0:0:0:0:0:0:0', '1::'),
			array('0:0:0588:0:0:FAEF:1428:57AB', '0:0:588::faef:1428:57ab'),
			array('0::1', '::1'),
		);
	}
 
	/**
	 * @dataProvider compress_tests
	 */
	public function testCompress($input, $output)
	{
		$this->assertEquals(strtolower($output), strtolower(\ComplexPie\Net_IPv6::compress($input)));
	}
	
	public static function uncompress_tests()
	{
		return array(
			array('ff01::101', 'ff01:0:0:0:0:0:0:101'),
			array('::1', '0:0:0:0:0:0:0:1'),
			array('1::', '1:0:0:0:0:0:0:0'),
		);
	}
 
	/**
	 * @dataProvider uncompress_tests
	 */
	public function testUncompress($input, $output)
	{
		$this->assertEquals(strtolower($output), strtolower(\ComplexPie\Net_IPv6::uncompress($input)));
	}
	
	public static function validity_tests()
	{
		return array(
			array('2001:ec8:1:1:1:1:1:1', true),
			array('ffff::FFFF:129.144.52.38', true),
			array('ffff:0:0:0:0:FFFF:129.144.52.38', true),
			array('2010:0588:0000:faef:1428:0000:0000:57ab', true),
			array('0000:0000:0000:588:0000:FAEF:1428:57AB', true),
			array('0:0:0:0588:0:FAEF:1428:57AB', true),
			array('2001:4abc:abcd:0000:3744:0000:0000:0000', true),
			array('FF01:0:0:0:0:0:0:101', true),
			array('0:0:0:0:0:0:0:0', true),
			array('0:0:0:0:0:0:0:1', true),
			array('1:0:0:0:0:0:0:0', true),
			array('2001:4abc:abcd:0:3744::', true),
			array('ff01::101', true),
			array('::1', true),
			array('1::', true),
			array('2001:0DB8:0000:CD30:0000:0000:0000:0000', true),
			array('2001:0DB8::CD30:0:0:0:0', true),
			array('2001:0DB8:0:CD30::', true),
			array('::', true),
			array('FF00::', true),
			array('FE80::', true),
			array('0:0:0:0:0:0:13.1.68.3', true),
			array('0:0:0:0:0:FFFF:129.144.52.38', true),
			array('::13.1.68.3', true),
			array('::FFFF:129.144.52.38', true),
			array('ABCD:EF01:2345:6789:ABCD:EF01:2345:6789', true),
			array('2001:DB8:0:0:8:800:200C:417A', true),
			array('::FFFF:129.144.52.38', true),
			array('fo::', false),
			array('of::', false),
			array('ff:lo::ff', false),
			array('ff::lo:ff', false),
			array('0', false),
			array('0:0', false),
			array('0:0:0', false),
			array('0:0:0:0', false),
			array('0:0:0:0:0', false),
			array('0:0:0:0:0:0', false),
			array('0:0:0:0:0:0:0', false),
			array('0:255.255.255.255', false),
			array('0:0:255.255.255.255', false),
			array('0:0:0:255.255.255.255', false),
			array('0:0:0:0:255.255.255.255', false),
			array('0:0:0:0:0:255.255.255.255', false),
			array('0:0:0:0:0:0:0:255.255.255.255', false),
			array('0:0:0:0:0:0:0:0:255.255.255.255', false),
			array('0:0:0:0:0:0:z:0:1', false),
			array('0:0:0:0:0:0:255.255.255.a.255', false),
			array('0:0:0:0:0:0:255.255.0255.255.255', false),
		);
	}
 
	/**
	 * @dataProvider validity_tests
	 */
	public function testValid($input, $valid)
	{
		$this->assertEquals($valid, \ComplexPie\Net_IPv6::check_ipv6($input));
	}
}

?>
