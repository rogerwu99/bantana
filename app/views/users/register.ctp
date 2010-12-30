<?php $javascript->link('pstrength.js', false); ?>
<?php $javascript->link('validation.js', false); ?>
                <div id="leftcolumn">
                
                  <div class="content1">
                    <div class="bodycopy">Get Moo Pro today :</div>
                  </div>
			<? echo '<div class="bodycopy" style="color:red">'.$form->error('User.accept').'</div><br />'; ?>
			<? $session->flash(); ?>
		<?php echo $form->create('User', array('action' => 'register')); ?>
                  <div class="content11">
		    <div class="formfieldcontent1">
                      <div class="bodycopy">Name</div>
                    </div>
                    <div class="formfieldcontent2"><span style="margin:0px;">
			<div class='bodycopy' style='color:red'><?php echo $form->input('name', array('label'=>false, 'class'=>'required', 'style'=>'width:217px')); ?></div>
                    </span></div>
		  </div>
                  <div class="content11">
                    <div class="formfieldcontent1">
                      <div class="bodycopy">Email Address</div>
                    </div>
                    <div class="formfieldcontent2"><span style="margin:0px;">
			<?php //echo $form->input('email', array('class'=>'required')); ?>
			<div class='bodycopy' style='color:red'><?php echo $form->input('email', array('class'=>'required', 'title'=>'Please enter a valid email address', 'style'=>'width:217px', 'label'=>false)); ?></div>
			
                    </span></div>
                  </div>
                  <div class="content10">
                    <div class="formfieldcontent1">
                      <div class="bodycopy">Password</div>
                    </div>
                    <div class="formfieldcontent2" style="width:247px" ><span style="margin:0px;">
			<div class='bodycopy' style='color:red'><?php echo $form->input('new_password', array('type' => 'password', 'label'=>false, 'class'=>'required validate-password', 'style'=>'width:217px', 'title'=>'Enter a password greater than 6 characters')); ?></div>
                        </span>
                      <div style="padding-top:6px;" class="smallercopy" style="width:247px;">Password strength</div>
		<? echo $html->image("ps_heatbar.jpg", array('width'=>'253', 'height'=>'9', 'class'=>'ps_heatbar', 'id'=>'ps_heatbar')); ?><br />
		<? echo $html->image("pointer_black.gif", array('width'=>'8', 'height'=>'4', 'class'=>'ps_pointer', 'id'=>'ps_pointer')); ?>
			</div>
                  </div>
                  
                  <div class="content12">
                    <div class="formfieldcontent1">
                      <div class="bodycopy">Re-type Password</div>
                    </div>
                    <div class="formfieldcontent2"><span style="margin:0px;">
			<div class='bodycopy' style='color:red'><?php echo $form->input('confirm_password', array('label'=>false, 'type' => 'password', 'class'=>'required validate-password-confirm', 'title'=>'Enter the same password for confirmation')); ?></div>
                    </span></div>
                  </div>
                  
                  
 <!--                 <div class="content12"><div class="bodycopy">Word Verification</div></div>
     -->               
                    <div class="content1">
			<?php $this->requestAction('users/recaptcha'); ?>
                    </div>
                    
                    </div>
                    <div class="content1">
                      <?php echo $form->checkbox('User.accept', array('class'=>'required validate-one-required', 'title'=>'Please agree to terms and conditions'));?><div class="bodycopy">Please read our <?php echo $html->link('Terms of Use', array('controller'=>'pages', 'action'=>'terms')); ?> and our <?php echo $html->link('Privacy Policy', array('controller'=>'pages', 'action'=>'privacy')); ?> before accepting.</div>
                      </div>
                    </div>
                    
                    <div class="content1">
                    <div class="content18">
                      <div class="floatleft"><? echo $html->image("create_my_account_button.jpg", array('alt'=>'Create my account', 'width'=>'205', 'height'=>'38')); ?></div><div class="floatleft"><?php echo $form->submit('submit_now_button.jpg');?></div>
                    </div></div>
		<?php echo $form->end(); ?>
                  
                  <script type="text/javascript">
						function formCallback(result, form) {
							window.status = "valiation callback for form '" + form.id + "': result = " + result;
						}
						
						var valid = new Validation('test', {immediate : true, onFormValidate : formCallback});
						Validation.addAllThese([
							['validate-password', 'Your password must be more than 6 characters and not be \'password\' or the same as your name', {
								minLength : 7,
								notOneOf : ['password','PASSWORD','1234567','0123456'],
								notEqualToField : 'field1'
							}],
							['validate-password-confirm', 'Your confirmation password does not match your first password, please try again.', {
								equalToField : 'ps_password'
							}]
						]);
					</script>
                  
                  
                  
                </div>
                <div id="rightcolumn">
                </div>



