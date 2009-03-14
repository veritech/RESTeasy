/*
	Jonathan Dalrymple
	Events class
*/
var Location = function(){
	
	this.url = "/ewt/webservice/location/";
	
	this.add = function( obj ){
		console.log('Location->Add');
		//Do request
		var xmlDoc = $.ajax({
			url: this.url,
			data: obj,
			type: "PUT",
			dataType:"xml",
			async: false
		}).responseXML;
		
	}
	
	this.search = function( query ){
		console.log('location->get');
		
		var retVal = new Array();
		var xmlDoc = $.ajax({
			url: this.url,
			data: "q="+query,
			type: "GET",
			dataType:"xml",
			async: false
		}).responseXML;
		
		//Parse XML
		$( xmlDoc ).find("location").each( function(){
			console.count("location");
			
			var location = $(this);
			
			retVal.push( {
				id: location.find('id').text(),
				latitude: location.find('latitude').text(),
				longitude: location.find('longitude').text(),
				zoomLevel: location.find('zoomLevel').text(),
				description: location.find("description").text()
			});
		})
		
		return retVal;
	}
	
	this.genMapUrl = function( location ){
		return "http://maps.google.co.uk/?ie=UTF8&ll="+ location.latitude +","+ location.longitude+"&t=m&z="+ location.zoomLevel;
	}
	
	this.genMapLink = function( locationObj ){
		
		return '<a href="'+ this.genMapUrl( locationObj )+ '&TB_iframe=true&height=480&width=640" class="thickbox" title="Map Viewer">View Map</a>';
		
	}
	
	//Shortened delete as safari treats it as a reserved keyword
	this.del = function(){
		console.log('Location->delete');
		
		var xmlDoc = $.ajax({
			url: this.url,
			data: obj,
			type: "DELETE",
			dataType:"xml",
			async: false
		}).responseXML;
		
		return false;
	}
}

//Setup event handlers
$( function(){
	
	$('form#location-search input.textbox').keyup( function(){
		var loc = new Location();
		
		//$('div#results').text( loc.search( this.value ) );
		results = loc.search( this.value );
		
		$('div#resultsPanel').empty();
		
		$('div#resultsPanel').append('<h2>'+ results.length +' results:</h2>');
		
		$.each( results, function( i, obj){

			$('div#resultsPanel').append('<div>' + (i+1) + '. <a href="articles.php?id='+ obj.id +'">'+ obj.description +'</a> | '+ loc.genMapLink( obj )+'</div>');
			
		});
		
		//Re init thickbox
		tb_init('div#resultsPanel a.thickbox');
	})
	
})