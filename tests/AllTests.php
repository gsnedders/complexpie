<?php

require_once 'PHPUnit/Framework.php';
require_once 'oldtests.php';
require_once 'CacheArrayTest.php';
require_once 'ContentTest.php';
require_once 'DateTest.php';
require_once 'DOMIteratorTest.php';
require_once 'IRITest.php';
require_once 'NetIPv6Test.php';
require_once 'nodeToHTMLTest.php';

class AllTests
{
	public static function suite()
	{
		$suite = new PHPUnit_Framework_TestSuite('PHPUnit');

		$suite->addTestSuite('OldTest');
		$suite->addTestSuite('CacheArrayTest');
		$suite->addTestSuite('ContentTest');
		$suite->addTestSuite('DateTest');
		$suite->addTestSuite('DOMIteratorTest');
		$suite->addTestSuite('IRITest');
		$suite->addTestSuite('NetIPv6Test');
		$suite->addTestSuite('nodeToHTMLTest');

		return $suite;
	}
}

?>