<?php
/*
* Jonathan Dalrymple
* FRRestClient Test]
*/

require_once('../classListing.php');
require_once('simpletest/autorun.php');

class FRHTTPTest extends UnitTestCase{
	
	var $client;
	
	function setUp(){
		
		$this->client = new FRHTTP('http://localhost:8888/ewt/app/Location/');
	}
	
	function tearDown(){
		
	}
	
	function testGET(){
		
		$result = $this->client->GET();
		
		$this->assertEqual($result['http_code'],'200');
		
		$this->assertEqual($result['content_type'],'text/xml;');
		
	}
	
	function testPOST(){
		$result = $this->client->POST();
		
		$this->assertEqual($result['http_code'],'200');
	}
	
	function testPUT(){
		$result = $this->client->PUT();
		
		$this->assertEqual($result['http_code'],'200');
	}
	
	function testDELETE(){
		$result = $this->client->DELETE();
		
		$this->assertEqual($result['http_code'],'200');
	}
}

?>