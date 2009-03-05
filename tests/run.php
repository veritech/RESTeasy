<?php	
	//Testing frameowrk
	require_once( dirname(__FILE__).'/simpletest/autorun.php');
	
	
	class AllTests extends TestSuite{
		function AllTests(){
			$this->TestSuite('All Tests');
			$this->addTestFile('FRModel_test.php');
			$this->addTestFile('FRRestServer_test.php');
			$this->addTestFile('FRClientServer.php');
			//$this->addTestFile('FRXMLHelper_test.php');
			//$this->run();
		}
	}	
?>