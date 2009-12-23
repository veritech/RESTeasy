<?php
	require_once('inc/article/articleClient.php');
	require_once('inc/location/locationClient.php');
	
	$articles = new ArticleClient();
	$locations = new LocationClient();
	
	if( array_key_exists('id', $_GET) ){
		
		$location = $locations->getDescription( $_GET['id'] );
		
		$data = $articles->read( array('id'=>$_GET['id'] ) );
	}
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<!-- CSS -->
		<link rel="stylesheet" href="css/yui.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<link rel="stylesheet" href="css/thickbox.css" type="text/css" media="screen" title="no title" charset="utf-8">
		
		<!-- Javascript sources -->
		<script src="js/jquery-1.3.2.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/main.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/thickbox-compressed.js" type="text/javascript" charset="utf-8"></script>
		
		<title>Points of Interest</title>
	</head>
	<body>
		<div id="doc3">
		   <div id="hd" class="panel">
		   		<a href="index.php">Points of interest</a> > Article Search Results
		   </div> 
		   <div id="bd">
				<div id="searchBar" class="panel">
					<h2>Articles for <?php print $location?></h2>
				</div>
		   		<div id="mainPanel" class="panel">
					<?php

						foreach( $data as $article ){
							
							print '<h2>'.$article['title'].'</h2>';
							print '<p>' . str_replace( chr(10), '<br />', $article['body']) .'</p>';
						}

					?>
				</div>
		   </div> 
		   <div id="ft" class="panel">
		   		Points of Interest 2008
		   </div> 
		</div>
	</body>
</html>

