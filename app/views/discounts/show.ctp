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
		GetCount();

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
	
    <!-- need to do error checking for if you don't have enough tokens -->
    
	
	<? echo $form->create('Discount',array('url'=>array('controller'=>'discounts','action'=>'redeem'))); ?>
	<?php echo $form->hidden('id',array('value'=>$disc['Discount']['id'])); ?>
	

	<?php echo $form->submit('REDEEM!',array('class'=>'button_blue')); ?>
	    	 	
		
	<? echo $form->end(); ?>
	</div>
	<? } else { 
		echo '<Br>You redeemed this offer already';
	//	echo '<br>Email offer or view Coupon';
		
		echo '<br>Offer Expires in: ';
		

		?>
    
    <script type="text/javascript">
//######################################################################################
// Author: ricocheting.com
// For: public release (freeware)
// Date: 4/24/2003 (update: 6/26/2009)
// Description: displays the amount of time until the "dateFuture" entered below.


// NOTE: the month entered must be one less than current month. ie; 0=January, 11=December
// NOTE: the hour is in 24 hour format. 0=12am, 15=3pm etc
// format: dateFuture = new Date(year,month-1,day,hour,min,sec)
// example: dateFuture = new Date(2003,03,26,14,15,00) = April 26, 2003 - 2:15:00 pm

dateFuture = new Date (<? echo $eyear; ?>,<? echo $emonth; ?>-1,<? echo $eday; ?>,<? echo $ehour; ?>,<? echo $emin; ?>);
  
// TESTING: comment out the line below to print out the "dateFuture" for testing purposes
//document.write(dateFuture +"<br />");


//###################################
//nothing beyond this point
function GetCount(){

	dateNow = new Date();									//grab current date
	amount = dateFuture.getTime() - dateNow.getTime();		//calc milliseconds between dates
	delete dateNow;

	// time is already past
	if(amount < 0){
		document.getElementById('countbox').innerHTML="Offer has now expired!";
	}
	// date is still good
	else{
		days=0;hours=0;mins=0;secs=0;out="";

		amount = Math.floor(amount/1000);//kill the "milliseconds" so just secs

		days=Math.floor(amount/86400);//days
		amount=amount%86400;

		hours=Math.floor(amount/3600);//hours
		amount=amount%3600;

		mins=Math.floor(amount/60);//minutes
		amount=amount%60;

		secs=Math.floor(amount);//seconds

		if(days != 0){out += days +" day"+((days!=1)?"s":"")+", ";}
		if(days != 0 || hours != 0){out += hours +" hour"+((hours!=1)?"s":"")+", ";}
		if(days != 0 || hours != 0 || mins != 0){out += mins +" minute"+((mins!=1)?"s":"")+", ";}
		out += secs +" seconds";
		document.getElementById('countbox').innerHTML=out;

		setTimeout("GetCount()", 1000);
	}
}
//window.onload=GetCount;//call when everything has loaded

</script>
<div id="countbox"></div>

    
    

	 <? }
	 } ?>
	 
  </div>
  