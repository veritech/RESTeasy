<?php
/*
* Jonathan Dalrymple
* 
* Syntax/API Sugar, ummm tasty
*/
require_once('XPath.class.php');

class FRRestClient extends FRObject{
	
	
	var $conn;
	
	var $uri;
	
	//CRUD methods
	function FRRestClient( $uri ){
		$this->conn = new FRHTTP($uri);
	}

	//*********************************************//
	//		Processor Functions
	//*********************************************//
	/*
	* Processor Functions, can be overridden in a subclass to return custom results
	* 
	* By default they return the passed XPath object unchanged
	* 
	* They shouldn't be called directly, in an ideal world they should be protected functions
	*/
	function createResultProcessor(&$xml){
		return $xml;
	}
	
	function readResultProcessor(&$xml){
		return $xml;
	}
	
	function updateResultProcessor(&$xml){
		return $xml;
	}
	
	function deleteResultProcessor(&$xml){
		return $xml;
	}
	
	//*********************************************//
	//		Private functions
	//*********************************************//
	/*
	* 
	*/
	function _parse( &$xmlString ){
		
		$xmlOptions = array(XML_OPTION_CASE_FOLDING => FALSE, XML_OPTION_SKIP_WHITE => FALSE);
	  
		//Parse it
		$xPathObj =& new XPath(FALSE, $xmlOptions);
		
		//Load the XML
		if( !$xPathObj->importFromString( $xmlString ) ){
			print( $xPathObj->getLastError() );
		}
		
		
		return $xPathObj;
	}
	
	//*********************************************//
	//		CRUD Methods
	//*********************************************//
	
	/*
	* Create Method maps directly to the PUT method
	* 
	*/
	function create( $args = null ){	
		$xml = null;
		
		$response = $this->conn->PUT($args);
		
		$this->debug($response,'FRRestClient->Create');
		
		if( $response['content_type'] == 'text/xml;' ){
			
			$xml = $this->_parse( $response['data'] );
			
		}
		
		return $this->createResultProcessor( $xml );
	}
	
	/*
	* Read method maps directly to the PUT
	*/
	function read( $args = null ){
		$xml = null;
		
		//Get Response
		$response = $this->conn->GET($args);
		
		//Check if it's XML
		if( $response['content_type'] == 'text/xml;' ){
			
			$xml = $this->_parse( $response['data'] );

		}
		
		return $this->readResultProcessor( $xml );
	}
	
	/*
	* update method maps directly to the POST
	*/
	function update( $args = null ){
		$xml = null;
		
		$response = $this->conn->POST($args);
		
		if( $response['content_type'] == 'text/xml;' ){
			
			$xml = $this->_parse( $response['data'] );

		}
		
		return $this->updateResultProcessor( $xml );
	}
	
	/*
	* delete method maps directly to the Delete
	*/
	function delete( $args = null ){
		$xml = null;
		
		$response = $this->conn->DELETE($args);
		
		if( $response['content_type'] == 'text/xml;' ){
			
			$xml = $this->_parse( $response['data'] );

		}
		
		return $this->deleteResultProcessor( $xml );
	}

}

?>