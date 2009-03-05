<?php
	
class UserModel extends FRModel{
	
	function UserModel(){
		parent::FRModel();
		
		$this->tableName = 'Users';
		
	}
}

?>