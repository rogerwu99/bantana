<?php
App::import('Vendor', 'oauth', array('file' => 'OAuth'.DS.'oauth_consumer.php'));
App::import('Vendor', 'facebook');
Configure::write('current_url', 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT']);
		
class UsersController extends AppController {

	var $name = 'Users';
	var $helpers = array('Html', 'Form');
	var $components = array('Auth', 'Recaptcha', 'Email');
	var $uses = array('User', 'Mail');
	var $facebook;
	var $twitter_id;

	function logout()
	{
		$facebook = $this->createFacebook();
		$session=$facebook->getSession();

		$url = $facebook->getLogoutUrl(array('req_perms' => 'email,user_birthday,user_about_me,user_location,publish_stream','next' => Configure::read('current_url')));

		$this->Session->destroy();
		


		if(!empty($session)){
			$facebook->setSession(null);
			$this->Auth->logout($url);
		}
		else {
		    $this->Auth->logout();
		}
	}

	function login()
    {
		$this->layout = 'about';
	}
	
	public function getRequestURL(){
		$consumer=$this->createConsumer();
		$requestToken = $consumer->getRequestToken('http://twitter.com/oauth/request_token', Configure::read('current_url').'/users/twitterCallback');
  		$this->Session->write('twitter_request_token', $requestToken);
		$this->redirect('http://twitter.com/oauth/authenticate?oauth_token='.$requestToken->key);
		exit();
	}
	
	public function twitterCallback() {
		$requestToken = $this->Session->read('twitter_request_token');
		$consumer = $this->createConsumer();
		$accessToken = $consumer->getAccessToken('http://twitter.com/oauth/access_token', $requestToken);
		$this->Session->write('twitter_access_token',$accessToken);
		
		
		
		
		
		$db_results = $this->User->find('first', array('conditions' => (array('User.tw_access_key'=>$accessToken->key)), 'fields'=>(array('User.username', 'User.password'))));
		if (!empty($db_results)) {
			$user_record_1=array();
			$user_record_1['Auth']['username']=$db_results['User']['username'];
			$user_record_1['Auth']['password']=$db_results['User']['password'];
			$this->Auth->authenticate_from_oauth($user_record_1['Auth']);
			$this->redirect('/');
		}
		$this->layout = 'about';
		
  	}
	
	public function verifyEmailAddress(){
		$type = $this->data['User']['oauth'];
		$email_address = $this->data['User']['Email'];
		$this->data = array();
		$this->User->create();
		$username='';
		$password='';
		$udpate = true;
		$db_results = $this->User->find('first', array('conditions' => (array('User.email'=>$email_address))));
		
		// i already have an account - i'm just updating the data with the 2nd social network
		if (!empty($db_results)) {
				$updated_id = $db_results['User']['id'];
				$this->User->read(null,$updated_id);
				switch ($type){
					case 'twitter':
		
						$accessToken=$this->Session->read('twitter_access_token');
						$consumer = $this->createConsumer();
						$content=$consumer->get($accessToken->key,$accessToken->secret,'http://twitter.com/account/verify_credentials.xml', array());
						$user = simplexml_load_string($content);
						$this->data['User']['twitter_handle'] = (string) $user->screen_name;
						$this->data['User']['tw_user_url'] = (string) $user->url;
						$this->data['User']['tw_uid'] = (int) $user->id;
						$this->data['User']['tw_pic_url'] = (string) $user->profile_image_url;
						$this->data['User']['tw_location'] =  (string) $user->location;
						$this->data['User']['tw_access_key'] =  $accessToken->key;
						$this->data['User']['tw_access_secret'] =  $accessToken->secret;
	
						break;
		
					case 'facebook':
						$facebook = $this->createFacebook();
						$session=$facebook->getSession();
						if(!empty($session)){
							try{
								$user=json_decode(file_get_contents('https://graph.facebook.com/me?access_token='.$session['access_token']));
							}
							catch(FacebookApiException $e){
								error_log($e);
							}
							$this->data['User']['fb_uid'] = (int) $user->id;
							$this->data['User']['fb_pic_url'] = 'http://graph.facebook.com/'.$user->id.'/picture';
							$this->data['User']['fb_location'] = '';
							$this->data['User']['fb_access_key'] = $session['access_token'];

							
					}
					break;
				}
				$username = $db_results['User']['username'];
				$password = $db_results['User']['password'];

				
		}
		// new account
		else {
			
			$update = false;
			
			switch ($type){
				case 'twitter':
		
					$accessToken=$this->Session->read('twitter_access_token');
					$consumer = $this->createConsumer();
					$content=$consumer->get($accessToken->key,$accessToken->secret,'http://twitter.com/account/verify_credentials.xml', array());
					$user = simplexml_load_string($content);
					$this->data['User']['type'] = 'twitter';
					$this->data['User']['name'] = (string) $user->name;
					$this->data['User']['email'] = (string) $email_address;
					$this->data['User']['twitter_handle'] = (string) $user->screen_name;
					$this->data['User']['tw_user_url'] = (string) $user->url;
					$this->data['User']['tw_uid'] = (int) $user->id;
					$this->data['User']['tw_pic_url'] = (string) $user->profile_image_url;
					$this->data['User']['tw_location'] =  (string) $user->location;
					$this->data['User']['tw_access_key'] =  $accessToken->key;
					$this->data['User']['tw_access_secret'] =  $accessToken->secret;
	
						
				break;
		
				case 'facebook':
					$facebook = $this->createFacebook();
					$session=$facebook->getSession();
					if(!empty($session)){
						try{
							$user=json_decode(file_get_contents('https://graph.facebook.com/me?access_token='.$session['access_token']));
						}
						catch(FacebookApiException $e){
							error_log($e);
						}
						$this->data['User']['type'] = 'facebook';
						$this->data['User']['name'] = (string) $user->name;
						$this->data['User']['email'] = (string) $email_address;
						$this->data['User']['fb_uid'] = (int) $user->id;
						$this->data['User']['fb_pic_url'] = 'http://graph.facebook.com/'.$user->id.'/picture';
						$this->data['User']['fb_location'] = '';
						$this->data['User']['fb_access_key'] = $session['access_token'];
					}
					break;
				}
				$password = $this->data['User']['password']= $this->__randomString();
				$username = $this->data['User']['username']= (string) $email_address;
			
			}
			$this->User->save($this->data);
			
			$user_record_1=array();
			$user_record_1['Auth']['username']=$username;
			$user_record_1['Auth']['password']=$password;
			$joe = $this->data['User']['name'];
			$this->Auth->authenticate_from_oauth($user_record_1['Auth']);
	
		// THE MAIL IS STILL NOT WORKING .... WTF
		/*	if (!$update){
				$this->Email->to = 'rogerwu99@gmail.com';
        
        		$this->Email->subject = 'NEW REGISTRANT';
        		$this->Email->replyTo = 'robot@klickable.tv';
        		$this->Email->from = 'ROBOT <robot@klickable.tv>';
        		$this->Email->template = 'new_registrant';
        		$this->set('email', $email_address);
        		$this->set('name', $joe); 
        		if ( $this->Email->send() ) {
          			$this->Session->setFlash('Template html email sent');
        		} else {
				    $this->Session->setFlash('Template html email not sent');
        		}
				//$this->redirect(array('controller'=>'mail', 'action'=>'send_new_registrant', $email_address, $joe));//$this->data['User']['name']));
			}
*/			$this->redirect('/');
			
		}
	private  function __randomString($minlength = 20, $maxlength = 20, $useupper = true, $usespecial = false, $usenumbers = true){
        $charset = "abcdefghijklmnopqrstuvwxyz";
        if ($useupper) $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        if ($usenumbers) $charset .= "0123456789";
        if ($usespecial) $charset .= "~@#$%^*()_+-={}|][";
        if ($minlength > $maxlength) $length = mt_rand ($maxlength, $minlength);
        else $length = mt_rand ($minlength, $maxlength);
        $key = '';
        for ($i=0; $i<$length; $i++){
            $key .= $charset[(mt_rand(0,(strlen($charset)-1)))];
        }
        return $key;
    }

	private function createConsumer() {
        return new OAuth_Consumer('3PnqSPtc9vf4jj9sXehROw', 'eY8760Xe74NupOEq4Ey9wzp1rahNo85QCXQ8dAtNCq8');
    }
	private function createFacebook(){
		return new Facebook(array(
			'appId'=>'175485662472361',
			'secret'=>'4b66d239e574be89813bba4457b97a36',
			'cookie'=>true
		));
	}
	public function facebookLogin(){
		$facebook = $this->createFacebook();
		$session=$facebook->getSession();
		$login_url = $facebook->getLoginUrl(array('req_perms' => 'email,user_birthday,user_about_me,user_location,publish_stream','next' => Configure::read('current_url').'/users/fbCallback'));
		if(!empty($session)){
			$this->Session->write('fb_acces_token',$session['access_token']);
			$facebook_id = $facebook->getUser();
	
			$db_results = $this->User->find('first', array('conditions' => (array('User.fb_uid'=>$facebook_id)), 'fields'=>(array('User.username','User.password'))));

			if (!empty($db_results)) {
				//echo 'results not empty';
				$user_record_1=array();
				$user_record_1['Auth']['username']=$db_results['User']['username'];
				$user_record_1['Auth']['password']=$db_results['User']['password'];
				$this->Auth->authenticate_from_oauth($user_record_1['Auth']);
				$this->redirect('/');
			}
			else{
			echo 'empty';
		//	var_dump($session);
				$this->redirect($login_url);
			}
	
		}
		else{
			//echo ' in here';
		//	var_dump($session);
			$this->redirect($login_url);
		}
	}
	
	public function fbCallback(){
		$facebook = $this->createFacebook();
		$session=$facebook->getSession();
			$facebook_id = $facebook->getUser();
	
			$db_results = $this->User->find('first', array('conditions' => (array('User.fb_uid'=>$facebook_id)), 'fields'=>(array('User.username','User.password'))));

			if (!empty($db_results)) {
				//echo 'results not empty';
				$user_record_1=array();
				$user_record_1['Auth']['username']=$db_results['User']['username'];
				$user_record_1['Auth']['password']=$db_results['User']['password'];
				$this->Auth->authenticate_from_oauth($user_record_1['Auth']);
				$this->redirect('/');
			}
		$this->layout = 'page';
	}
	function get_friends(){
		$user_id=array();
		$facebook = $this->createFacebook();
		$session=$facebook->getSession();
		if(!empty($session)){
			try{
				$user=json_decode(file_get_contents('https://graph.facebook.com/me/friends?access_token='.$session['access_token']),true);
				
				foreach ($user['data'] as $friend){
					$user_id[]=$friend;
				}
			}
			catch(FacebookApiException $e){
				echo 'error';
				error_log($e);
			}	
		}
		return $user_id;
	}
	function get_followers($id=null){
		$user_id = array();
		$accessToken=$this->Session->read('twitter_access_token');
		$consumer = $this->createConsumer();
		
		if (!$id) {
			$content = $consumer->get($accessToken->key,$accessToken->secret,'http://twitter.com/account/verify_credentials.xml', array());
			$user = simplexml_load_string($content);
			$id=$user->id;
		}
		
		$content1 = $consumer->get($accessToken->key,$accessToken->secret,'http://api.twitter.com/1/followers/ids.json?user_id='.$id, array());
		$user1 = json_decode($content1);
		$x=0;
		foreach ($user1 as $follower){
			$user_id[]=$follower;
			//echo $follower.' ';
			$content2 = $consumer->get($accessToken->key,$accessToken->secret, 'http://api.twitter.com/1/users/show/'.$follower.'.json',array());
			$user2=json_decode($content2);
			//echo $user2['user']['screen_name'].' '.$user2['user']['profile_image_url'];
			$x++;
			if ($x>20) break;
		}
		
		return $user_id;
		
	}
	
				
	
	
	

	
}
?>
