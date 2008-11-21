<?php
/*
 	Parent Model Object
 	Follows the active record pattern
	
	USAGE:
	
	$foo = new bar()
	
	$foo->a = bar
	$foo->b = foo
	
	$foo->save( [tableName] )
	
	-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
	if you do want to not hard code the table name on every save call,
	
	subclass FRModel, and assign the private attribute $tableName with the desired location

*/

//Takes advantage of the ADODB library
require_once('../adodb/adodb.inc.php');

define('FR_UPDATE',999);
define('FR_INSERT',0);

class FRModel extends FRObject{
	var $tableName;
	
	//Primary Key
	var $ID;
	
	//The name of the PK field
	var $PK = 'id';
	
	function find(  ){
		
	}
	
	//Pass the values though this formatter
	function formatValue( $val ){
		
		if( is_string($val) ){
			$val = "'$val'"; 
		}
		
		return $val;
	}
	
	// Save data to the database
	function save( $tableName = null ){
		
		
		//Set the table name, if it hasn't been passed
		if( !isset($tableName) ){
			$tableName = &$this->tableName;
		}
		
		//Get the object variables
		$obj_vars = get_object_vars( $this );
		
		//Build a list of reserved class vars 
		$reserved = array_keys( get_class_vars( get_class($this) ) );
		
		foreach( $reserved as $key ){
			
			if( array_key_exists($key,$obj_vars)  ){
				unset( $obj_vars[$key] );
			}
			
		}
		

		//build query
		if( isset($this->ID) ){
			$method = FR_UPDATE;
		}else{
			$method = FR_INSERT;
		}
		
		
		switch( $method ){

			case FR_UPDATE: //Update
			
				//format string
				foreach( $obj_vars as $field => $value ){
						
					$setOptions[] = sprintf('\'%s\'=%s',$field, $this->formatValue($value) );
				}
			
				$query = sprintf('UPDATE %s SET (%s) WHERE %s=%s', $tableName, implode(',', $setOptions), $this->PK, $this->ID );

				break;
			case FR_INSERT:
			default: //Insert
				
				
				foreach( $obj_vars as $field => $value ){

					$fields[] = "'$field'";
					$values[] = $this->formatValue($value);
				}

				$query = sprintf('INSERT INTO %s (%s) VALUES (%s)', $tableName, implode(',',$fields), implode(',',$values) );

				break;
		}
		
		print $query;
		
		return false;
	}
}


$bar = new FRModel();
//$bar->ID = 1;
$bar->a = 'bar';
$bar->b = 2;
$bar->save('foo');

?>