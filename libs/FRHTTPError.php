<?php
	/*
		Jonathan Dalrymple
	*/
	
	class FRHTTPError extends FRObject{
		
		function errorResponse( $errCode = null, $errDescription = null ){
			
			$xml = new XMLAuthor();
			
			$xml->push('error');
			
			if( isset($errCode) ){
				$xml->element('code',$errCode);
			}
			
			if( isset($errDescription) ){
				$xml->element('description',$errDescription);
			}
			
			$xml->pop();
			
			return $xml->getXML(); 
			
		}
		
		//Bad Request
		function err400( $errCode = null, $errDescription = null ){
			header("HTTP/1.0 400 Bad Request");
			
			if( isset($errCode) || isset($errDescription) ){

				return FRHTTPError::errorResponse( $errCode, $errDescription );
			}
			
		}
		
		//Unathorized
		function err401(){
			header("HTTP/1.0 401 Unathorized");
		}
		
		//Forbidden
		function err403(){
			header("HTTP/1.0 403 Forbidden");
		}
		
		//Not Found
		function err404(){
			header("HTTP/1.0 404 Not Found");
		}
		
		//Method not Allowed
		function err405(){
			header("HTTP/1.0 405 Method Not Allowed");
		}
	}

?>