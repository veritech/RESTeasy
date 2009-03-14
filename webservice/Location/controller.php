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
		
		//Search the text
		if( array_key_exists('q',$_GET) ){
			//'description LIKE \'%' + $_GET['q'] +'%\''
			$data = $this->models['Location']->findAll( array(
				'conditions'=> 'description LIKE \'%'.$_GET['q'].'%\''
				)
			);
			
			//$this->returnXML = false;
		}
		//Search by id
		elseif( array_key_exists('id', $_GET) ){
			$data = $this->models['Location']->findAll( array(
				'conditions'=> 'id ='.$_GET['id']
				)
			);
		}
		else{
			$data = $this->models['Location']->findAll();
		}
		
		$xml = new XMLAuthor();

		$xml->push("locations");
		
		if( count($data) > 0){
			$keys = array_keys($data[0]);
		}
		
		foreach( $data as $row ){
			$xml->push('location');
			//print_r($row);
			
			foreach( $keys as $k ){
				$xml->element($k, $row[$k]);
			}
			// $xml->element('id',$row['id']);
			// $xml->element('country_id', $row['country_id']);
			// $xml->element('region_id', $row['region_id']);
			// $xml->element('description',$row['description']);
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
		
		$this->debug( $passedAttributes, 'LocationController->PUT, passedAttributes');
		
		$this->models['Location']->save( $passedAttributes );
		
		$xml = new XMLAuthor();
		
		$xml->push('location');
		
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
			
			$xml->push('location');
			
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