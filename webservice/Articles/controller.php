<?php

class ArticleController extends FRController{
	
	function ArticleController(){
		
		$this->models['Article'] = new ArticleModel();
		
		parent::FRRestServer();
	}
	
	function GET(){
		
		//$this->returnXML = false;
		
		//$this->models['Article']->debug = true;
		
		$xml = new XMLAuthor();
		
		if( array_key_exists('id',$_GET) ){
			$id = $_GET['id'];
		
			$result = $this->models['Article']->findAll(array(
				'conditions'=>"location_id = $id"
				));
		}else{
			$result = $this->models['Article']->findAll();
		}
		
		$xml->push('articles');
		
		foreach( $result as $row ){
			$xml->push('article');
			
			$xml->element('id', $row['id'] );
			$xml->element('location_id',$row['location_id']);
			$xml->element('title', $row['title']);
			$xml->element('body', $row['body'] );
			
			$xml->pop();
		}
		
		$xml->pop();
		
		return $xml->getXML();
	}
}

?>