<div class="clear"></div>
<div id="content8">

<?php echo $form->create('Beta',array('url'=> array('controller'=>'beta', 'action'=>'addTokens'))); 
echo $form->input('buy_more_tokens', array(
     'type' => 'radio',
     'options' => array(1 => '100 tokens ($5.00)<br>', 2 => '250 tokens ($10.00)<br>', 3 => '500 tokens ($18.00)<br>', 4 => '1000 tokens ($31.00)<br>')
)); 

echo $form->submit('Submit'); 
echo $form->end();
		   ?>  
</div>
  
  
  
  
  