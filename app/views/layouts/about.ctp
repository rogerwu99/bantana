<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Moo Crunch</title>
	<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8"></META>
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" ></link>

	<?php //echo $html->css('main'); ?>
	<?php //echo $html->css('menu'); ?>
	<?php echo $html->css('style'); ?>
	<?php echo $html->css('type'); ?>
	<?php echo $html->css('validation'); ?>
	<!--[if IE 6]>
	  <?php echo $html->css('ie6'); ?>
	<![endif]-->
        <!--[if IE 7]>
          <?php echo $html->css('ie7'); ?> 
        <![endif]-->
        <!--[if IE 8]>
          <?php echo $html->css('ie7'); ?> 
        <![endif]-->

</head>
<body onload="PStrength.init(); MM_preloadImages('img/klickable_create_your_video_over.jpg','img/klickable_publish_over.jpg','img/klickable_make_money_over.jpg')">
  <!--<div id="loginbar">
      <div id="loginbarwrapper">
        <div id="loginbarcontainer"></div>
    </div>
    </div>
    <div id="loginbarborder"></div>
  --> <div id="bkgrnd">
      <div id="wrapper">
        <div id="maincontent">

          <div id="content">
            <div id="roundedtopwrapper">
              <div id="topleftcorner"></div>
              <div id="topcenterborderwrapper">
                <div id="topcenterborder"></div>
              </div>
              <div id="toprightcorner"></div>
            </div>
            <div id="maincontentwrapper">
              <div id="shadowleft"></div>
              <div id="contentwrapper">
                <div id="leftcolumn">
					<?php echo $content_for_layout; ?>
            	</div>
				<div id="rightcolumn"></div>
				</div>
				</div>
            </div>
          </div>
        </div>
        <div id="roundedbottomwrapper">
          <div id="bottomleftcorner"></div>

          <div id="bottomcenterborderwrapper">
            <div id="bottomcenterborderfiller"></div>
            <div id="bottomcenterborder"></div>
          </div>
          <div id="bottomrightcorner"></div>
        </div>
        <div id="footer">
		<?php //echo $this->element('footer'); ?>
        </div>
      </div>
    </div>


</div></div>
	<script type="text/javascript">
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
		</script>
		<script type="text/javascript">
		var pageTracker = _gat._getTracker("UA-1271462-7");
		pageTracker._trackPageview();
	</script>
        <?php echo $javascript->link('jquery-1.2.6.min.js'); ?>
        <?php echo $javascript->link('form.js'); ?>
        <?php echo $javascript->link('hint.js'); ?>
        <?php echo $javascript->link('ready.js'); ?>
        <?php echo $javascript->link('corner.js'); ?>
        <?php echo $javascript->link('jquery.selectbox.js'); ?>
        <?php echo $javascript->link('tiny_mce/tiny_mce.js'); ?>
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
	<?php echo $javascript->link('MM_Swap.js'); ?>

</body>
</html>
