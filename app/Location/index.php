<?php
	require_once('../../classListing.php');
	
	/*
		Location Model
		
		* Divide into a seperate file ie Model.php
	*/
	class LocationModel extends FRModel{
		
		function LocationModel(){
			parent::FRModel();
			
			$this->tableName = 'Locations';
		}
	}
	
	/*
		Location Controller
	*/
	class LocationController extends FRRestServer{
		
		var $models = array();
		
		function LocationController(){

			//Create model instances
			$this->models['Location'] = new LocationModel();
			
			//instantiate the parent, it automatically echos, so it must be placed last
			parent::FRRestServer();

		}
		
		function GET(){
			
			//print_r( $models );
			$this->models['Location']->findAll();
			
			$retVal = new FRXMLElement('response','Hey');

			return $retVal->serialize();
		}
		
		
	}
	
	$server = new LocationController();
?>