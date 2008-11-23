<?php
/*
	FRModel
	
	Mirrors the functionallity provided by CakePHP's ORM layer
	
*/

//Takes advantage of the ADODB library
require_once('../adodb/adodb.inc.php');

define('FR_UPDATE','UPDATE %s SET(%s) WHERE %s');
define('FR_INSERT','INSERT INTO %s (%s) VALUES (%s)');
define('FR_SELECT','SELECT %s FROM %s %s');
define('FR_DELETE','DELETE FROM %s %s');


class FRModel extends FRObject{
	
	//SQL table name
	var $tableName;
	
	//Primary Key
	var $ID;
	
	//The name of the PK field
	var $PK = 'id';
	
	//The DB
	var $DB;
	
	//Constructor
	function FRModel(){
		
		//Setup the connection
		$this->DB = &ADONewConnection('mysql');
		 
		$this->DB->PConnect('127.0.0.1:8889','root','root','caketart');

	}
	
	//Pass the values though this formatter
	function _formatValue( $val ){
		
		if( is_string($val) ){
			$val = "'$val'"; 
		}
		
		return $val;
	}
	
	function _formatFields( $input = null ){

		if( is_array( $input) ){
			return implode(',', $arr[FR_FIELDS] );
		}
		elseif( is_string( $input) ){
			return $input;
		}
		elseif( $input === null ){
			return '*';
		}
	}
	
	function _formatConditions( $input ){
		if( is_array( $input) ){
			$retVal =  implode(',', $arr[FR_FIELDS] );
		}
		elseif( is_string( $input) ){
			$retVal = $input;
		}
		elseif( $input === null ){
			return '';
		}
		
		return 'WHERE '. $retVal;
	}
	
	function _formatOrder( $input ){
		return '';
	}
	
	function _formatLimit( $input ){
		return '';
	}
	
	//
	function _formatResult( &$arr ){
		return $arr;
	}
	
	
	// Public Methods
	function beforeFind( &$params ){
		
		return $params;
	}
	
	function query( $query ){

		$rst = &$this->DB->Execute( $query );
		$retVal = array();

		if( $rst !== false){
			//print $rst;
			while( $row = $rst->FetchRow() ){
				$retVal[] = $row;
			}
			
			$this->debug(count($retVal));
			
			return $retVal;
			
		}
		else{

			return false;
		}


	}
	
	function findAll( $params = array('fields'=>null,'conditions'=>null ) ){
		
		@$fields = $this->_formatFields( $params['fields']);
			
		@$conditions = $this->_formatConditions($params['conditions']);
	
		if( array_key_exists('order', $params) ){
			$conditions .= ' ORDER ' . $this->_formatOrder( $param['order'] );
		}
		if( array_key_exists('limit', $params) ){
			$conditions .= ' LIMIT ' . $params['limit'] ;
		}
		
		$query = sprintf(FR_SELECT,$fields, $this->tableName, $conditions );
		$this->debug( $query, 'Query');
		return $this->query( $query );
	}
	
	
	function find( &$params = null ){
		
		$params['limit'] = 1;
		//$this->beforeFind( $params );
		$retVal = &$this->findAll( $params );
		
		//Check if it's an array before accessing the indice
		if( is_array($retVal) && count($retVal) > 0 ){
			
			//print_r($retVal);
			return $retVal[0];
		}else{
			return $retVal;
		}
		
	}

	function read( $id ){
		
		$params['conditions'] = $this->PK.' = '.$id;
		
		return $this->find( $params );
		
	}

	// Save data to the database
	function save( $data ){

		//build query
		if( isset($this->ID) ){
			
			foreach( $data as $k=>$v ){

				$vals[] = "'$k'=" . $this->_formatValue($v);

			}
			
			$query = sprintf( FR_UPDATE, $this->tableName, implode(',',$vals), $this->PK.' = '.$this->ID );

		}else{
			
			foreach( $data as $k=>$v ){

				$keys[] = "'$k'";
				$vals[] = $this->_formatValue($v);

			}
			
			$query = sprintf( FR_INSERT, $this->tableName, implode(',',$keys),implode(',',$vals) );

		}
		$this->debug($query, 'Query');
		
		
		return $this->query( $query );
	}
	
	function del( $id ){
		
		$this->query( sprintf(FR_DELETE,$this->tableName, 'WHERE '.$this->PK.'='.$id) );
		
		return false;
	}
}


class User extends FRModel{
	var $tableName = 'cake_tags';
}

/*$user = new User();

$params['conditions'] = 'id > 7';

print 'read';
$user->read(7);
print 'find';
$user->find($params);
print 'findAll';
$user->findAll();
print 'save - insert';
$user->save( array('foo'=>'bar') );
$user->ID = 3;
print 'save - update';
$user->save(array('foo'=>'bar'));

$user->del(1);
$user->query('SELECT * FROM cake_users GROUP BY id');

*/
?>