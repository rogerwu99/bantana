<table>
<?php 
if(empty($user_array)){
	echo 'No redemptions yet';
}
else {
	foreach($user_array as $key=>$value){
?><tr><td>
<?		
		echo $user_array[$key]['User']['name'];
		if ($user_array[$key]['User']['fb_pic_url']==''){
			if ($user_array[$key]['User']['tw_pic_url']==''){
				echo $html->image(ROOT_URL.'/img/uploads/'.$user_array[$key]['User']['path'],array('width'=>50,'height'=>50,'alt'=>$user_array[$key]['User']['name']));
			}
			else {
				echo $html->image($user_array[$key]['User']['tw_pic_url'],array('width'=>50,'height'=>50,'alt'=>$user_array[$key]['User']['name']));
			}
		}
		else {
			echo $html->image($user_array[$key]['User']['fb_pic_url'],array('width'=>50,'height'=>50,'alt'=>$user_array[$key]['User']['name']));
		}
		echo 'Redeemed : '.${'user_created'.$user_array[$key]['User']['id']};
		?>
        </td></tr>
        <?
	}
}
?>
</table>