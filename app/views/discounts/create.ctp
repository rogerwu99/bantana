<div id="beta" class="section-2">

<table><tr><td>
	<?php echo $form->input('Address',array('type'=>'text','label'=>false,'value'=>$discount['Discount']['text'])); ?>
	</td><td>
	
	<? echo $discount['Discount']['start'];?>
	</td><td>
	
	<? echo $discount['Discount']['end']; ?>
	
	</td><td>
	<?php echo $html->link('Delete', array('controller'=>'discounts', 'action'=>'delete',$discount['Discount']['id']),array(),'Are you sure you want to delete this?', false); ?>
</td><td>
	
	
	</td></tr>
	
	</table>
	  
  
  
  
  
  </div>
  