// JavaScript Document
function success(position) {
  var s = document.querySelector('#status');
  alert('pre boo');
  if (s.className == 'success') {
    // not sure why we're hitting this twice in FF, I think it's to do with a cached result coming back    
    return;
  }
  alert("boo");
  s.innerHTML = "found you!";
  s.className = 'success';
  
  var mapcanvas = document.createElement('div');
  mapcanvas.id = 'mapcanvas';
  mapcanvas.style.height = '400px';
  mapcanvas.style.width = '560px';
    
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
}

if (navigator.geolocation) {
	alert("geo working");
  navigator.geolocation.getCurrentPosition(success, error,{timeout:50000});
/*navigator.geolocation.getCurrentPosition(function (position){
var lat = position.coords.latitude;
var lon = position.coords.longitude;

alert('Lat: '+ lat +' \nLon: '+ lon);
												   });*/


} else {
	  error('not supported');
}

