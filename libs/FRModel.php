<?php
/*
	FRModel
	
	Mirrors the functionallity provided by CakePHP's ORM layer
	
	* Jonathan Dalrymple
*/

define('FR_UPDATE','UPDATE %s SET %s WHERE %s');
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
		 
		$this->DB->PConnect('127.0.0.1:8889','root','root','EWT');
		
		//Set the fetch mode
		$this->DB->setFetchMode(ADODB_FETCH_ASSOC);
	}
	
	//Pass the values though this formatter
	function _formatValue( $val ){
		
		if( is_string($val) ){
			return "'$val'"; 
		}
		elseif( is_numeric($val) ){
			return $val;
		}
		elseif( is_array($val) ){
			
			return implode(',',$val);
			
		}
	}
	
	function _formatFields( $input = null ){
		
		echo $input;
		if( is_array( $input) ){
			return implode(',', $input );
		}
		elseif( is_string( $input) ){
			return $input;
		}
		else{
			return '*';
		}
	}
	
	function _formatConditions( $input ){
	
		if( is_array( $input) ){
			$retVal =  implode(',', $input );
		}
		elseif( is_string( $input) ){
			$retVal = $input;
		}
		else{
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
			
			//$this->debug(count($retVal));
			
			return $retVal;
			
		}
		else{

			return false;
		}


	}
	
	/*
	* findAll
	* 
	* Find all records that match the given the critera
	* 
	* @param array params associatative array containing two indexs fields, conditions
	* @return Mixed If sucessful returns Associative array containing the result set, returns false is query failed
	*/
	function findAll( $params = array() ){
		
		$conditions = '';
		
		if( array_key_exists('fields',$params) ){
			$fields = $this->_formatFields( $params['fields']);
		}
		else{
			$fields = $this->_formatFields();
		}
		
		if( array_key_exists('conditions',$params) ){
			$conditions = $this->_formatConditions($params['conditions']);
		}
	
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
	
	/*
	* find
	* 
	* Gets the first result from the 
	* 
	* @param array params associatative array containing two indexs fields, conditions
	* @return Mixed If sucessful returns Associative array containing the result set, returns false is query failed
	*/
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

	/*
	*	Read
	* 	
	* 	@param
	*/
	function read( $id ){
		
		$params['conditions'] = $this->PK.' = '.$id;
		
		return $this->find( $params );
		
	}
	
	/*
	* Save
	* 
	* @param data An associative array containing with the following format, field=>value
	* 
	* @return True on success, and false on failure
	*/
	// Save data to the database
	function save( $data ){

		//build query
		if( isset($this->ID) ){
			
			//Remove the id from the set
			// if( array_key_exists('id',$data) ){
			// 	unset( $data['id'] );
			// }
			
			foreach( $data as $k=>$v ){

				$vals[] = "$k=" . $this->_formatValue($v);

			}
			
			$query = sprintf( FR_UPDATE, $this->tableName, implode(',',$vals), $this->PK.' = '.$this->ID );

		}else{
			
			$keys = array_keys($data);
			
			foreach( $data as $k=>$v ){

				$vals[] = $this->_formatValue($v);

			}
			
			$query = sprintf( FR_INSERT, $this->tableName, implode(',',$keys),implode(',',$vals) );

		}
		
		$this->debug($query, 'Query');
		
		$this->query( $query );
		
		//print 'Affected rows '. $this->DB->Affected_Rows();
		if( $this->DB->Affected_Rows() > 0 ){
			 
			return true;
		}else{
			return false;
		}
	}
	
	/*
	* Del
	* 
	* Delete a record in the database
	* 
	* @param id if its a numeric delete the id
	*/
	function del( $id ){
		
		if( is_numeric($id) ){
			$this->query( sprintf(FR_DELETE,$this->tableName, 'WHERE '.$this->PK.'='.$id) );
		}
		// elseif( is_string($id) ){
		// 	$this->query( sprintf(FR_DELETE,$this->tableName, 'WHERE '.$id) );
		// }
		
		
		if( $this->DB->Affected_Rows() > 0 ){
			return true;
		}else{
			return false;
		}
	}
}

?>