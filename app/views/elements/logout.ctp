<?php //echo $html->link($html->image("beta_join.gif"), array('controller'=>'users', 'action' => 'register'), array('escape' => false)); ?>

          <div id="loginbar">
                <div id="loginbarwrapper">
                        <div id="loginbarcontainer">
<? echo $html->image('topbar_signout_butt.jpg', array('border'=>"0", 'alt'=>'Sign Out', 'height'=>'43', 'width'=>'90', 'class'=>'bodycopy')); ?>
<?php echo $html->link($html->image("topbar_signout.jpg", array('alt'=>'Click here to signout!', 'width'=>'109', 'height'=>'43', 'border'=>'0', 'class'=>'bodyclass')), array('controller'=>'users', 'action' => 'logout'), array('onclick' => 'FB.Connect.logoutAndRedirect(\'http://localhost:8888/users/logout\')); return false;','escape'=>false)); ?>
                        </div>
                </div>
        </div>
        <div id="loginbarborder"></div>

