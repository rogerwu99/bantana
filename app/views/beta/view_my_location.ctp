<div id="beta" class="section-1">
<div class="clear"></div>
 <div id="contents">
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
	
		<div id="disc_div" style="display:none;">
		<div style="float:right;"> 	
		<?php echo $form->create('Discounts'); ?>
			<input id="myLat" name="data[Discounts][myLat]" type="hidden">
	  		<input id="myLong" name="data[Discounts][myLong]" type="hidden">
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
      <p>Finding your location: <span id="status">checking...</span></p>
   	<div id="right_col" style="float:right;width:200px;height:400px;"></div>
	
   </article>
	
	
	</div>
	</div>
<div class="clear"></div>