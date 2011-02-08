<?php $div_name = 'div_'.$results['Discount']['id']; ?>
<table><tr><td>
	<?php echo $form->create('Discount'); ?>
	<?php echo $form->input('Text',array('type'=>'text','label'=>false,'value'=>$results['Discount']['text'])); ?>
	</td><td>
	<?php echo $form->input('Start_Time',array('type'=>'time','selected'=>$shour.':'.$smin.':00', 'label'=>false )); ?>
	<?php echo $form->input('Start_Day',array('type'=>'date','selected'=>$syear.'-'.$smonth.'-'.$sday,'label'=>false)); ?>
	</td><td>
	<?php echo $form->input('End_Time',array('type'=>'time','selected'=>$ehour.':'.$emin.':00','label'=>false)); ?>
	<?php echo $form->input('End_Day',array('type'=>'date','selected'=>$eyear.'-'.$emonth.'-'.$eday,'label'=>false)); ?>
	</td><td>
	<?php echo $ajax->submit('Change',array('url'=>array('controller'=>'discounts','action'=>'update',$results['Discount']['id']),'update'=>$div_name)); ?>
	<?php echo $form->end(); ?>
	</td></tr>
	
	</table>
	