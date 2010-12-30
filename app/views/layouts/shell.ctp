<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Klickable</title>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8"></META>
	<?php echo $scripts_for_layout ?>
	<?php echo $html->css('main'); ?>
	<!--[if IE 6]>
	  <?php echo $html->css('ie6'); ?>
	<![endif]-->
</head>
<body>
	<div id="frame">
		<div id="mid_col">
			<?php echo $html->link('<div id="logo" class="float_left"></div>', '/', array(), false, false); ?>
		    <div id="content">
		    	<?php echo $content_for_layout; ?>
			</div>
		</div>
	</div>
</body>
</html>