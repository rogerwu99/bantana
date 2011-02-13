<?php 
if(!empty($_Auth['User']['id']))
{ 
    header('location:'.Router::url('/',true).'beta');
    exit;
}

?>
<?php echo $this->element('manual-login');?>
<?php $javascript->link('AC_RunActiveContent.js', false); ?>
<?php $javascript->link('prototype');?>
<?php $javascript->link('scriptaculous');?>

