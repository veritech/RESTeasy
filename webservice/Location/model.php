<?php
/*
		Location Model
	
		* Divide into a seperate file ie Model.php
*/
	class LocationModel extends FRModel{
	
		function LocationModel(){
			parent::FRModel();
		
			$this->tableName = 'Locations';
		}
	}
?>