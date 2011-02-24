<div id="beta" class="section-1">
<div class="clear"></div>
 <div id="contents" style="margin-left:30px;">
 <input type="hidden" id="simplegeolat" value="<? echo $simplegeo_lat; ?>" />
	 <input type="hidden" id="simplegeolong" value="<? echo $simplegeo_long; ?>" />
	   <?php 
		echo $javascript->link('http://maps.google.com/maps/api/js?sensor=false');
     	echo $javascript->link('http://code.google.com/apis/gears/gears_init.js');
		echo $javascript->link('geo.js');
		echo $javascript->link('map.js');
		?>
		<div id="discounts"></div>
	

	<span class="bodycopy"> 
		<? 
			echo $html->link("I'll find me", "#", array('onClick'=>'Effect.SlideDown(\'response\');return false;'));
		?> |
		<?
			echo $html->link("Nevermind", "#", array('onClick'=>'Effect.SlideUp(\'response\');return false;'));
		?>
	
	</span>
		<?php echo $form->create('Discounts'); ?>
		<?php if (!$show_discounts): ?>
        <div id="disc_div" style="display:none;">
		<input id="myLat" name="data[Discounts][myLat]" type="hidden">
	  	<input id="myLong" name="data[Discounts][myLong]" type="hidden">
	   
		<? else: ?>
        <div id="disc_div" style="display:block;">
       	<input id="myLat" name="data[Discounts][myLat]" type="hidden" value="<? echo $simplegeo_lat; ?>">
	  	<input id="myLong" name="data[Discounts][myLong]" type="hidden"  value="<? echo $simplegeo_long; ?>">
	   
		<? endif; ?>
        <div style="float:right;"> 	
		<?php echo $ajax->submit('Get Discounts', array('url'=> array('controller'=>'discounts', 'action'=>'read'), 'update' => 'discounts'));
			 echo $form->end();
		?>

	</div></div>
		
		<div id="response" style="display:none;">
		  <?php echo $form->create('Beta'); ?>
		  <?php echo $form->input('Address',array('type'=>'text','label'=>'Enter your street address, city, state, zip.')); ?>
		  <?php echo $ajax->submit('Submit', array('url'=> array('controller'=>'beta', 'action'=>'manual_location'), 'update' => 'response'));
				echo $form->end();
		   ?>
		</div>
	
		<article>
      <p>Your location: <span id="status"><? echo $simplegeo_address; ?>
	</span></p>
   	<div id="right_col" style="float:right;width:200px;height:400px;"></div>
	
   </article>
	
	
	</div>
	</div>
<div class="clear"></div>