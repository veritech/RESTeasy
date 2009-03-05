<?php

class UserController extends FRController{
	
	
	function UserController(){
		
		$this->models['User'] = new UserModel();
		
		$this->returnXML = true;
		
		parent::FRRestServer();
	}
	
	function GET(){
		
		$users = $this->models['User']->findAll();
		
		$xml = new XMLAuthor();
		
		$xml->push('Users');
		
		foreach( $users as $row ){
			$xml->push('User');
			
			$xml->element('id',$row['id']);
			$xml->element('username', $row['username'] );
			$xml->element('firstName', $row['firstName'] );
			
			$xml->pop();
		}
		
		$xml->pop();
		
		return $xml->getXML();
	}
	
	function PUT(){
		
		$requiredAttributes = array(
			'username',
			'firstName',
			'lastName'
			);
		
		$passedAttributes = $this->get_put_vars();
		
		//print_r( $passedAttributes );

		//If there is more than one item in the array
		if( $passedAttributes > 0 ){
			
			//Seach for the required attributes in the POST array
			/*
			foreach( $requiredAttributes as $key ){
				print 'key:'.$key . "\r\n";
				if( !array_key_exists($key, $passedAttributes ) ){
					print $key . "\r\n";
					//return FRHTTPError::err400(null,'Not all required attributes supplied');

				}
			}
			*/
			if( $this->models['User']->save( $passedAttributes ) != null ){
				$xml = new XMLAuthor();
				
				$xml->push('User');
				
				$xml->element('');
				
				$xml->pop();
				
				return $xml->getXML();
			}
			else{
				return 'error';
			}

		}
		else{
			
			return FRHTTPError::err400(null,'No Attributes supplied');

		}
	}
	
	function DELETE(){
		//Check if the array key exists
		if( !array_key_exists('id',$_GET) ){
			return FRHTTPError::err400( null, 'No ID supplied');
		}
		
		//Delete the record
		// TODO Add Error checking
		$this->models['User']->del( $_GET['id'] );
		
		$xml = new XMLAuthor();
		
		$xml->push('Status');
		$xml->element('description','Record Removed');
		$xml->pop();

	}
}

?>