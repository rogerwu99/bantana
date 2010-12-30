<?php 
App::import('Vendor', 'facebook');
class AppController extends Controller 
{
  var $components = array('Auth', 'RequestHandler', 'Utils', 'Zend.Amf');
  var $helpers = array('Session', 'Javascript', 'Form', 'Text', 'Html', 'Crumb');
  var $uses = array('User');

   
	var $facebook;
    
	 function beforeFilter() 
    {
	    $this->RequestHandler->setContent('json', 'text/x-json');
		
		$facebook = new Facebook(array(
			'appId'=>'175485662472361',
			'secret'=>'4b66d239e574be89813bba4457b97a36',
			'cookie'=>true
		));
		$session=$facebook->getSession();
	
		if(empty($session)){
          //  $this->redirect(array('controller'=>'users','action'=>'login'));
		}
	
            if(!empty($user_record)):
				
				$user_record_1=array();
				$user_record_1['Auth']['username']=$user_record['User']['username'];
				$user_record_1['Auth']['password']=$user_record['User']['password'];
				$this->Auth->authenticate_from_twitter($user_record_1['Auth']);
				$this->redirect('/');
			endif;
//		endif;
	}
	
		
	
	
	
	function _login()
  {	
  	if(is_array($this->data) && array_key_exists('Auth',$this->data) )
    { 
	  $check_auth=$this->Auth->authenticate_from_post($this->data['Auth']);
      $this->data['Auth']['password'] = '';
      if ($check_auth)
      {
	  		if (empty($this->data['Auth']['flash']))
			{
            	$this->redirect(array('controller'=>'beta','action'=>'index'));
      		}
			else
			{
				$user_id = $this->Auth->getUserId();
			}
	  }
      else
      {	//echo 'cool';
            $this->redirect(array('controller'=>'users','action'=>'login'));
      }
    }
	
  }
  
  function logout()
  {
    $this->Auth->logout();
  }

}

?>