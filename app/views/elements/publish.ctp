<div class="msg_head">
	<div class="fat_head  green">
	</div>
	<h3>Publish</h3>
	<div class="little_head green"></div>
</div>
<div class="msg_body">
		<?php $content = $this->requestAction('static_pages/get_page/publish'); ?>
		<?php //pr($about); ?>
		<div class="body">
			<?php echo html_entity_decode($text->truncate($content[0]['StaticPage']['body'], 300, '...', false, false)); ?>
			<?php echo $html->link('More', '/pages/publish'); ?> 
		</div>
	<div class="little_head green"></div>
</div>