<?php

	//TODO
	// How does the class deal with text only elements?

	class FRXMLElement extends FRObject{

		var $entities = array('"','&','\'','<','>');
		
		var $replacements = array('&quot;','&amp;','&apos;','&lt;','&gt;');
		
		var $c = array();
		
		//Integer indexed array
		var $children = array();
		
		//The content of the element
		var $content;
		
		//Name of element
		var $name;
		
		//Attributes
		var $attributes = array();
		
		//Namespace
		var $namespace;
		
		//Does this element have children
		var $hasChildren = false;
		
		function FRXMLElement( $name, $content = null, $attributes = array(), $namespace = null ){
			$this->name = $name;
			
			if( isset($content) ){
				$this->content = $this->clean($content);
			}
			
			$this->attributes = $attributes;
			
			$this->namespace = $namespace;
		
		}
		
		/*	Namespace */
		function setNamespace( $str ){
			$this->namespace = $str;
			
			return true;
		}
		
		/*	Attributes */
		function addAttribute( $k, $v ){
			$this->attribute[$k] = $v;
			
			return true;
		}
		
		function removeAttribute($k){
			unset( $this->attribute[$k] );
			
			return true;
		}
		
		/*	Children */
		function addChild( &$obj ){

			$this->children[] = $obj;
			
			//We have a child ^_^
			$this->hasChildren = true;
			
			//So we have no content
			unset($this->content);
			
			return true; 
		}
		
		//Removes the first child
		function removeChild( $name ){
			
			foreach( $this->children as $index=>$obj){
				
				if( $name === $obj->name){
					unset( $this->children[$index] );
					
					//Have we got kids?
					if( count($this->children) < 1 ){
						$this->hasChildren = false;
					}
					
					return true;
				}
			}
			
			return false;
		}
		
		//Removes all the children with the matching name
		function removeChildren( $name ){
			
			$childrenFound = 0;
			
			foreach( $this->children as $index=>$obj){
				
				if( $name === $obj->name){
					unset( $this->children[$index] );
					$childrenFound++;
				}
			}
			
			//Have we got kids?
			if( count($this->children < 1) ){
				$this->hasChildren = false;
			}
			
			return $childrenFound;
		}
		
		//How many children have we got?
		function childrenCount(){
			return count($this->children);
		}
		
		/* Generics */
		//Whats our name
		function name(){
			return $this->name;
		}
		
		function content(){
			
			return $this->content;
		}
		
		function setContent( $str ){
			$this->content = $this->clean($str);
			
			$this->hasChildren = false;
		}
		
		//Our kids love serial ...
		function serialize( $lineEndings = null ){
			$retVal = array();
			
			
			//Attributes
			// sprintf('<%s>');
			// sprintf('<%s:%s>',$this->name );
			$retVal[] = sprintf('<%s>',$this->name);

			
			//textual content or children elements
			if( $this->hasChildren && !isset($this->content) ){
				foreach( $this->children as $index=>$obj ){
	
					$retVal[] = $obj->serialize();
				}
			}elseif( !$this->hasChildren && isset($this->content) ){
				
				$retVal[] = $this->content;
			}
			
			$retVal[] = sprintf('</%s>',$this->name);
			
			return implode($lineEndings, $retVal);
		}

		function clean( $input ){

			return str_replace( $this->entities, $this->replacements, $input );
		}
		
	}

?>