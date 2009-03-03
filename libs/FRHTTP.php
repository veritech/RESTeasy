<?php
	/*
		Jonathan Dalrymple
	*/

	class FRHTTP extends FRObject{
		
		var $curl;
		
		function FRHTTP( $url = null){
			
			$this->curl = curl_init( $url );
			
			curl_setopt( $this->curl, CURLOPT_RETURNTRANSFER, true );
			
			//Temporary
			// curl_setopt( $this->curl, CURLOPT_PORT, 8888 );
			
		}
		
		function GET(){
			
			curl_setopt($this->curl, CURLOPT_HTTPGET, true );
			
			$retVal = curl_exec($this->curl);
			
			//curl_close($this->curl);
			
			return $retVal;
		}
		
		function POST($data){
			
			curl_setopt($this->curl, CURLOPT_POST, true );
			
			//if we get data as an array we break it down, as KVC
			if( is_array($data) ){
				
				foreach( $data as $k=>$v ){
					$formEncoded[] = sprintf('%s=%s',$k, $v);
				}
					
				curl_setopt($this->curl, CURLOPT_POSTFIELDS, implode('&',$formEncoded) );
				
				//Destroy
				unset($formEncoded);
			}
			else{
				curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data );
			}
			
			$retVal = curl_exec($this->curl);
			
			//Clean up
			//curl_close($this->curl);
			
			return $retVal;
		}
		
		function PUT($data){
			
			//The specified method for doing PUT's in php is to use a stream, however i wanted to avoid writing to disk,
			//I found the following advice
			//http://www.jaisenmathai.com/blog/2008/04/23/a-faster-way-to-d-curl-put-calls-in-php/
			curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'PUT' );
			curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data );
			
			$retVal = curl_exec($this->curl);
			
			//curl_close($this->curl);
			
			return $retVal;
		}
		
		function DELETE(){
			curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'DELETE' );
			
			$retVal = curl_exec($this->curl);
			
			//curl_close($this->curl);
			
			return $retVal;
		}
		
	}
?>