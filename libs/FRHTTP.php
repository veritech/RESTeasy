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
			curl_setopt( $this->curl, CURLOPT_PORT, 8888 );
			
		}
		
		/*
		* Return CURL data with meta in an array
		*
		*/
		function output( &$content ){
			
			$retVal = curl_getinfo( $this->curl );
			
			$retVal['data'] = $content;
			
			$this->debug($retVal,'FRHTTP->output');
			
			return $retVal;
		}
		
		function arrayToFormEncodedString( $array ){
			
			$retVal = array();
			
			foreach( $array as $k=>$v ){
				$retVal[] = sprintf('%s=%s',$k, $v);
			}
			
			return implode('&',$retVal);
		}
		
		function GET($data=null){
			
			curl_setopt($this->curl, CURLOPT_HTTPGET, true );
			
			//
			if( is_array($data) ){
				
				//Get current url
				$info = curl_getinfo( $this->curl);
				
				$url = $info['url'];
				
				curl_setopt($this->curl, CURLOPT_URL, $url .'?'. $this->arrayToFormEncodedString( $data ) );
				
			}
			
			
			$retVal = curl_exec($this->curl);
			
			//curl_close($this->curl);
			
			return $this->output($retVal);
		}
		
		function POST($data = null){
			
			curl_setopt($this->curl, CURLOPT_POST, true );
			
			//if we get data as an array we break it down, as KVC
			if( is_array($data) ){

				curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->arrayToFormEncodedString( $data ));
				
			}
			elseif( is_string($data) ){
				curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data );
			}
			
			$retVal = curl_exec($this->curl);
			
			//Clean up
			//curl_close($this->curl);
			
			return $this->output($retVal);
		}
		
		function PUT($data = null){
			
			$this->debug($data,'FRHTTP->Put, Data');
			//The specified method for doing PUT's in php is to use a stream, however i wanted to avoid writing to disk,
			//I found the following advice
			//http://www.jaisenmathai.com/blog/2008/04/23/a-faster-way-to-d-curl-put-calls-in-php/
			curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'PUT' );
			curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->arrayToFormEncodedString($data) );
			
			$retVal = curl_exec($this->curl);
			
			//curl_close($this->curl);
			
			return $this->output($retVal);
		}
		
		function DELETE($data = null){
			curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'DELETE' );
			
			$retVal = curl_exec($this->curl);
			
			//curl_close($this->curl);
			
			return $this->output($retVal);
		}
		
	}
?>