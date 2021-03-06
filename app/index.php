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
		   		Points of interest
		   </div> 
		   <div id="bd">
				<div id="searchBar" class="panel">
					<form id="location-search">
						<label for="query">Search</label>
						<input class="textbox" name="query" type="text" value="" />
						<input type="submit" value="Search" />
					</form>
					<ul>
						<li><a href="inc/location/addform.php?width=250&height=250" class="thickbox" title="Add Location">Add a Location</a></li>
						<li><a href="inc/location/removeform.php?width=250&height=250" class="thickbox" title="Remove Location">Remove a Location</a></li>
					</ul>
				</div>
		   		<div id="mainPanel">
					<!-- would like to place a map here -->
				</div>
				<div id="resultsPanel" class="panel">
				</div>
		   </div> 
		   <div id="ft" class="panel">
		   		Points of Interest 2008
		   </div> 
		</div>
	</body>
</html>
