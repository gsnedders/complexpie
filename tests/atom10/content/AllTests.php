<?php

require_once 'PHPUnit/Framework.php';

require_once 'CategoryTest.php';
require_once 'LinkTest.php';
require_once 'PersonTest.php';

class Atom10_Content_AllTests
{
	public static function suite()
	{
		$suite = new PHPUnit_Framework_TestSuite('ComplexPie Atom 1.0 Content');

		$suite->addTestSuite('ContentCategoryTest');
		$suite->addTestSuite('ContentLinkTest');
		$suite->addTestSuite('ContentPersonTest');

		return $suite;
	}
}

?>