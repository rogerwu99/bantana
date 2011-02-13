<div style="margin-left:60px;"><h4> Local Real Time Deals - Sign up before you miss out!
</h4></div>
<div class="sidebar4" id="consumer" style="display:block">
<?php 
		echo $javascript->link('http://maps.google.com/maps/api/js?sensor=false');
     	echo $javascript->link('http://code.google.com/apis/gears/gears_init.js');
		echo $javascript->link('geo.js');
		echo $javascript->link('map.js');
		?>

<script>
var newyork = new google.maps.LatLng(40.7468,-73.9935);
var map;
var infowindow;
var gmarkers = []; 
var updateDiv;
var global_counter=0;
	
window.onload=function() {
	 var myOptions = {
     	zoom: 17,
		center:newyork,
    	mapTypeId: google.maps.MapTypeId.ROADMAP
  	 };
	 updateDiv = document.getElementById("right_col");
   	 map = new google.maps.Map(document.getElementById("mapcanvas"), myOptions);
     var marker = new google.maps.Marker({
										 position: newyork,
										 map: map,
										 title: 'test'
										 
										 });
	<?php $results = $this->requestAction(array('controller'=>'discounts','action'=>'demo')); ?>

<?php foreach ($results as $key=>$value){?>
	var myLatlng = new google.maps.LatLng(<?php echo $results[$key]['lat']; ?>,<?php echo $results[$key]['long']; ?>);
 	createMarker(myLatlng, '<?php echo $results[$key]['name']; ?>', '<?php echo $results[$key]['text']; ?>' );
<?php } ?>
	setTimeout(cycle,2000);
	


}
google.maps.event.addListener(map, 'click', function() {
	infowindow.close();
});
function cycle(){
	myclick(global_counter++%gmarkers.length);
	setTimeout(cycle,2000);	
}
function myclick(i) {
	google.maps.event.trigger(gmarkers[i], 'click');
}
function createMarker(latlng, name_of_venue, discount) {
   	var contentString=discount;
	var marker = new google.maps.Marker({
    	position: latlng,
        map: map,
        title: name_of_venue
	});
	google.maps.event.addListener(marker, 'click', function() {
   		if (!infowindow){
			infowindow = new google.maps.InfoWindow();
		}
		infowindow.setContent('<div class=bodyblue style="font-size:10px;"><strong>'+name_of_venue+'</strong><br>'+contentString+'</div>'); 
    	infowindow.open(map,marker);
    });
   	gmarkers.push(marker);
	var anchor = document.createElement('a');
	url = "#";
	anchor.setAttribute('href',url);
	anchor.setAttribute('onclick','myclick(' + (gmarkers.length-1) + ')');
	anchor.appendChild(document.createTextNode(name_of_venue));
	updateDiv.appendChild(anchor);
	updateDiv.appendChild(document.createElement('br'));
	updateDiv.appendChild(document.createTextNode(contentString));
	updateDiv.appendChild(document.createElement('br'));
	updateDiv.appendChild(document.createElement('br'));
}


  		





</script>
 <article>
 <div id="right_col" style="width:200px;float:right;"></div>
 <div id="mapcanvas" style="width:500px;height:400px;"></div>
 
</article>

	
	
	
	
	
</div>
	