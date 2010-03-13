<?php

require_once 'PHPUnit/Framework.php';

require_once 'FeedEntryAuthorTest.php';
require_once 'FeedEntryCategoryTest.php';
require_once 'FeedEntryContributorTest.php';
require_once 'FeedEntryIdTest.php';
require_once 'FeedEntryPublishedTest.php';
require_once 'FeedEntryRightsTest.php';
require_once 'FeedEntrySummaryTest.php';
require_once 'FeedEntryTitleTest.php';
require_once 'FeedEntryUpdatedTest.php';

class Atom10_FeedEntryTests
{
	public static function suite()
	{
		$suite = new PHPUnit_Framework_TestSuite('ComplexPie Atom 1.0 Feed Entry');

		$suite->addTestSuite('Atom10_FeedEntryAuthorTest');
		$suite->addTestSuite('Atom10_FeedEntryCategoryTest');
		$suite->addTestSuite('Atom10_FeedEntryContributorTest');
		$suite->addTestSuite('Atom10_FeedEntryIdTest');
		$suite->addTestSuite('Atom10_FeedEntryPublishedTest');
		$suite->addTestSuite('Atom10_FeedEntryRightsTest');
		$suite->addTestSuite('Atom10_FeedEntrySummaryTest');
		$suite->addTestSuite('Atom10_FeedEntryTitleTest');
		$suite->addTestSuite('Atom10_FeedEntryUpdatedTest');

		return $suite;
	}
}

?>