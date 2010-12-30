<div class="users form">
<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Add User');?></legend>
	<?php
		echo $form->input('first_name');
		echo $form->input('last_name');
		echo $form->input('email');
		echo $form->input('new_password', array('type' => 'password'));
		echo $form->input('confirm_password', array('type' => 'password'));
		//pr($groups);
		
		//echo $form->select('Group.id', array($groups[0]['Group']['id']=>$groups[0]['Group']['name']));
	?>
		<select id="GroupId" name="data[Group][id]">
			<?php foreach($groups as $group): ?>
				<?php if($group['Group']['name'] != 'Root'): ?>
					<option value="<?php echo $group['Group']['id']; ?>"><?php echo $group['Group']['name']; ?></option>
				<?php endif; ?>
			<?php endforeach; ?>
		</select>
		
		</fieldset>
<?php echo $form->end('Submit');?>
</div>
