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
		?>
		<?php echo $ajax->link('Edit', array('controller'=>'users', 'action'=>'edit'), array( 'update' => 'users_form')); ?>
	
	</fieldset>
</div>
</div>
	<div class="clear"></div>
	