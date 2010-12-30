<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Klickable</title>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8"></META>
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"></link>

	<?php echo $javascript->link('jquery-1.2.6.min.js'); ?>
	<?php echo $javascript->link('form.js'); ?>
	<?php echo $javascript->link('hint.js'); ?>
	<?php echo $javascript->link('ready.js'); ?>
	<?php echo $javascript->link('beta.js'); ?>
	<script type="text/javascript">
	$(document).ready(function()
	{
	  //hide the all of the element with class msg_body
	  $(".msg_body").hide();
	  //toggle the componenet with class msg_body
	  $(".msg_head").click(function()
	  {
	    $(this).next(".msg_body").slideToggle(100);
	  });
	});
	</script>	
	<?php echo $scripts_for_layout ?>
	<?php echo $html->css('main'); ?>
	<?php echo $html->css('menu'); ?>
	
	<!--[if IE 6]>
	  <?php echo $html->css('ie6'); ?>
	<![endif]-->
</head>
<body>
	<div id="frame">

		<div id="mid_col">
			<?php echo $html->link('<div id="logo" class="float_left"></div>', '/', array(), false, false); ?>
		    <div id="content">	
				<?php echo $this->element('logo'); ?>
			    <?php echo $content_for_layout; ?>
			</div>
		</div>
		<div id="r_col">
			<?php if($_Auth['Access']['Beta']==1): ?>
				<div id="forms">
					<div id="signup">
						<?php echo $this->element('signup'); ?>
					</div>
					<div id="login">
						<?php echo $this->element('login'); ?>
					</div>
				</div>
				<div id="beta_menu">
					<?php echo $this->element('beta_menu'); ?>
				</div>
				<div class="block">
					<?php echo $this->element('recent_posts'); ?>
				</div>
				<div class="block">
					<?php echo $this->element('recent_press'); ?>
				</div>
			<?php else: ?>    
				<div id="forms">
					<div id="signup">
						<?php echo $this->element('signup'); ?>
					</div>
					<div id="login">
						<?php echo $this->element('login'); ?>
					</div>
				</div>
				<div id="www">
					<?php echo $this->element('www'); ?>
				</div>
				<div id="join">
					<?php echo $this->element('join'); ?>
				</div>
			<?php endif; ?>
		</div>
		
		<div class="clear"></div>
		<div id="footer">
			<?php echo $this->element('footer'); ?>
		</div>
	</div>
	
	<script type="text/javascript">
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
		</script>
		<script type="text/javascript">
		var pageTracker = _gat._getTracker("UA-1271462-7");
		pageTracker._trackPageview();
	</script>
</body>
</html>