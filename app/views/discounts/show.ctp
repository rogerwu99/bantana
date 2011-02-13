<div id="beta" class="section-2">
<? if ($deleted){ 
	echo "This offer has been deleted or is no longer valid";
} else {
	echo $javascript->link('http://maps.google.com/maps/api/js?sensor=false'); ?>
    
 <script type="text/javascript">
	
	window.onload = function(){
		var myLatlng = new google.maps.LatLng(<?php echo $vendor['User']['latitude']; ?>,<?php echo $vendor['User']['longitude']; ?>);
		var myOptions = {
    		zoom: 16,
	 		center: myLatlng,
    		mapTypeId: google.maps.MapTypeId.ROADMAP
  		}	
 		var map = new google.maps.Map(document.getElementById("mapcanvas"), myOptions);
	    var marker = new google.maps.Marker({
      		position: myLatlng, 
      		map: map, 
      		title:" <? $vendor['User']['name']; ?>"
  		});

	}
	</script>
	<div id="mapcanvas" style="width:300px;height:300px;float:right;"></div>  
	<h2>
	<? 
	 	echo $disc['Discount']['text'];
	?>
	</h2>
	<div class="bodyblue">
	Expires: 
	<?
		echo $disc['Discount']['end'];
	?></div>
	<?	
	 	echo $vendor['User']['name'];
		echo $html->image(ROOT_URL.'/img/uploads/'.$vendor['User']['path'],array('alt'=>$vendor['User']['name'],'width'=>50,'height'=>50));
	?>
	<br><?
		echo $vendor['User']['address'];
	?>
	<br>
	Cost:&nbsp;&nbsp;<?
		echo $disc['Discount']['value']*CONVERSION_RATE;
	?> &nbsp;&nbsp;tokens
	<br>
	You have: &nbsp;&nbsp;
	<? echo $_Auth['User']['tokens']; ?>
	&nbsp;&nbsp;tokens
	
	<? if(!$redeemed) { ?>
	<div id="redeemable">
	<? echo $form->create('Discount',array('url'=>array('controller'=>'discounts','action'=>'redeem'))); ?>
	<?php echo $form->hidden('id',array('value'=>$disc['Discount']['id'])); ?>
	

	<?php echo $form->submit('REDEEM!',array('class'=>'button_blue')); ?>
	    	 	
		
	<? echo $form->end(); ?>
	</div>
	<? } else { 
		echo '<Br>You redeemed this offer already';
	//	echo '<br>Email offer or view Coupon';
	 }
	 } ?>
	 
  </div>
  