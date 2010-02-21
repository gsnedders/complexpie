<?php

require_once 'PHPUnit/Framework.php';
require_once 'FeedTests.php';
require_once 'Content/AllTests.php';

class Atom10_AllTests
{
	public static function suite()
	{
		$suite = new PHPUnit_Framework_TestSuite('ComplexPie Atom 1.0');

        $suite->addTest(Atom10_FeedTests::suite());
        $suite->addTest(Atom10_Content_AllTests::suite());

		return $suite;
	}
}

?>