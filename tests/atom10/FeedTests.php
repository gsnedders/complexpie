<?php

require_once 'PHPUnit/Framework.php';
require_once 'FeedRightsTest.php';
require_once 'FeedSubtitleTest.php';
require_once 'FeedTitleTest.php';
require_once 'FeedUpdatedTest.php';

class Atom10_FeedTests
{
	public static function suite()
	{
		$suite = new PHPUnit_Framework_TestSuite('ComplexPie Atom 1.0 Feed');

		$suite->addTestSuite('FeedRightsTest');
		$suite->addTestSuite('FeedSubtitleTest');
		$suite->addTestSuite('FeedTitleTest');
		$suite->addTestSuite('FeedUpdatedTest');

		return $suite;
	}
}

?>