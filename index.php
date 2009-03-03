<?php
	require_once('libs/classListing.php');
	
	//echo 'EWT coursework';
	
	$xml = <<<EOT
<?xml version="1.0" encoding="UTF-8" ?>
<bar>
	<foo>
		<foobar>foobar</foobar>
	</foo>
	<foo>hello</foo>
	<foo>world</foo>
	<foo>world</foo>
</bar>
EOT;
	
	$foo = new FRXMLParser( $xml );
	
	//$foo->parse();
	
	$bar = new DOMDocument();
	
	$x = $bar->createElement('foo');
	
	echo $bar->saveXML();
?>