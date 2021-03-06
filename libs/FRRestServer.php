<?php
	/*
		Jonathan Dalrymple
	*/

define('FR_GET_REQUEST','GET');
define('FR_POST_REQUEST','POST');
define('FR_PUT_REQUEST','PUT');
define('FR_DELETE_REQUEST','DELETE');

class FRRestServer extends FRObject{
	
	var $returnXML = true;
	
	function FRRestServer(){
		//Determine Request type
		switch( $_SERVER['REQUEST_METHOD'] ){
			
			case FR_GET_REQUEST:
				$this->output( $this->GET() );
				break;
			case FR_POST_REQUEST:
				$this->output( $this->POST() );
				break;
			case FR_PUT_REQUEST:
				$this->output( $this->PUT() );
				break;
			case FR_DELETE_REQUEST:
				$this->output( $this->DELETE() );
				break;
			default:
				//bad request
				break;
		}
		
	}
	
	function get_put_vars(){
		$retVal = array();
		
		parse_str(file_get_contents("php://input"),$retVal);
		
		$this->debug($retVal,'FRRestServer->get_put_vars');
		
		return $retVal;
	}
	
	
	//This methods can be overridden by a subclass to achieve custom functionallity
	function GET(){
		
		$retVal = new FRXMLElement('response','GET');
		
		return $retVal->serialize();
	}
	
	function POST(){
		$retVal = new FRXMLElement('response','POST');
		
		return $retVal->serialize();
	}
	
	function PUT(){
		$retVal = new FRXMLElement('response','PUT');
		
		return $retVal->serialize();
	}
	
	function DELETE(){
		$retVal = new FRXMLElement('response','DELETE');
		
		return $retVal->serialize();
	}
	
	//Filter all page output through a function
	function output( $in ){
		if( $this->returnXML ){
			header('Content-Type: text/xml;');
		}

		//print FRXMLHelper::header();
		print $in;
	}
}

?>