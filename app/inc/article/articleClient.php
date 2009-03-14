<?php

require_once('../classlisting.php');

class ArticleClient extends FRRestClient{
	
	function ArticleClient(){
		parent::FRRestClient('http://localhost:8888/ewt/webservice/articles/');
	}
	
	/*
	*	
	*/
	function get( $id = null ){
		
		$retArr = array();
		//If the id is null
		if( isset($id) ){
			$xpathObj = $this->read( array('id'=>$id) );
		}
		else{
			$xpathObj = $this->read();
		}
		
		$size = count( $xpathObj->evaluate('/articles/article/title') );
		//print_r($xpathObj);
		
		for( $i=1; $i <= $size; $i++){
			array_push($retArr, array(
				'title' => $xpathObj->getData("/articles/article[$i]/title"),
				'body' => $xpathObj->getData("/articles/article[$i]/body")
				));
		}
			
		return $retArr;
	}
}

?>