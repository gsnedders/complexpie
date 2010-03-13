<?php

require_once 'PHPUnit/Framework.php';

require_once 'FeedEntryAuthorTest.php';
require_once 'FeedEntryContributorTest.php';
require_once 'FeedEntryTitleTest.php';

class Atom10_FeedEntryTests
{
	public static function suite()
	{
		$suite = new PHPUnit_Framework_TestSuite('ComplexPie Atom 1.0 Feed Entry');

		$suite->addTestSuite('Atom10_FeedEntryAuthorTest');
		$suite->addTestSuite('Atom10_FeedEntryContributorTest');
		$suite->addTestSuite('Atom10_FeedEntryTitleTest');

		return $suite;
	}
}

?>