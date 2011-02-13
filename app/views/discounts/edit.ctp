<?php $div_name = 'div_'.$results['Discount']['id']; ?>
<?php echo $form->create('Discount'); ?>
	<table><tr><td colspan=3 class="corp_td">
	<?php echo $form->input('Text',array('type'=>'text','label'=>'Discount Description  ','value'=>$results['Discount']['text'])); ?>
	</td>
	<td class="corp_td">Value (0=low, 10=high):          <?php 
		$ranges=range(1,10);
		echo $form->input('Value', array('type'=>'select','options'=>$ranges,'selected'=>$results['Discount']['value'], 'label' => false, 'class' => '' )); 
		?>
	
		</td>	

	
	
	
	
	</tr><tr><td  class="corp_td" colspan=2>Start</td><td  class="corp_td">
	<?php echo $form->input('Start_Time',array('type'=>'time','selected'=>$shour.':'.$smin.':00', 'label'=>false )); ?>
	</td><td  class="corp_td">
	<?php echo $form->input('Start_Day',array('type'=>'date','selected'=>$syear.'-'.$smonth.'-'.$sday,'label'=>false)); ?>
	</td></tr><tr><td  class="corp_td" colspan=2>End</td><td  class="corp_td">
	<?php echo $form->input('End_Time',array('type'=>'time','selected'=>$ehour.':'.$emin.':00','label'=>false)); ?>
	</td><td  class="corp_td">
	<?php echo $form->input('End_Day',array('type'=>'date','selected'=>$eyear.'-'.$emonth.'-'.$eday,'label'=>false)); ?>
	</td></tr>
	<tr><td  class="corp_td" colspan=2>
	<?php echo $ajax->submit('Change',array('url'=>array('controller'=>'discounts','action'=>'update',$results['Discount']['id']),'update'=>$div_name)); ?>
	</td><td  class="corp_td" colspan=2 align='right'>
	<?php echo $html->link('Cancel',array('controller'=>'beta','action'=>'index'),array(),'Are you sure you want to abandon changes?', false); ?>
<?php echo $form->end(); ?>
	</td></tr>
	</table>
