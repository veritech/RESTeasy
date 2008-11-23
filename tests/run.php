<?php	
	//Testing frameowrk
	require_once('../simpletest/autorun.php');
	
	
	class AllTests extends TestSuite{
		function AllTests(){
			$this->TestSuite('All Tests');
			$this->addTestFile('FRModel_test.php');
			$this->addTestFile('FRXMLHelper_test.php');
			//$this->run();
		}
	}	
?>