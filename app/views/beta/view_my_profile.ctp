<div id="beta" class="section-1">
           <div id="contents">
		  <?php if(!empty($_Auth['User']['fb_uid'])): ?>
     Your Best 500 Friends
	 <?php $friends = $this->requestAction('/users/get_friends'); 
				$x = 0;
				foreach ($friends as $friend){
					?>
					<a href="http://facebook.com/profile.php?id=<?php echo $friend['id'];?>"><img src="http://graph.facebook.com/<?php echo $friend['id']; ?>/picture?type=square" width=15 height=15 border=0 alt=<?php echo $friend['name'];?>></a>
				<?php
					$x++;
					if ($x>500) break;
				}
		  endif; ?>
			       	
		</div>
	</div>
	<br/>
	
	<div class="clear"></div>
	