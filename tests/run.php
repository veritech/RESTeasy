<?php	
	//Testing frameowrk
	require_once( dirname(__FILE__).'/simpletest/autorun.php');
	
	//Tests
	require_once("FRHTTP_test.php");
	require_once("FRModel_test.php");
	require_once("FRRestClient_test.php");
	//require_once("FRRestServer_test.php");
	
	//Group Test
	$test = &new GroupTest('All Tests');
	
	//Add test cases
	$test->addTestCase( new FRHTTPTest() );
	$test->addTestCase( new FRModelTest() );
	$test->addTestCase( new FRRestClientTest() );
	//$test->addTestCase( new FRRestServer() );
	
	//Run test cases
	$test->run( new HTMLReporter() );
	
?>