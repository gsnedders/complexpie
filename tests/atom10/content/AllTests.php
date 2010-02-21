<?php

require_once 'PHPUnit/Framework.php';

require_once 'LinkTest.php';

class Atom10_Content_AllTests
{
	public static function suite()
	{
		$suite = new PHPUnit_Framework_TestSuite('ComplexPie Atom 1.0 Content');

		$suite->addTestSuite('ContentLinkTest');

		return $suite;
	}
}

?>