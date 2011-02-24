<div id="beta" class="section-1">
  <div class="clear"></div>
  
  <div id="users_form">
	<fieldset>
 		<legend><?php echo $results['User']['name']; ?></legend>
		<?php echo $html->image($image_link, array('alt'=>'Your Profile','width'=>50,'height'=>50,'class'=>'top'));?>
		<? echo $results['User']['address']; ?>
		<? if(!is_null($results['User']['twitter_handle'])): 
			echo $results['User']['twitter_handle'];
			else:
//			echo "Hook up your Twitter";
			endif;
		?>		<?php echo $ajax->link('Edit', array('controller'=>'users', 'action'=>'edit'), array( 'update' => 'users_form')); ?>
	<br>
	<div id="token_status">	
		<?
			if (is_null($results['User']['latitude'])):
	 		 $tok =  $this->requestAction('users/getTokenCount/'); 
		 		 $bill =  $this->requestAction('users/getBillCount/'); ?>
		
            You have <? echo $bill; ?> bills & <? echo $tok; ?> tokens
           		
		<?	echo $html->link('Add', array('controller'=>'beta', 'action'=>'addTokens')); 
		?>
        <br />
		<span class="bodyblue">
		<?
			$filled_date = $this->requestAction('users/getTokenUpdated/');
		//	$now_date = $this->requestAction('users/getUpdateTime/');
			echo 'Your piggy bank has ';

		//	echo $filled_date;			
			$eyear=substr($filled_date,0,4); 
			$emonth=substr($filled_date,5,2);
			$eday=substr($filled_date,8,2);
			$ehour=substr($filled_date,11,2);
			$emin=substr($filled_date,14,2);
		//var_dump( $filled_date);
		/*
			$nyear=substr($now_date,0,4); 
			$nmonth=substr($now_date,5,2);
			$nday=substr($now_date,8,2);
			$nhour=substr($now_date,11,2);
			$nmin=substr($now_date,14,2);
			*/
	//	echo $tomorrow."*****";
			//echo $eyear.' '.$emonth.' '.$eday.' '.$ehour.' '.$emin;
	
	
		?>
        <span id="piggy_count"></span>
        tokens and fills to <? echo FULL_BANK; ?> tokens in
    <span id="countbox"></span>
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

dateFilled = new Date (<? echo $eyear; ?>,<? echo (int)$emonth-1; ?>,<? echo (int)$eday+1; ?>,<? echo $ehour; ?>,<? echo $emin; ?>);
// TESTING: comment out the line below to print out the "dateFuture" for testing purposes
//document.write(dateFuture +"<br />");
//alert(dateFilled);

//###################################
//nothing beyond this point
function GetCount(){

	dateNow = new Date();									//grab current date
	amount =  dateFilled.getTime()-dateNow.getTime();
			//calc milliseconds between dates
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
function GetCoins(){
	dateNow = new Date();									//grab current date
	amount =  dateFilled.getTime()-dateNow.getTime();
			//calc milliseconds between dates
	//delete dateNow;
	diffday = dateFilled.getDay()-dateNow.getDay();
	diffhour= dateFilled.getHours()-dateNow.getHours();
	if (diffday==0){
		hours_til_full = diffhour;		
	}
	else {
		hours_til_full = (24 - dateNow.getHours()) + dateFilled.getHours();
	}
	per_hour = <? echo FULL_BANK; ?> / 24;
	if (hours_til_full<0){
		earned=<? echo FULL_BANK; ?>;
	}
	else {
		if (dateFilled.getMinutes() < dateNow.getMinutes()){
			earned = per_hour * (24 - hours_til_full) + per_hour * (parseInt(dateNow.getMinutes())-parseInt(dateFilled.getMinutes()))/60;
		}
		else if (dateFilled.getMinutes() == dateNow.getMinutes()){
			earned = per_hour * (24 - hours_til_full);
		}
		else {
			earned = per_hour * (24 - hours_til_full) + per_hour * (60-parseInt(dateNow.getMinutes())+parseInt(dateFilled.getMinutes()))/60;
		}
	}
	//alert(earned);
	document.getElementById('piggy_count').innerHTML=Math.floor(earned);
	setTimeout("GetCoins()", 1200000);
}


	window.onload = function(){
		
	GetCount();
	GetCoins();

	}

</script>

</span><? echo $ajax->link('Empty', array('controller'=>'users', 'action'=>'emptyBank'), array( 'update' => 'token_status')); ?> 	<?
			endif;
		?>
</div>
	</fieldset>
	<fieldset>
 		<legend>Discounts</legend>
		<?php  
		if(is_null($none)){
		?>	<table>
	<?	
		//$jscript=array();
		foreach($d_results as $key=>$value){
		
		$end_date= $d_results[$key]['Discount']['end'];
	
			
			$countbox='countbox'.$d_results[$key]['Discount']['id'];
	
		?>
		<tr><td class="disc_td"><strong><? echo $html->link($d_results[$key]['Discount']['text'],array('controller'=>'discounts','action'=>'show',$d_results[$key]['Discount']['id'])); 
	?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:10px">Expires:<? echo $d_results[$key]['Discount']['end']; ?></span></strong>
    <span id="<? echo $countbox; ?>"></span>

	<span style="float:right;"><? echo $html->link('X',array('controller'=>'discounts','action'=>'hide',$d_results[$key]['Discount']['id']),array(),'Are you sure you want to hide this?',false); ?></span>
		
	
	<br><? echo $d_desc[$key]['User']['name'];?>
			:<? echo $d_desc[$key]['User']['address'];?></td></tr>
		<?
		}?>
		
        </table>
        <? }
		else {
			echo 'No Discounts Redeemed';
		}
		?>
	</fieldset>

</div>
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
function GetTimeRemain(){

	dateNow = new Date();									//grab current date
	amount = dateFuture.getTime() - dateNow.getTime();		//calc milliseconds between dates
	delete dateNow;

	// time is already past
	if(amount < 0){
		document.getElementById('countbox').innerHTML="Your Bank is full!";
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





</div>
	<div class="clear"></div>
	