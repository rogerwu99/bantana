       <div id="beta" class="section-1">
           <div class="clear"></div>
			<div id="content8">
		<?php if ($user['latitude']!=0): 
				
				echo $form->create('Discount');
				?>
				<table><tr><th class="corp_td" colspan=2><? echo $form->input('text', array('type'=>'text','label'=>'Input Discount  ', 'class'=>'text_field_med')); 
			?></th>
			
				<th class="corp_td">
		<!--	 Value (0=low, 10=high):		
		<div id="track1" style="background-image:url(/img/bg-fader.gif); background-repeat:no-repeat; width:209px; height:28px;">
	    	<div id="handle1" style="background-image:url(/img/thumb-n.gif); background-repeat:no-repeat; margin-top:5px; width:17px; height:21px; cursor:move;"> </div>
		</div>
		<input id="d_val" name="data[Discount][value]" type="hidden">
		<span id="debug1">&nbsp;</span>
		-->
		Value (0=low, 10=high):          <?php 
		$ranges=range(1,10);
		echo $form->input('Value', array('type'=>'select','options'=>$ranges,'selected'=>5, 'label' => false, 'class' => '' )); 
		?>
	
		</th>	

			
			
			</tr>
			
			
			
			<tr><td  class="corp_td" style="width:150px;">Start</td><td  class="corp_td" style="width:300px;"><?php echo $form->input('Start_Time',array('type'=>'time','label'=>false )); ?></td><td  class="corp_td" style="width:300px;">
				<?php echo $form->input('Start_Day',array('type'=>'date','label'=>false)); ?></td></tr>
				<tr><td class="corp_td"  style="width:150px;">End</td><td class="corp_td"><?php echo $form->input('End_Time',array('type'=>'time','label'=>false)); ?></td><td  class="corp_td">
				<?php echo $form->input('End_Day',array('type'=>'date','label'=>false)); ?></td></tr>
				<tr><td colspan=3  class="corp_td"><?php
					echo $ajax->submit('Post', array('url'=> array('controller'=>'discounts', 'action'=>'create'), 'update' => 'most_recent'));
					echo $form->end();
				?></td></tr>
				</table>
				
				<table>	<tr><th class="corp_td" colspan=5>YOUR LAST DISCOUNTS</th></tr></table>
					
					<div id="most_recent"></div>
		<?	$results = $this->requestAction('discounts/get/'.$_Auth['User']['id']); ?>
		
	  <?php echo $form->create('Discounts'); ?>
		
		<?php foreach ($results as $key=>$value){?>
	<?php $div_name = 'div_'.$results[$key]['Discount']['id']; ?>
	<div id='<? echo $div_name; ?>'>
	<table><tr><td colspan = 2 rowspan=2 class="corp_td">
	<? echo $results[$key]['Discount']['text'];?> | Value: &nbsp; 
	<?	echo $results[$key]['Discount']['value'];
	?>
	
	<td  class="corp_td">
	<?php echo $ajax->link('Edit', array('controller'=>'discounts', 'action'=>'edit',$results[$key]['Discount']['id']), array( 'update' => $div_name)); ?>
	</td></tr>
    <tr>
        <td  class="corp_td">
		<?php echo $html->link('Delete', array('controller'=>'discounts', 'action'=>'delete',$results[$key]['Discount']['id']),array(),'Are you sure you want to delete this?', false); ?>

	</td></tr>
<tr><td class="corp_td" rowspan= 1>
	
	<? echo $results[$key]['Discount']['start'];?>
	</td><td  class="corp_td" rowspan= 1 >
	<?  $now = strtotime(date('Y-m-d H:i:s'));
		$exp = strtotime($results[$key]['Discount']['end']);
	if ($exp < $now) : 
	?>
    <span style="color:#F00">
		<? echo $results[$key]['Discount']['end']; ?>
    </span>
    <? else: ?>
    	<? echo $results[$key]['Discount']['end']; ?>
    <? endif; ?>
	</td>
    	<td  class="corp_td">
	<?php echo $ajax->link('View', array('controller'=>'discounts', 'action'=>'getusers',$results[$key]['Discount']['id']), array( 'update' => 'userlist_'.$results[$key]['Discount']['id'])); ?>
	</td></tr>
	</table>
</div>
<?php $div_update = 'userlist_'.$results[$key]['Discount']['id']; ?>
<div id='<?php echo $div_update; ?>' ></div>
  		
	
	
	<?php } ?>
		
		
	
			
		 	<? endif; ?> 
	 		</div>
			</div>
			<script type="text/javascript">
		/*	var slide = new Control.Slider('handle1', 'track1', {
			range: $R(0,10),
			values: [0,1,2,3,4,5,6,7,8,9,10],
				onSlide: function(v) { $('debug1').innerHTML = 'Value: ' + v; $('horizontal-slider').value = v; $('d_val').value=v;},
				onChange: function(v) { $('debug1').innerHTML = 'Value: ' + v; $('horizontal-slider').value = v; $('d_val').value=v; },
				sliderValue: 5,
				});
			slide.setValue(5);
	*/
			</script>
			