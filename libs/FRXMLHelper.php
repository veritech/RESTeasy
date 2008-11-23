<?php

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
	
	function output( $out ){
		return $out;
	}

	function header(){
		return $this->output( $this->declaration );
	}
	
	function element($name, $attributes = null, $content ){
		
		$out = array();
		
		if( is_array($attributes) ){
			
			foreach( $attributes as $k=>$v ){
				$attributeArr[] = sprintf('%s="%s"', $k, $v );
			}
			
			$name .= ' ' . implode(' ', $attributeArr );
		}
		
		$out[] = sprintf('<%s>',$name);
		$out[] = $this->clean($content);
		$out[] = sprintf('</%s>',$name);
		
		return $this->output( implode('',$out) );
	}
	

}

?>