<?php

require_once 'PHPUnit/Framework.php';
require_once 'FeedTest.php';

class Atom10_AllTests
{
	public static function suite()
	{
		$suite = new PHPUnit_Framework_TestSuite('ComplexPie Atom 1.0');

		$suite->addTestSuite('FeedTest');

		return $suite;
	}
}

?>