       
<?php $div_name = 'div_'.$results['Discount']['id']; ?>
	<table><tr><td colspan = 2 class="corp_td">
	<? echo $results['Discount']['text'];?>
	</td>
	<td class="corp_td">
	<?php echo $ajax->link('Edit', array('controller'=>'discounts', 'action'=>'edit',$results['Discount']['id']), array( 'update' => $div_name)); ?>
	
	</td></tr><tr>
	<td class="corp_td">
	<? echo $results['Discount']['start'];?>
	</td><td class="corp_td">
	<? echo $results['Discount']['end']; ?>
	
	</td><td class="corp_td">
	<?php echo $html->link('Delete', array('controller'=>'discounts', 'action'=>'delete',$results['Discount']['id']),array(),'Are you sure you want to delete this?', false); ?>
</td></tr>
	
	</table>
	
	
	
	