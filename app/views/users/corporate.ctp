<div id="beta" class="section-2">

			      
 	<div id="corp_signup">
                       <h1>Corporate Login</h1><br>
		
 <?php echo $form->create('User', array('url' => array('action' => 'corpReg'))); ?>
	Your Name:<br>
	<?php echo $form->input('Name', array('error' => array('required' => 'Name is required'), 'label' => false, 'class' => 'text_field_big' )); ?>
		Address: <br>
		<?php echo $form->input('Address', array('error' => array('required' => 'Address is required'), 'label' => false, 'class' => 'text_field_big' )); ?>
<table><tr><td>Zip:<br>	<?php echo $form->input('Zip', array('error' => array('required' => 'Zip is required'), 'label' => false, 'class' => 'text_field_big', 'size'=>10)); ?></td><td>
                
Range:<br>          <?php echo $form->input('Range', array('type'=>'select','options'=>$ranges,'error' => array('required' => 'Range is required'), 'label' => false, 'class' => 'text_field_big' )); ?>
				  </td></tr></table>
	Email:<br><?php echo $form->input('Email', array('error' => array('required' => 'Email is required'), 'label' => false, 'class' => 'text_field_big' )); ?>		  
<table><tr><td>   Password:<br><?php echo $form->input('new_password', array('type' => 'password', 'label'=>false, 'class'=>'text_field_big', 'style'=>'width:217px', 'title'=>'Enter a password greater than 6 characters')); ?></td><td>
	Confirm Password:<Br><?php echo $form->input('confirm_password', array('label'=>false, 'type' => 'password', 'class'=>'text_field_big', 'style'=>'width:217px','title'=>'Enter the same password for confirmation')); ?></td></tr></table>
	
			
		<tr><td>	<?php echo $form->submit('GO!', array('name'=>'shorten', 'class'=>'button_green'));
	?>		</td></tr></table>
	<?php echo $form->end(); ?>
	<?php echo $this->element('pay');?>
</div>
	
	<div class="clear"></div>
</div>
</div>