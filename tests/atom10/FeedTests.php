<?php

require_once 'PHPUnit/Framework.php';

require_once 'FeedAuthorTest.php';
require_once 'FeedCategoryTest.php';
require_once 'FeedContributorTest.php';
require_once 'FeedIdTest.php';
require_once 'FeedRightsTest.php';
require_once 'FeedSubtitleTest.php';
require_once 'FeedTitleTest.php';
require_once 'FeedUpdatedTest.php';

class Atom10_FeedTests
{
	public static function suite()
	{
		$suite = new PHPUnit_Framework_TestSuite('ComplexPie Atom 1.0 Feed');

		$suite->addTestSuite('FeedAuthorTest');
		$suite->addTestSuite('FeedCategoryTest');
		$suite->addTestSuite('FeedContributorTest');
		$suite->addTestSuite('FeedIdTest');
		$suite->addTestSuite('FeedRightsTest');
		$suite->addTestSuite('FeedSubtitleTest');
		$suite->addTestSuite('FeedTitleTest');
		$suite->addTestSuite('FeedUpdatedTest');

		return $suite;
	}
}

?>