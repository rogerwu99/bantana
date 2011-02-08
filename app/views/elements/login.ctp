<?php if(!empty($_Auth['User'])): ?>
	<div class="sidebar5" id="logged_in">
	<div style="float:right;padding-top:2px;"class="smallercopywhite">
		<span style="margin-top:-25px;"><?php 
			if ($_Auth['User']['fb_pic_url']==''):  
				echo $html->image($_Auth['User']['tw_pic_url'], array('alt' => 'Pic', 'width' => 50, 'height' => 50, 'class' => 'top'));
			else: 
				echo $html->image($_Auth['User']['fb_pic_url'], array('alt' => 'Pic', 'width' => 50, 'height' => 50, 'class' => 'top'));
			endif; 
		?></span>
			<span class="bodycopy"><strong>
				<?php echo $html->link($_Auth['User']['name'], array('controller'=>'beta','action'=>'view_my_profile')); ?> | 
			</strong></span>
			<?php echo $html->link('Location', array('controller'=>'beta','action'=>'view_my_location')); ?>  		
			<span class="bodycopy"><strong>|</strong></span>
			<?php echo $html->link('Sign Out', array('controller'=>'users', 'action'=>'logout')); ?>
			<?php //echo $form->input('Status', array('options' => array('Available','Not Available','Stealth'))); ?>
	</div>
	
	<div class="smallercopy" style="margin-left:100px;float:right;"> 
		<?php if(empty($_Auth['User']['fb_uid'])):
			echo $html->link($html->image("signin_facebook.gif", array('alt'=>'Login With FB', 'width'=>'150', 'height'=>'22', 'border'=>'0')),array('controller'=>'users', 'action'=>'facebookLogin'), array('escape'=>false));?>	<!--	<br><br>  -->
			<?php elseif(empty($_Auth['User']['tw_uid'])): 
			echo $html->link($html->image("signin_twitter.gif", array('alt'=>'Login With Twitter', 'width'=>'150', 'height'=>'22', 'border'=>'0')),array('controller'=>'users', 'action'=>'getRequestURL'),array('escape'=>false));?>	<!--	<br><br>   -->
		<?php endif;?>
	</div>
	</div>
<?php endif; ?>	
	


