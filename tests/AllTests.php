<?php

require_once 'PHPUnit/Framework.php';
require_once 'oldtests.php';
require_once 'IRITest.php';
require_once 'NetIPv6Test.php';

class AllTests
{
	public static function suite()
	{
		$suite = new PHPUnit_Framework_TestSuite('PHPUnit');

		$suite->addTestSuite('OldTest');
		$suite->addTestSuite('IRITest');
		$suite->addTestSuite('NetIPv6Test');

		return $suite;
	}
}

?>