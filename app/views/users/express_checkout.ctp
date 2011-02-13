<div id="clear"></div>
<div id='content8'>
<?php  
    if (!isset($error)){
	//	echo $step;
        if ($step==2){
			?>
				Please confirm your order.            
            <?
            echo $form->create('User',array('type' => 'post', 'action' => 'expressCheckout/3', 'id' => 'OrderExpressCheckoutConfirmation')); 
            //all shipping info contained in $result display it here and ask user to confirm.
            //echo pr($result);
            echo $form->end('Confirm Payment'); 
        }
        if ($step==3){
            //show confirmation once again all information is contained in $result or $error
            echo '<h2>Congrats</h2>';
        }
    }
    else
        echo $error;
?>
</div>