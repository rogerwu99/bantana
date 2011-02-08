       <div id="beta" class="section-1">
           <div class="clear"></div>
			<div id="content8">
			<div class="bodycopy">
			<?php if ($user['latitude']!=0): 
				echo $form->create('Discount');
				echo $form->input('text', array('label'=>'Input Discount', 'class'=>'', 'style'=>'width:217px')); 
			?>
				<table><tr><td>Start</td><td><?php echo $form->input('Start_Time',array('type'=>'time','label'=>false )); ?></td><td>
				<?php echo $form->input('Start_Day',array('type'=>'date','label'=>false)); ?></td></tr>
				<tr><td>End</td><td><?php echo $form->input('End_Time',array('type'=>'time','label'=>false)); ?></td><td>
				<?php echo $form->input('End_Day',array('type'=>'date','label'=>false)); ?></td></tr>
				<tr><td colspan=3><?php
					echo $ajax->submit('Post', array('url'=> array('controller'=>'discounts', 'action'=>'create'), 'update' => 'most_recent'));
					echo $form->end();
				?></td></tr>
				</table>
					Your Last Discounts
					
					<div id="most_recent"></div>
		<?	$results = $this->requestAction('discounts/get/'.$_Auth['User']['id']); ?>
		
	  <?php echo $form->create('Discounts'); ?>
		
		<?php foreach ($results as $key=>$value){?>
	<?php $div_name = 'div_'.$results[$key]['Discount']['id']; ?>
	<div id='<? echo $div_name; ?>'>
	<table><tr><td>
	<?php //echo $form->input('Address',array('type'=>'text','label'=>false,'value'=>$results[$key]['Discount']['text'])); ?>
	<? echo $results[$key]['Discount']['text'];?>
	</td><td>
	<? echo $results[$key]['Discount']['start'];?>
	</td><td>
	<? echo $results[$key]['Discount']['end']; ?>
	
	</td><td>
	<?php echo $html->link('Delete', array('controller'=>'discounts', 'action'=>'delete',$results[$key]['Discount']['id']),array(),'Are you sure you want to delete this?', false); ?>
</td><td>
	<?php echo $ajax->link('Edit', array('controller'=>'discounts', 'action'=>'edit',$results[$key]['Discount']['id']), array( 'update' => $div_name)); ?>
	
	</td></tr>
	
	</table>
	</div>
  		
	
	
	<?php } ?>
		
	   
	
			
		 	<? endif; ?> 
	 		</div>
			</div>
			</div>		