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
		
		var queryObj = {q:query};
		
		var xmlDoc = $.ajax( function(){
			url: this.url,
			data: queryObj,
			type: "GET",
			dataType:"xml",
			async: false
		}).responseXML;
	}
	
	this.delete = function(){
		console.log('Location->delete');
		
		var xmlDoc = $.ajax( function(){
			url: this.url,
			data: obj,
			type: "DELETE",
			dataType:"xml",
			async: false
		}).responseXML;
	}
}

//Setup event handlers
$( function(){
	
	$('form#location-search input.textbox').keyup( function(){
		console.log('test');
	})
	
})