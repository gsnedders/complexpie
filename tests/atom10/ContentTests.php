<?php

require_once 'PHPUnit/Framework.php';

require_once 'ContentContentTest.php';
require_once 'ContentTextConstructTest.php';

class Atom10_ContentTests
{
	public static function suite()
	{
		$suite = new PHPUnit_Framework_TestSuite('ComplexPie Atom 1.0 Content');

		$suite->addTestSuite('Atom10_ContentContentTest');
		$suite->addTestSuite('Atom10_ContentTextConstructTest');

		return $suite;
	}
}

?>