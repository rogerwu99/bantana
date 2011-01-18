<?php if(!empty($_Auth['User'])): ?>
	<div class="sidebar5" id="logged_in">
	<div style="padding-top:2px;"class="smallercopywhite">
			<?php //echo $html->link('Location', array('controller'=>'beta','action'=>'view_my_location')); ?> <!-- | -->
			<?php //echo $html->link('Profile', array('controller'=>'beta','action'=>'view_my_profile')); ?><!-- | -->
			<?php echo $html->link('Sign Out', array('controller'=>'users', 'action'=>'logout')); ?>
	</div>
	
	<div style = "padding-top:2px;" class="smallercopy">
	<!--<span class="dh"> </span>
	--><?php //echo $form->input('Status', array('options' => array('Available','Not Available','Stealth'))); ?>

	</div>
	
    <div class="bodycopy"><h2>Hi <? echo $_Auth['User']['name']; ?>!</h2></div>
		<?php if(empty($_Auth['User']['fb_uid'])):
			//echo $html->link($html->image("signin_facebook.gif", array('alt'=>'Login With FB', 'width'=>'150', 'height'=>'22', 'border'=>'0')),array('controller'=>'users', 'action'=>'facebookLogin'), array('escape'=>false));?>	<!--	<br><br>  -->
	
	<?php		 elseif(empty($_Auth['User']['tw_uid'])): 
			//echo $html->link($html->image("signin_twitter.gif", array('alt'=>'Login With Twitter', 'width'=>'150', 'height'=>'22', 'border'=>'0')),array('controller'=>'users', 'action'=>'getRequestURL'),array('escape'=>false));?>	<!--	<br><br>   -->
	
		<?php endif;?>
	<div class="smallercopy"> 
		<?php 
			if ($_Auth['User']['fb_pic_url']==''): 
				if ($_Auth['User']['tw_pic_url']==''):
				echo "hi";
					echo $html->image("default.gif", array('alt' => 'Pic', 'width' => 50, 'height' => 50, 'class' => 'top'));
				else:
				echo "bye";
					echo $html->image($_Auth['User']['tw_pic_url'], array('alt' => 'Pic', 'width' => 50, 'height' => 50, 'class' => 'top'));
					echo $_Auth['User']['twitter_handle']; 
				endif; 
				
				?>
				<span class="bodycopy"><strong><?php	
	            	echo $_Auth['User']['tw_location'];
    			?>
				</strong></span>
				<?php
	        else: 
				if ($_Auth['User']['fb_pic_url']==''):
					echo 'hi2';
					echo $html->image("default.gif", array('alt' => 'Pic', 'width' => 50, 'height' => 50, 'class' => 'top'));
				else:
				echo 'bye2';
					echo $html->image($_Auth['User']['fb_pic_url'], array('alt' => 'Pic', 'width' => 50, 'height' => 50, 'class' => 'top'));
				endif;
				?>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<?php
				echo $_Auth['User']['name']; 
			?>
				
			<span class="bodycopy"><strong><?php	
	                
				echo $_Auth['User']['fb_location'];
			endif; 
			?>
			</strong></span>
		</div>
		 
            
	</div>


<?php 
 else:
?>		
<div class="sidebar5" id="consumer" style="display:block">
	<?php 
	echo $form->create('Users', array('url'=>array('controller'=>'users', 'action'=>'register')));
	echo $form->input('email', array('type'=>'text', 'label'=>false, 'class'=>'largeinput', 'error'=>false));
	echo $form->submit('Sign Up!', array('name'=>'submit', 'div'=>'rightbutton'));
	echo $form->end();
?>

                 </div>
	
<?php endif; ?>
