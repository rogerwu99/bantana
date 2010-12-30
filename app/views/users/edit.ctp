<div class="users form">
<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Edit User');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('first_name');
		echo $form->input('last_name');
		echo $form->input('email');
		echo $form->input('user_name');
		echo $form->input('password');
		echo $form->input('salt');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('User.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('User.id'))); ?></li>
		<li><?php echo $html->link(__('List Users', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Hotspots', true), array('controller'=> 'hotspots', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Hotspot', true), array('controller'=> 'hotspots', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Klicks', true), array('controller'=> 'klicks', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Klick', true), array('controller'=> 'klicks', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Videos', true), array('controller'=> 'videos', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Video', true), array('controller'=> 'videos', 'action'=>'add')); ?> </li>
	</ul>
</div>
