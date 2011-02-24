<? if (!isset($error)): ?>
<?php $div_name = 'div_'.$results[$key]['Discount']['id']; ?>
	<div id='<? echo $div_name; ?>'>
	<table><tr><td colspan = 2 rowspan=2 class="corp_td">
	<? echo $discount['Discount']['text'];?> | Value: &nbsp; 
	<?	echo $discount['Discount']['value'];
	?>
	
	<td  class="corp_td">
	<?php echo $ajax->link('Edit', array('controller'=>'discounts', 'action'=>'edit',$discount['Discount']['id']), array( 'update' => $div_name)); ?>
	</td></tr>
    <tr>
        <td  class="corp_td">
		<?php echo $html->link('Delete', array('controller'=>'discounts', 'action'=>'delete',$discount['Discount']['id']),array(),'Are you sure you want to delete this?', false); ?>

	</td></tr>
<tr><td class="corp_td" rowspan= 1>
	<? echo $discount['Discount']['start'];?>
	</td><td  class="corp_td" rowspan= 1 >
	<? echo $discount['Discount']['end']; ?>
	</td>
    	<td  class="corp_td">
	<?php echo $ajax->link('View', array('controller'=>'discounts', 'action'=>'getusers',$discount['Discount']['id']), array( 'update' => 'userlist_'.$discount['Discount']['id'])); ?>
	</td></tr>
	</table>
</div>
<?php $div_update = 'userlist_'.$discount['Discount']['id']; ?>
<div id='<?php echo $div_update; ?>' ></div>
<? endif; ?>
<? if (isset($message)):?>
<script type = "text/javascript">

var message = document.getElementById("confirm_message");
while (message.hasChildNodes()) {
			message.removeChild(message.lastChild);
		}
message.appendChild(document.createTextNode('<? echo $message; ?>'));
//message.style.display="block";

</script>  
<? else: ?>
<? echo $message;?>
<? endif; ?>
