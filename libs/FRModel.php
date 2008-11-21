<?php
/*
 	Parent Model Object
 	Follows the active record pattern

	$foo = new bar()
	
	$foo->a = bar
	$foo->b = foo
	
	$foo->save( tableName )
	
	

*/

//Takes advantage of the ADODB library
require_once('../adodb/adodb.inc.php');

class FRModel extends FRObject{
	var $tableName
	// Save data to the database
	function save( $tableName=null ){
		$this->init();
		
		$class_vars = get_object_vars( $this );
		
		
		//build query
		foreach( $class_vars as $key=>$val ){
			echo $key . ' ' . $val .'<br />';
		}
		
		return false;
	}
}


$bar = new FRModel();
$bar->a = '1';
$bar->b = '2';
$bar->save();

?>