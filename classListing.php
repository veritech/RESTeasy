<?php
//Listing of all the classes in the system

//Takes advantage of the ADODB library
require_once('adodb/adodb.inc.php');

require_once('libs/FRObject.php');

require_once('libs/XmlAuthor.php');

//This classed have been depreciated, but are still required by FRRestServer
require_once('libs/FRXMLHelper.php');

require_once('libs/FRXMLElement.php');

require_once('libs/XPath.class.php');

//require_once('libs/FRXMLParser.php');

require_once('libs/FRHTTPError.php');

require_once('libs/FRModel.php');

require_once('libs/FRHTTP.php');

require_once('libs/FRRestClient.php');

require_once('libs/FRRestServer.php');

require_once('libs/FRController.php');

?>