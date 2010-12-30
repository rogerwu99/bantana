    <?php echo $form->create('Subscriber', array('action'=>'add', 'class'=>'subscribe')); ?>
	<div id="label">
		Join Our Mailing List:
	</div>
	<ul class="horizontal">
        <li><?php echo $form->input('email', array('label' => false)); ?></li>
	    <li><?php echo $form->submit('/img/signup.gif', array('width'=>'45px', 'height'=>'26px'));?></li>
	</ul> 
	</form>
<div class="clear"></div>
