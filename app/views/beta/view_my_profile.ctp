<div id="beta" class="section-1">
  <div class="clear"></div>
  
  <div id="users_form">
	<fieldset>
 		<legend><?php echo $results['User']['name']; ?></legend>
		<?php echo $html->image($image_link, array('alt'=>'Your Profile','width'=>50,'height'=>50,'class'=>'top'));?>
		<? echo $results['User']['address']; ?>
		<? if(!is_null($results['User']['twitter_handle'])): 
			echo $results['User']['twitter_handle'];
			else:
//			echo "Hook up your Twitter";
			endif;
		?>		<?php echo $ajax->link('Edit', array('controller'=>'users', 'action'=>'edit'), array( 'update' => 'users_form')); ?>
	<br>
		<?
			$tokens = $results['User']['tokens']==0?'0':$results['User']['tokens'];
			echo 'Tokens: '.$tokens.' left';
		?>

	</fieldset>
	<fieldset>
 		<legend>Discounts</legend>
		<?php  
		if(is_null($none)){
		?>	<table>
	<?	foreach($d_results as $key=>$value){
		?>
		<tr><td class="disc_td"><strong><? echo $html->link($d_results[$key]['Discount']['text'],array('controller'=>'discounts','action'=>'show',$d_results[$key]['Discount']['id'])); 
	?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:10px">Expires:<? echo $d_results[$key]['Discount']['end']; ?></span></strong>
	<span style="float:right;"><? echo $html->link('X',array('controller'=>'discounts','action'=>'hide',$d_results[$key]['Discount']['id']),array(),'Are you sure you want to hide this?',false); ?></span>
		
	
	<br><? echo $d_desc[$key]['User']['name'];?>
			:<? echo $d_desc[$key]['User']['address'];?></td></tr>
		<?
		}?>
		</table>
		<?}
		else {
			echo 'No Discounts Redeemed';
		}
		?>
	</fieldset>

</div>
</div>
	<div class="clear"></div>
	