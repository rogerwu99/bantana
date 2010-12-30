<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $title_for_layout ?></title>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8"></META>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

	<?php echo $javascript->link('jquery-1.2.6.min.js'); ?>
	<?php echo $javascript->link('form.js'); ?>
	<?php echo $javascript->link('hint.js'); ?>
	<?php echo $javascript->link('ready.js'); ?>	
	<?php echo $scripts_for_layout ?>
	<?php echo $html->css('main'); ?>
</head>
<body>
	<div id="frame">
		<div id="l_col">
		    <div id="content">	
			    <?php echo $content_for_layout ?>
			</div>
		</div>
		<div id="r_col">
			<div id="forms">
				<div id="signup">
					<?php echo $this->element('signup'); ?>
				</div>
				<div id="login">
					<?php echo $this->element('login'); ?>
				</div>
				<div id="r_col">
					<?php pr('WWWWWWWWWWWWW'); ?>
					<?php echo $this->element('recent_posts'); ?>
				</div>
			</div>
		</div>
		
		<div class="clear"></div>
		<div id="footer"></div>
	</div>
</body>
</html>
