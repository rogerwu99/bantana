<div id="beta" class="section-2">
 <script type="text/javascript">
 	
	// we don't want to redraw the map
		var infowindow;
	  	var gmarkers = []; 
	  	var updateDiv = document.getElementById("right_col");
		while (updateDiv.hasChildNodes()) {
			updateDiv.removeChild(updateDiv.lastChild);
		}
	
		var myLatlng = new google.maps.LatLng(<?php echo $myLat; ?>,<?php echo $myLong; ?>);
		var myOptions = {
    		zoom: 16,
	 		center: myLatlng,
    		mapTypeId: google.maps.MapTypeId.ROADMAP
  		}	
 		//var map = new google.maps.Map(document.getElementById("mapcanvas"), myOptions);
		google.maps.event.addListener(map, 'click', function() {
        		infowindow.close();
        		});

	
		myclick = function (i) {
			google.maps.event.trigger(gmarkers[i], 'click');
		}

		function createMarker(latlng, name_of_venue, discount, id) {
   			var contentString=discount;
			var hrefString = "<a href=\"/discounts/show/"+id+"\">"; 
			var marker = new google.maps.Marker({
        		position: latlng,
        		map: map,
        		title: name_of_venue
		 	});

    		google.maps.event.addListener(marker, 'click', function() {
        		if (!infowindow){
					infowindow = new google.maps.InfoWindow();
				}
				infowindow.setContent('<div class=bodyblue><strong>'+name_of_venue+'</strong><br>'+contentString+'<br>'+hrefString+'Details</a></div>'); 
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
			var anchor1 = document.createElement('a');
			anchor1.setAttribute('href','/discounts/show/'+id);
			anchor1.setAttribute('class','bodyblue');
			anchor1.appendChild(document.createTextNode('Details'));
				updateDiv.appendChild(document.createElement('br'));
			updateDiv.appendChild(anchor1);
		updateDiv.appendChild(document.createElement('br'));
		updateDiv.appendChild(document.createElement('hr'));
			updateDiv.style.overflow='auto';
		}

  		
		<?php foreach ($results as $key=>$value){?>
			var myLatlng = new google.maps.LatLng(<?php echo $results[$key]['Discount']['lat']; ?>,<?php echo $results[$key]['Discount']['long']; ?>);
 			createMarker(myLatlng, '<?php echo $results[$key]['Discount']['name']; ?>', '<?php echo $results[$key]['Discount']['text']; ?>','<?php echo $results[$key]['Discount']['id']; ?>' );
		<?php } ?>


	</script>
	
 
  
  
  
  </div>
  