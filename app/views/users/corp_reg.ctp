<div class="sidebar6" id="consumer" style="display:block">
<div style="margin-left:20px;width:200px;float:right;">
&nbsp;&nbsp;&nbsp;&nbsp;<?		
	echo $html->link("Learn how it works!",array('controller'=>'pages', 'action'=>'howitworks'));
?>	
</div>
<?php echo $this->element('errors', array('errors' => $errors)); ?>
    
<div class="corp_signup" id="logging_in" style="display:block">
	<span class="bodycopy">Sign In | 
		<?php 
			echo $html->link("Register","#",array('onClick'=>'Effect.SlideDown(\'corp\'); Effect.SlideUp(\'logging_in\');return false;', 'class'=>'bodyblue'));
			echo $form->create('Auth',array('url'=>substr($this->here,strlen($this->base)))); 
    	 	?>
	</span>
			Email:<br>
			<?
			echo $form->input('Auth.username', array('label'=>false, 'class' => 'text_field_big', 'size'=>15)); 
		 	?>
			Password:
			<?
			echo $form->input('Auth.password', array('type' => 'password', 'label'=>false, 'class' => 'text_field_big', 'size'=>15, 'title'=>'Enter a password greater than 6 characters'));
			?>
			<? 
			echo $form->submit('Login!', array('name'=>'submit', 'div'=>'rightbutton'));
			echo $form->end();
		?>
	</div>
	<div class="corp_signup" id="corp" style="display:none">
    <span class="bodycopy">Register | 
		<? 
			echo $html->link("Sign In", "#", array('onClick'=>'Effect.SlideDown(\'logging_in\'); Effect.SlideUp(\'corp\');return false;'));
			echo $form->create('User', array('url' => array('action' => 'corpReg'))); 
		?>
	</span>
		Company Name:<br>
		<?php 
			echo $form->input('Name', array('error' => array('required' => 'Name is required'), 'label' => false, 'class' => 'text_field_big','size'=>15 )); 
		?>
		Address: <br>
		<?php 
			echo $form->input('Address', array('error' => array('required' => 'Address is required'), 'label' => false, 'class' => 'text_field_big','size'=>15 )); 
		?>
		<span>Zip:<br>	<?php echo $form->input('Zip', array('error' => array('required' => 'Zip is required'), 'label' => false, 'class' => 'text_field_big', 'size'=>15)); ?>
		<!--Range:<br>-->          <?php //echo $form->input('Range', array('type'=>'select','options'=>$ranges,'error' => array('required' => 'Range is required'), 'label' => false, 'class' => 'text_field_big' )); ?></span>
		Email:<br><?php echo $form->input('email', array('error' => array('required' => 'Email is required'), 'label' => false, 'class' => 'text_field_big','size'=>15 )); ?>	
		Password:<br><?php echo $form->input('new_password', array('type' => 'password', 'label'=>false, 'class'=>'text_field_big', 'size'=>15,'style'=>'width:217px', 'title'=>'Enter a password greater than 6 characters')); ?>
		Confirm Password:<Br><?php echo $form->input('confirm_password', array('label'=>false, 'type' => 'password', 'class'=>'text_field_big','size'=>15, 'style'=>'width:217px','title'=>'Enter the same password for confirmation')); ?>
       <br />

	    <fieldset>
    <legend>Plans</legend>
			<input type="radio" name="data[User][plan]" value="Premium" id="UserChooseAPlan1"><span id="prem"></span><br>
<input type="radio" name="data[User][plan]" value="Super" id="UserChooseAPlan2"> <span id="supe"></span><br>
<input type="radio" name="data[User][plan]" value="Starter" id="UserChooseAPlan3"> <span id="star"></span><br />
</fieldset>

	<?php echo $this->element('pay');?>
    <br /><br />
	    	<?php echo $form->submit('Next!', array('name'=>'shorten', 'class'=>'button_green'));
	?>
    <?php echo $form->end(); ?>
    <?php echo $this->element('dcode'); ?>
    	
</div></div>
	<div class="clear"></div>



	

    
