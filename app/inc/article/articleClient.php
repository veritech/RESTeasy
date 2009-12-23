<?php

require_once('../classlisting.php');

class ArticleClient extends FRRestClient{
	
	function ArticleClient(){
		parent::FRRestClient('http://localhost:8888/ewt/webservice/articles/');
	}
	
	
	//Process the results from the read function
	function readResultProcessor( $xml ){
		$retArr = array();
		
		$size = count( $xml->evaluate('/articles/article/title') );
		//print_r($xpathObj);
		
		for( $i=1; $i <= $size; $i++){
			array_push($retArr, array(
				'title' => $xml->getData("/articles/article[$i]/title"),
				'body' => $xml->getData("/articles/article[$i]/body")
				));
		}
		
		return $retArr;
	}

}

?>