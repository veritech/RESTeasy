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
	
	//Create
	function PUT(){
		
		$requiredAttributes = array(
			''
			);
		
		$passedAttributes = $this->get_put_vars();
		
		$this->models['Location']->save( $passedAttributes );
		
		$xml = new XMLAuthor();
		
		$xml->push('Location');
		
		foreach( $passedAttributes  as $k=>$v ){
			
			$xml->element($k,$v);
			
		}
		
		$xml->pop();
		
		return $xml->getXML();
		
	}
	
	//Update
	function POST(){
/*
		$requiredAttributes = array(
			'id'
			);
*/
			
		if( array_key_exists('id',$_POST) ){
			
			//Set the id to make the model update rather than insert
			$this->models['Location']->ID = $_POST['id'];
			$this->models['Location']->save( $_POST );
			
			$xml = new XMLAuthor();
			
			$xml->push('Location');
			
			foreach( $_POST as $k=>$v ){
				$xml->element( $k, $v );
			}
			
			$xml->pop();
			
			return $xml->getXML();
		}
		else{
			return FRHTTPError::err400( null, 'Invalid Arguments');
		}
	}
	
	function DELETE(){
		
		$id = $_GET['id'];
		
		$this->models['location']->del( $id );
	}
	
}
?>