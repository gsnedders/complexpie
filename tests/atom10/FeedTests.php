<?php

require_once 'PHPUnit/Framework.php';
require_once 'FeedRightsTest.php';
require_once 'FeedSubtitleTest.php';
require_once 'FeedTitleTest.php';

class Atom10_FeedTests
{
	public static function suite()
	{
		$suite = new PHPUnit_Framework_TestSuite('ComplexPie Atom 1.0 Feed');

		$suite->addTestSuite('FeedRightsTest');
		$suite->addTestSuite('FeedSubtitleTest');
		$suite->addTestSuite('FeedTitleTest');

		return $suite;
	}
}

?>