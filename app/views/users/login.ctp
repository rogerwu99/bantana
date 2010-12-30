<?php $javascript->link('pstrength.js', false); ?>
                <div id="leftcolumn">
                
                <div class="content1">
			<div class="breadcrumbs"><?php echo $html->link('Home', '/'); ?> &gt; User Login</div>
                </div>

                  <div class="content1">
                    <h1>
                      User Login</h1>
                  </div>
                  <div class="content1">
			<? $session->flash(); ?>
                  </div>
		<?php echo $form->create('Auth',array('url'=>substr($this->here,strlen($this->base)))); ?>
                  <div class="content11">
		    <div class="formfieldcontent1">
                      <div class="bodycopy">User Name</div>
                    </div>
                    <div class="formfieldcontent2"><span style="margin:0px;">
			<div class='bodycopy' style='color:red'><?php echo $form->input('Auth.username', array('label'=>false, 'class'=>'required', 'style'=>'width:217px')); ?>
                    </span></div>
		  </div>
                  <div class="content11">
                    <div class="formfieldcontent1">
                      <div class="bodycopy">Password</div>
                    </div>
                    <div class="formfieldcontent2" style="width:247px" ><span style="margin:0px;">
			<div class='bodycopy' style='color:red'><?php echo $form->input('Auth.password', array('type' => 'password', 'label'=>false, 'class'=>'required validate-password', 'style'=>'width:217px', 'title'=>'Enter a password greater than 6 characters')); ?></div>
			<?php echo $form->hidden('Auth.remember_me', array('value' => '1')); ?>
                        </span>
	            </div>
                  </div>
                  
                    <div class="content1">
			<div style="text-align:right; width:400px;">
                        	<?php echo $form->submit('submit_button.jpg', array('width'=>'82px', 'height'=>'38px'));?>
			</div>
		    </div>
		<?php echo $form->input('UserNewPassword', array('type'=>'hidden', 'value'=>1, 'id'=>'UserNewPassword'));?>
		<?php echo $form->input('ps_heatbar', array('type'=>'hidden', 'value'=>1, 'id'=>'ps_heatbar'));?>
		<?php echo $form->input('ps_pointer', array('type'=>'hidden', 'value'=>1, 'id'=>'ps_pointer'));?>
		<?php echo $form->end(); ?>
                  
		</div>
<? /* ?>
		<div><span class="smallercopy"><?php echo $html->link('Forgot your password?', array('controller'=>'users','action'=>'reset')); ?></span></div>
<? */ ?>
                        <div><span class="smallercopy"><?php echo $html->link('Register For an Account', array('controller'=>'users','action'=>'register')); ?></span></div>

                </div>  
                <div id="rightcolumn">
                  <div class="sidebar1">
                    <div align="center">
			<? $img_list=split('"', $html->image("klickable_create_your_video_over.jpg")); 
   $disp_img=$img_list[1]; ?>
		    	<?php echo $html->link($html->image("klickable_create_your_video_up.jpg", array('alt'=>'Create Your Video Learn how you can use our super simple editor to make a klickable video in minutes - Start', 'width'=>'229', 'height'=>'174', 'name'=>'Create', 'id'=>'Create', 'border'=>'0', 'class'=>'bodycopy')), array('controller'=>'pages', 'action'=>'create'), array('escape' => false, 'onmouseover'=>"MM_swapImage('Create','','$disp_img',1)", 'onmouseout'=>"MM_swapImgRestore();")); ?>
<? $img_list=split('"', $html->image("klickable_publish_over.jpg")); 
   $disp_img=$img_list[1]; ?>
		    	<?php echo $html->link($html->image("klickable_publish_up.jpg", array('alt'=>'Publish Increase viewer engagement in video content. Learn what\'s happening behind the scenes through our user behavior data dashboard - Why', 'width'=>'229', 'height'=>'216', 'name'=>'Publish', 'id'=>'Publish', 'border'=>'0', 'class'=>'bodycopy')), array('controller'=>'pages', 'action'=>'publish'), array('escape' => false, 'onmouseover'=>"MM_swapImage('Publish','','$disp_img',1)", 'onmouseout'=>"MM_swapImgRestore();")); ?>
<? $img_list=split('"', $html->image("klickable_make_money_over.jpg")); 
   $disp_img=$img_list[1]; ?>
		    	<?php echo $html->link($html->image("klickable_make_money_up.jpg", array('alt'=>'Make Money Reep the benefits from video advertising and gene
rate the important sales - How', 'width'=>'229', 'height'=>'179', 'name'=>'MakeMoney', 'id'=>'MakeMoney', 'border'=>'0', 'class'=>'bodycopy')), array('controller'=>'pages', 'action'=>'makemoney'), array('escape' => false, 'onmouseover'=>"MM_swapImage('MakeMoney','','$disp_img',1)", 'onmouseout'=>"MM_swapImgRestore();")); ?>

                      </div>
                  </div>
                </div>



