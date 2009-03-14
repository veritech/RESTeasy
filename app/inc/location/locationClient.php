<?php
	require_once('../classlisting.php');
	
	class locationClient extends FRRestClient{
		
		function locationClient(){
			parent::FRRestClient('http://localhost:8888/ewt/webservice/location/');
			
		}
		
		
		function createResultProcessor( $xml ){
			
			//$retArr = array();
			//print $xml->exportAsHTML();
			//$size = count($xml->evaluate(''));
			
			
			return true;
		}	
	
		/*
		* 	getDescription
		* 
		* 	Get the name of the location with the given id
		*/
		function getDescription( $id ){

			$xml = $this->read( array('id'=>$id) );

			if( isset($xml) ){
				return $xml->getData('/locations/location/description');
			}
			
			return '';
		}
		

		
	}
?>