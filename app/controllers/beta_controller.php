<?php

class BetaController extends AppController 
{
    var $name = 'Beta';
    var $uses = array('User', 'Mail'); 
    var $helpers = array('Html', 'Form', 'Javascript', 'Xml', 'Crumb');
    var $components = array('Utils', 'Email', 'RequestHandler');
   
    function index()
    {
    	$this->User->recursive = -1;
	   	$user = $this->Auth->getUserInfo();
		$this->set(compact('user'));
	 
    }
    
 	
 
    
  
    
    function get_videos()
    {
        $user_id = $this->Auth->getUserId();
       
    }
    
    	
    
    function view_my_profile($page = 1)
    {
			$id = $this->Auth->getUserId();
            $profile = $this->User->findById($id);
			
			
    }
    function view_my_location($page = 1)
    {
			$id = $this->Auth->getUserId();
            $profile = $this->User->findById($id);
			
			
    }
    
}


?>
