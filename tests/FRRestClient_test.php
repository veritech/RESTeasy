<?php
/*
* Jonathan Dalrymple
* FRRestClient Test
*/

require_once('../classListing.php');
require_once('simpletest/autorun.php');

class FRRestClientTest extends UnitTestCase{
	
	var $client;
	
	function setUp(){		
		$this->client = new FRRestClient('http://localhost:8888/ewt/webservice/Location/');
	}
	
	function tearDown(){
		
	}
	
	function testCreate(){
		$result = $this->client->create();
		
		$this->assertNotNull( $result );
	}
	
	function testRead(){
		$result = $this->client->read();
		
		$this->assertNotNull( $result );
	}
	
	function testUpdate(){
		
		$result = $this->client->update();
		
		$this->assertNotNull( $result );
		
	}
	
	function testDelete(){
		$result = $this->client->delete();
		
		$this->assertFalse( $result );
	}

}

?>