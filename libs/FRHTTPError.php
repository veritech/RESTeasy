<?php
	/*
		Jonathan Dalrymple
	*/
	
	class FRHTTPError extends FRObject{
				
		//Bad Request
		function err400(){
			header("HTTP/1.0 400 Bad Request");
		}
		
		//Unathorized
		function err401(){
			header("HTTP/1.0 Unathorized");
		}
		
		//Forbidden
		function err403(){
			header("HTTP/1.0 Forbidden");
		}
		
		//Not Found
		function err404(){
			header("HTTP/1.0 Not Found");
		}
		
		//Method not Allowed
		function err405(){
			header("HTTP/1.0 Method Not Allowed");
		}
	}

?>