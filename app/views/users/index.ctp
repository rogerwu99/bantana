<div class="users index">
<?php //$session->flash(); ?>
<h2><?php __('Users');?></h2>
	
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('first_name');?></th>
	<th><?php echo $paginator->sort('last_name');?></th>
	<th><?php echo $paginator->sort('email');?></th>
	<th>Groups</th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
	<th>Beta</th>
</tr>
<?php
$i = 0;
foreach ($users as $user):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $user['User']['id']; ?>
		</td>
		<td>
			<?php echo $user['User']['first_name']; ?>
		</td>
		<td>
			<?php echo $user['User']['last_name']; ?>
		</td>
		<td>
			<?php echo $user['User']['email']; ?>
		</td>
		<td>
			<?php foreach($user['Group'] as $group): ?>
			    <?php echo $group['name']; ?>
			    <?php if($group['name']=='Beta'): $beta_flag=1; else: $beta_flag=0; endif; ?>
			    <br/>
			<?php endforeach; ?>
		</td>			
		<td>
			<?php echo $user['User']['created']; ?>
		</td>
		<td>
			<?php echo $user['User']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $user['User']['id'])); ?>
			<?php //echo $html->link(__('Edit', true), array('action'=>'edit', $user['User']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?>
		</td>
		<td class="actions">
			<?php if($beta_flag==0): ?>
			    <?php echo $html->link('Send Invite', array('controller'=>'users','action'=>'add_to_beta', $user['User']['id'])); ?>
			<?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New User', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Hotspots', true), array('controller'=> 'hotspots', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('List Klicks', true), array('controller'=> 'klicks', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('List Videos', true), array('controller'=> 'videos', 'action'=>'index')); ?> </li>
	</ul>
</div>
