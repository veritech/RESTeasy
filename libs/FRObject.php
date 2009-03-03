<?php
	/*
		Jonathan Dalrymple
	*/
class FRObject{
	
	function checkAndReplace( $check, $replace ){
		
		if( !isset($check) ){
			return $replace;
		}else{
			return $check;
		}
		
	}
	
	
	function checkArrayAndReplace( $check, &$arr, $replace ){
		
		if( array_key_exists($check, $arr) ){
			return $arr[$check];
		}
		else{
			return $replace;
		}
		
	}
	
	function CAR( $check, &$arr, $replace ){
		
		return checkArrayAndReplace( $check, &$arr, $replace );
	}
	
	function debug( &$obj, $title=null ){
		
		/*
		print '<div>';
		if( isset($title) ){
			print '<h2>'.$title.'</h2>';
		}
		print_r( $obj );
		print '</div>';
		*/
	}

}

?>