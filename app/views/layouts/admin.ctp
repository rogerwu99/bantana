<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $title_for_layout ?></title>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8" ></META>
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"></link>
	<?php echo $javascript->link('tiny_mce/tiny_mce.js'); ?>
	<script type="text/javascript">
	    tinyMCE.init({
	        theme : "simple",
	        mode : "textareas",
	        convert_urls : false,
	        width: 600,
	        height: 500
	    });
	</script> 	
	<?php echo $scripts_for_layout ?>
	<?php echo $html->css('main'); ?>
</head>
<body>
	<div id="frame">
		<div id="admin">
			<div id="mid_col">
				<?php echo $html->link('<div id="logo" class="float_left"></div>', '/', array(), false, false); ?>
				<div id="login" class="float_right">
						<?php echo $this->element('login'); ?>
				</div>
				<div id="admin_menu">
					<?php echo $this->element('admin_menu'); ?>
				</div>
			    <div id="content">	
				    <?php echo $content_for_layout ?>
				</div>
			</div>
			<div class="clear"></div>
			<div id="footer"></div>
		</div>
	</div>
</body>
</html>