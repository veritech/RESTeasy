<?php

//Testing frameowrk
require_once('simpletest/autorun.php');

//Classes
require_once('../libs/classListing.php');

class FRModelTest extends UnitTestCase{

	var $_model;
	
	function getModel(){
		
		//Singleton
		if( !isset($this->_model) ){
			$this->_model = new FRModel();
			$this->_model->tableName = 'cake_tags';
		}
		
		return $this->_model;
		
	}
		
	function testFindAll(){
		
		$model = $this->getModel();

		$result = $model->findAll();
		
		$this->assertTrue( is_array($result) );
		$this->assertTrue( count($result) > 0 );
	}
	
	function testFind(){
		$model = $this->getModel();

		$result = $model->find();
		
		$this->assertTrue( is_array($result) );
		$this->assertFalse( count($result) == 1 );
	}
	
	function testFindAllWithParams(){
		
		$model = $this->getModel();
		
		$params = array(
			'conditions'=>'id > 10',
			'limit'=>10
			);
		
		$result = $model->findAll($params);
		
		$this->assertTrue( is_array($result) );
		$this->assertTrue( count($result) == 10);
		
		//Test with bad params, no records returned
		
		$params['conditions'] = 'id > 270';
		$result = $model->findAll( $params );

		$this->assertTrue( is_array($result) );
		$this->assertTrue( count($result) == 0 );
		
	}
	
	function testRead(){
		$model = $this->getModel();

		$result = $model->read(8);
		
		$this->assertTrue( is_array($result) );
		
		$this->assertFalse( count($result) == 1 );
		
		
		//Test bad input
		
		$result = $model->read(65535);
		
		$this->assertTrue( is_array($result) );
		
		$this->assertTrue( count($result) < 1 );
	}
	
	function testSave(){
		$model = $this->getModel();
		
		$result = $model->save( array('username'=>'jonathan') );
		
		$this->assertTrue( $result );
	}
}

?>