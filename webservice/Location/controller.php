<?php
/*
	Location Controller
*/
class LocationController extends FRController{
	
	function LocationController(){

		//Create model instances
		$this->models['Location'] = new LocationModel();
		
		//instantiate the parent, it automatically echos, so it must be placed last
		parent::FRRestServer();

	}
	
	/*
		Override the Default GET method
	*/
	function GET(){
		
		//print_r( $models );
		$data = $this->models['Location']->findAll();
		
		//$this->returnXML = false;
		
		$xml = new XMLAuthor();

		$xml->push("Locations");
		
		foreach( $data as $row ){
			$xml->push('Location');
			//print_r($row);
			$xml->element('id',$row['id']);
			$xml->element('country_id', $row['country_id']);
			$xml->element('region_id', $row['region_id']);
			$xml->element('description',$row['description']);
			$xml->pop();
		}
		
		$xml->pop();
		
		return $xml->getXml();
	}

	
}
?>