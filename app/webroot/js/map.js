// JavaScript Document
/*function success(position) {
  var s = document.querySelector('#status');
  if (s.className == 'success') {
    // not sure why we're hitting this twice in FF, I think it's to do with a cached result coming back    
    return;
  }
  s.innerHTML = "found you!";
  s.className = 'success';
  
  var mapcanvas = document.createElement('div');
  mapcanvas.id = 'mapcanvas';
  mapcanvas.style.height = '200px';
  mapcanvas.style.width = '400px';
    
  document.querySelector('article').appendChild(mapcanvas);
  
  var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
  var myOptions = {
    zoom: 15,
    center: latlng,
    mapTypeControl: false,
    navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  var map = new google.maps.Map(document.getElementById("mapcanvas"), myOptions);
  
  var marker = new google.maps.Marker({
      position: latlng, 
      map: map, 
      title:"You are here!"
  });
}

function error(msg) {
  var s = document.querySelector('#status');
  s.innerHTML = typeof msg == 'string' ? msg : msg.code;
  s.className = 'fail';
  
  // console.log(arguments);
  
  
}*/


/*	
if (navigator.geolocation) {
	  navigator.geolocation.getCurrentPosition(success, error,{timeout:50000});
} else {
		 error('not supported');
}
*/


var initialLocation;
var siberia = new google.maps.LatLng(60, 105);
var newyork = new google.maps.LatLng(40.7468,-73.9935);
var browserSupportFlag =  new Boolean();
var map;
window.onload=function() {
	 var mapcanvas = document.createElement('div');
  		 mapcanvas.id = 'mapcanvas';
  		 mapcanvas.style.height = '400px';
  		 mapcanvas.style.width = '500px';
	 document.querySelector('article').appendChild(mapcanvas);
  
    

	 var myOptions = {
     	zoom: 15,
		center:newyork,
    	mapTypeId: google.maps.MapTypeId.ROADMAP
  	 };
  	map = new google.maps.Map(document.getElementById("mapcanvas"), myOptions);
  
  
  	if (geo_position_js.init()){
	
		var settings = {
				enableHighAccuracy: true
		};
		geo_position_js.getCurrentPosition(setPosition, handleError, settings);
	
	}
	else {
		alert('Geo not available');
	}
  
  // Try W3C Geolocation (Preferred)
  	/* if(navigator.geolocation) {
		browserSupportFlag = true;
		navigator.geolocation.getCurrentPosition(function(position) {
			initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
      		map.setCenter(initialLocation);
    	}, function() {
		    handleNoGeolocation(browserSupportFlag);
      });
  // Try Google Gears Geolocation
  	 } else if (google.gears) {
   		browserSupportFlag = true;
    	var geo = google.gears.factory.create('beta.geolocation');
    	geo.getCurrentPosition(function(position) {
      		initialLocation = new google.maps.LatLng(position.latitude,position.longitude);
      		map.setCenter(initialLocation);
    	}, function() {
      		handleNoGeoLocation(browserSupportFlag);
    	});
  // Browser doesn't support Geolocation
  	} else {
    	browserSupportFlag = false;
    	handleNoGeolocation(browserSupportFlag);
  	}*/
   }
   function handleError(error){
	   alert('Error = '+error.message);
   }
   function setPosition(position){
	
   	 var latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
	
	 var marker = new google.maps.Marker({
										 position: latLng,
										 map: map,
										 title: 'test'
										 
										 });
	map.setCenter(latLng);
		var eDiv=document.getElementById("status");
		eDiv.appendChild(document.createTextNode("Found you"));
		
alert(position.coords.latitude + " "+position.coords.longitude);
	 
   }
   
  function handleNoGeolocation(errorFlag) {
    if (errorFlag == true) {
      alert("Geolocation service failed.");
      initialLocation = newyork;
    } else {
      alert("Your browser doesn't support geolocation. We've placed you in Siberia.");
      initialLocation = siberia;
    }
    map.setCenter(initialLocation);
  }
  