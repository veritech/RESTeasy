<?php

	//Testing frameowrk
	require_once('../simpletest/autorun.php');

	//Classes
	require_once('../libs/classListing.php');

	class FRXMLElementTest extends UnitTestCase{
		
		//Store the singleton
		var $e;
		var $patterns = array(
			'tag'=>'^\<[A-z]\>$',
			''
			);
		
		function getElement(){
			
			if( $this->e === null ){
				$this->e = new FRXMLElement('foo');
			}
			
			return $this->e;
		}
		
		function testElementContent(){
			
			$e = $this->getElement();
			
			$e->setContent('Hello World');
			
			$this->assertEqual($e->content(),'Hello World');
			
			$e->setContent('Bar');
			
			$this->assertEqual($e->content(),'Bar');
			
		}
		
		function testSoloChild(){
			
			$e = $this->getElement();
			
			$childA = new FRXMLElement('barA');
			
			$e->addChild($childA);
			
			$this->assertEqual( $e->childrenCount(), 1 );
			
			$this->assertTrue( $e->hasChildren );
			
			$e->removeChild('barA');
			
			$this->assertEqual( $e->childrenCount(), 0 );
			
			$this->assertFalse( $e->hasChildren );
			
		}
		
		function testMultipleChildren(){
			
			$e = $this->getElement();
			
			$child[] = new FRXMLElement('barA','foo');
			$child[] = new FRXMLElement('barB','foo');
			$child[] = new FRXMLElement('barC','foo');
			$child[] = new FRXMLElement('barC','foo');
			$child[] = new FRXMLElement('barD','foo');
			
			foreach( $child as $c ){
				$e->addChild($c);
			}
			
			$this->assertEqual($e->childrenCount(), 5);
			
			$this->assertEqual($e->removeChildren('barC'),2);
			
			$this->assertEqual($e->childrenCount(), 3);
			
		}
		
		function testSerialize(){
			$e = new FRXMLElement('foo');
			
			$e->setContent('bar');
			
			$this->assertEqual($e->serialize(),'<foo>bar</foo>');
				
			//Add a sub element and re-test
			
			$e->addChild( new FRXMLElement('bar','foobar') );
			
			$this->assertEqual($e->serialize(), '<foo><bar>foobar</bar></foo>');
		}
		
		function testBadInput(){
			$e = new FRXMLElement('foo','this&that');
			
			$this->assertEqual($e->serialize(),'<foo>this&amp;that</foo>');
		}
	}

?>