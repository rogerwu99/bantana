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
		<?
			$tokens = $results['User']['tokens']==0?'0':$results['User']['tokens'];
			echo 'Tokens: '.$tokens.' left ';
			
			echo $html->link('Add', array('controller'=>'beta', 'action'=>'addTokens')); 
		?>

	</fieldset>
	<fieldset>
 		<legend>Discounts</legend>
		<?php  
		if(is_null($none)){
		?>	<table>
	<?	
		$jscript=array();
		foreach($d_results as $key=>$value){
		
		$end_date= $d_results[$key]['Discount']['end'];
	
			$eyear=substr($end_date,0,4); 
			$emonth=substr($end_date,5,2);
			$eday=substr($end_date,8,2);
			$ehour=substr($end_date,11,2);
			$emin=substr($end_date,14,2);
			
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
        <?php 
		$month_adjust = $emonth-1;
		$jscript_string = 'GetCount(new Date ( '.$eyear.','. $month_adjust.','. $eday.','. $ehour.','. $emin.'),\''.$countbox.'\','.$key.')'; 
		$jscript[$key]= $jscript_string;
		?>
        <script>
		setTimeout("<? echo $jscript_string; ?>", 1000);
	
        </script>
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

  
// TESTING: comment out the line below to print out the "dateFuture" for testing purposes
//document.write(dateFuture +"<br />");


//###################################
//nothing beyond this point
function GetCount(future, div, key){
	alert("HI");
	dateNow = new Date();									//grab current date
	amount = future.getTime() - dateNow.getTime();		//calc milliseconds between dates
	delete dateNow;

	// time is already past
	if(amount < 0){
		document.getElementById(div).innerHTML="Offer has now expired!";
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
		document.getElementById(div).innerHTML=out;
//alert(key);
//		setTimeout("GetCount("+future+", "+div+")", 1000);
	//setTimeout("GetCount(new Date(future.getFullYear(),future.getMonth(),future.getDate(),future.getHours(),future.getMinutes()),\'"+ div +"\',"+ key+"),1000)");
	alert("HO");
		setTimeout("GetTimeout(new Date(<? echo $eyear; ?>,<? echo $month_adjust; ?>,<? echo $eday; ?>,<? echo $ehour; ?>,<? echo $emin; ?>),"<? echo $countbox; ?>","<? echo $key; ?>")",1000);
	}
}
//window.onload=GetCount;//call when everything has loaded

</script>




</div>
	<div class="clear"></div>
	