
<script type="text/javascript">
  var myLatlng = new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $long; ?>);
var myOptions = {
    zoom: 16,
    center: myLatlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  //var map = new google.maps.Map(document.getElementById("mapcanvas"), myOptions);

  var marker = new google.maps.Marker({
      position: myLatlng, 
      map: map, 
      title:"You are here!"
  });
 map.setCenter(myLatlng);
document.getElementById("myLat").value = <? echo $lat; ?>;
document.getElementById("myLong").value = <? echo $long; ?>;
var eDiv= document.getElementById("status");
if (eDiv.hasChildNodes()) {
	eDiv.removeChild(eDiv.lastChild);
}
eDiv.appendChild(document.createTextNode("<? echo $address; ?>"));
document.getElementById("disc_div").style.display="block";
//Element.show('discounts');
//document.getElementById("discounts").show;
  </script>
<?php echo $form->create('Beta'); ?>
		  <?php echo $form->input('Address',array('type'=>'text','label'=>'Enter your street address, city, state, zip.')); ?>
		  <?php echo $ajax->submit('Submit', array('url'=> array('controller'=>'beta', 'action'=>'manual_location'), 'update' => 'response'));
				echo $form->end();
		   ?>  
  
  
  
  
  