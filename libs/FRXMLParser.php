<?php
	/*
		Jonathan Dalrymple
	*/
	class FRXMLParser extends FRObject{
		
		var $parser;
		var $xml;
		
		//The rootElement
		var $rootElement;
		
		var $depth = array();
		
		var $currentTag;
		
		var $currentParent;
		
		var $tagData;
		
		var $foundRoot = false;
		
		function FRXMLParser( $xml ){
			
			$this->xml = $xml;
			$this->parser = xml_parser_create();
			
			xml_set_object($this->parser, $this);
			xml_set_element_handler($this->parser,'openTag','closeTag');
			xml_set_character_data_handler($this->parser, 'tagContents');
			
		}
		
		/* Gets the singleton root element */
		function getRoot(){
			
			if( !isset($this->rootElement) ){
				$this->rootElement = new FRXMLElement();
			}
			
			return $this->rootElement;
			
		}
		
		function openTag( $handle, $name, $attributes){
			
			//Get the root
			$root = $this->getRoot();

			//Assign the root some details
			if(!$this->foundRoot){
				$this->foundRoot = true;
				$root->setName($name);
			}
			
			//Note the element as open
			$this->depth[$name] = true;
			//$this->currentParent = $name;
		}
		
		function tagContents($handle,$data ){
			$this->tagData = $data;
		}
		
		function closeTag( $handle, $name ){
			$root = $this->getRoot();
			
			$thatElement = new FRXMLElement($name);
			$thatElement->setContent($this->tagData);
			//print $thatElement->content();
			// print $thatElement->name() . "\r\n";
			$index = 0;
			
			//Discover the parent
			$elements = array_keys($this->depth);
			
			if( ($index = array_search($name,$elements)) !== false ){
				//parent
				
				if( array_key_exists($index-1,$elements) ){
					$parent = $elements[($index-1)];
				}else{
					$parent = $root->name();
				}
			}
			
			//print $parent;
			if( $index == 1 ){
				$root->addChild( $thatElement );
				//print $index .'<br />';
			}else{
				//Find the parent
				
				//The issue here is that it will find the first child, not the child that this element belongs to.
				$parentObj = &$root->findChild($parent);
				//print $index .'<br />';
				if($parentObj != null ){
					$parentObj->addChild($thatElement);
				}
			}

			//Note the element as closed
			$this->depth[$name] = false;
	
		}
		
		
		function parse(){
			
			xml_parse($this->parser, $this->xml );
			
			// print_r( $this->depth );
			print $this->rootElement->serialize("\r\n");
		}
		
	}
?>