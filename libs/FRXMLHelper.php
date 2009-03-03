<?php
	/*
		Jonathan Dalrymple
	*/
class FRXMLHelper extends FRObject{
	
	//XML entities by ASCII #
	var $entities = array('"','&','\'','<','>');
	var $replacements = array('&quot;','&amp;','&apos;','&lt;','&gt;');
	var $declaration = '<?xml version="1.0" encoding="UTF-8" ?>';

	function FRXMLHelper(){
		
	}
	
	function clean( $input ){
		
		return str_replace( $entities, $replacements, $input );
	}

	function header(){
		return '<?xml version="1.0" encoding="UTF-8" ?>';
	}

}

?>