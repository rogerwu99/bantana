<?php
Configure::write('current_url', 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT']);

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
		$user_id = $user['id'];
		$user_name = $user['username'];
		$url = 'http://www.WaftMe.com?uId='.$user_id.'&userName='.$user_name;
		$this->redirect('http://google.com'); 
    }
    
 	
 
    
  
    
    function get_videos()
    {
        $user_id = $this->Auth->getUserId();
       
    }
    
    	
    
    function view_my_profile($page = 1)
    {
			$id = $this->Auth->getUserId();
            $profile = $this->User->findById($id);
		//	echo Configure::read('current_url').' dude';
			
			
			
    }
    function view_my_location($page = 1)
    {
			$id = $this->Auth->getUserId();
            $profile = $this->User->findById($id);
			
			
    }
    
}


?>
