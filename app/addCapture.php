<?php
	require_once('inc/location/locationClient.php');
	
	$locations = new LocationClient();
	//Process events
	
	$result = $locations->create( $_POST );
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title></title>
		<link rel="stylesheet" href="../../css/yui.css" type="text/css" media="screen" title="no title" charset="utf-8">
		<style>
			body{
				text-align:center;
			}
			h1{
				font-size: 182.1%;
				font-weight:bold;
				margin: 2em auto;
			}
		</style>
	</head>
	<body>
		<?php
			if( $result ):
		?>
		<a href="index.php"><h1>Location Added</h1></a>
		<?php
			else:
		?>
		<a href="index.php"><h1>An error occurred</h1></a>
		<?php
			endif;
		?>
	</body>
</html>
