<div class="sidebar5" id="consumer" style="display:block;">
<div style="float:right;">
	<?php if($page!='business'): 
			echo $html->link($html->image("signin_facebook.gif", array('alt'=>'Login With FB', 'width'=>'150', 'height'=>'22', 'border'=>'0')),array('controller'=>'users', 'action'=>'facebookLogin'), array('escape'=>false));	
	?>
	<br>
	<?php	echo $html->link($html->image("signin_twitter.gif", array('alt'=>'Login With Twitter', 'width'=>'150', 'height'=>'22', 'border'=>'0')),array('controller'=>'users', 'action'=>'getRequestURL'),array('escape'=>false)); ?>
	<br>
	<?	echo $html->link('Business Login','/pages/business'); ?>
	<? else: ?>
		Business Login | <?php echo $html->link('User Login','/'); ?>
	<? endif; ?>
</div>
</div>