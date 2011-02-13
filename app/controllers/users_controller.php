<?php
App::import('Vendor', 'oauth', array('file' => 'OAuth'.DS.'oauth_consumer.php'));
App::import('Vendor', 'facebook');
	
class UsersController extends AppController {

	var $name = 'Users';
	var $helpers = array('Html', 'Form');
	var $components = array('Auth', 'Recaptcha', 'Email','Paypal','Ssl');//,'Uploader.Uploader');
	var $uses = array('User', 'Mail', 'Available');
	var $facebook;
	var $twitter_id;
//	var $root_url = "http://localhost:8888";

	function pass(){
		$this->Session->write('url_params', $this->params['url']);
		$this->redirect('/');
	}
	function logout()
	{
		$user=$this->Auth->getUserInfo();
		$avail=$this->Available->findByUserId((int)$user['id']);
		//var_dump($this->Available->findByUserId((int)$user['id']));
//var_dump($this->Available->findByUserId(50));
		$this->Available->read(null, $avail['Available']['id']);
		$this->Available->set('available' , false);
		$this->Available->save();
			
		//$root_url = "http://localhost:8888";
	
		$facebook = $this->createFacebook();
		$session=$facebook->getSession();
		$url = $facebook->getLogoutUrl(array('req_perms' => 'email,user_birthday,user_about_me,user_location,publish_stream','next' => ROOT_URL));

		$this->Session->destroy();
		
// when i logout with twitter only, i get redirected to facebook?

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
	
	function getRequestURL(){
	 //$root_url = "http://localhost:8888";

		$consumer=$this->createConsumer();
		$requestToken = $consumer->getRequestToken('http://twitter.com/oauth/request_token', ROOT_URL.'/users/twitterCallback');
  		$this->Session->write('twitter_request_token', $requestToken);
		$this->redirect('http://twitter.com/oauth/authenticate?oauth_token='.$requestToken->key);
		exit();
	}
	
	function twitterCallback() {
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
	public function register(){
		$email = $this->data['Users']['email'];
		$this->data=array();
		$this->User->create();
		$this->data['User']['email'] = (string) $email;
		$password = $this->data['User']['password']= $this->__randomString();
		$username = $this->data['User']['username']= (string) $email;
		
		$this->User->save($this->data);
		
		$user_record_1=array();
		$user_record_1['Auth']['username']=$username;
		$user_record_1['Auth']['password']=$password;
		$joe = $username;
		$this->Auth->authenticate_from_oauth($user_record_1['Auth']);
		$this->redirect(array('controller'=>'mail', 'action'=>'send_welcome_message', $email, $joe));//$this->data['User']['name']));
		$this->redirect('/');
	
	}
	public function corporate(){
		$this->layout='default';
		$this->set('ranges',range(1,25)); 
	}
	
	public function corpReg(){
		$ch=curl_init();
		$email = $this->data['User']['Email'];
		$address_raw = $this->data['User']['Address'];
		$address1 = str_replace('+','%20',urlencode($this->data['User']['Address']));
		$zip = $this->data['User']['Zip'];
		$range = $this->data['User']['Range'];
		$name=$this->data['User']['Name'];
		$password = $this->data['User']['new_password'];
		$this->data=array();
		$this->User->create();
		
		    
		$this->data['User']['name']=$name;
		$this->data['User']['email'] = (string) $email;
		$this->data['User']['address']=$address_raw;
		
//		service_call to waft.me
		
		
		//replace spaces in address1 with escape cahrs
		
		
		
	
		$this->data['User']['range'] = $range;
	
		$url="http://local.yahooapis.com/MapsService/V1/geocode?appid=89YEQTHIkY2SU4r0q7se6KONjW1X8WhRKA--&street=".$address1."&zip=".$zip;
//http://where.yahooapis.com/geocode?q=1600+Pennsylvania+Avenue,+Washington,+DC&appid=[yourappidhere]
		$xmlObject = simplexml_load_string(file_get_contents($url));
		
		
		$lat=$xmlObject->Result->Latitude;
		$long=$xmlObject->Result->Longitude;
		
	
		$this->data['User']['longitude']=(float) $long;
		$this->data['User']['latitude']= $lat;
		
		$password = $this->data['User']['password'] = $this->Auth->hasher($password); 
		$username = $this->data['User']['username']= (string) $email;
		$this->data['User']['path']='default.png';
		$this->User->save($this->data);
		$user_record_1=array();
		$user_record_1['Auth']['username']=$username;
		$user_record_1['Auth']['password']=$password;
		$joe = $username;
		$this->Auth->authenticate_from_oauth($user_record_1['Auth']);
		$this->redirect(array('controller'=>'mail', 'action'=>'send_welcome_message', $email, $joe));//$this->data['User']['name']));
		$this->redirect('/');
	
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
				$this->data['User']['tokens']=50;
				$password = $this->data['User']['password']= $this->__randomString();
				$username = $this->data['User']['username']= (string) $email_address;
			
			}
			$this->User->save($this->data);
			$id = $this->User->id;
		//	echo $id;
			$update_available = $this->Available->find('first', array('conditions' => (array('Available.user_id'=>$id))));
			if (!empty($update_available)){
					$this->Available->create();
			}
			else {
				$this->Available->read(null, $update_available['Available']['id']);
			}
			$this->Available->set(array(
											'user_id' => $id,
											'available' => true
											));
			$this->Available->save();
			
			$user_record_1=array();
			$user_record_1['Auth']['username']=$username;
			$user_record_1['Auth']['password']=$password;
			$joe = $username;
			$this->Auth->authenticate_from_oauth($user_record_1['Auth']);
	
			if (!$update){
				//$this->redirect(array('controller'=>'mail', 'action'=>'send_new_registrant', $email_address, $joe));//$this->data['User']['name']));
				$this->redirect(array('controller'=>'mail', 'action'=>'send_welcome_message', $email_address, $joe));//$this->data['User']['name']));
			}
			else {
				$this->redirect('/');
			}
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
		//$root_url = 'http://localhost:8888';
		$full_url = ROOT_URL . '/users/fbCallback';
		$login_url = $facebook->getLoginUrl(array('req_perms' => 'email,user_birthday,user_about_me,user_location,publish_stream','next' => $full_url));
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
	function edit(){
	 if(is_null($this->Auth->getUserId())){
                       Controller::render('/deny');
         }
		if (!empty($this->data)) {
			$name=$this->data['User']['Name'];
			$password = $this->Auth->hasher($this->data['User']['new_password']);

			$this->User->read(null,$this->Auth->getUserId());
			$this->User->set(array(
								   'password'=>$password,
								   'name'=>$name
								   ));
	        $this->User->save();
			$username=$this->User->read('username',$this->Auth->getUserId());
			$user_record_1=array();
			$user_record_1['Auth']['username']=$username['User']['username'];
			$user_record_1['Auth']['password']=$password;
			$this->Auth->authenticate_from_oauth($user_record_1['Auth']);
	        $this->redirect(array('controller'=>'beta', 'action'=>'view_my_profile'));
		}
	}
	function edit_pic(){
		 if(is_null($this->Auth->getUserId())){
                       Controller::render('/deny');
         }
		if (!empty($this->data)) {
			//	var_dump($this->data);
			App::import('Vendor', 'upload');
	        
	        
 			$typelist=split('/', $_FILES['data']['type']['User']['photo']);
			$allowed[0]='xxx';
            $allowed[1]='gif';
            $allowed[2]='jpg';
            $allowed[3]='jpeg';
            $allowed[4]='png';
            
			$allowed_val='';
            $allowed_val=array_search($typelist[1], $allowed);

			if (!$allowed_val){
				$this->Session->setFlash('<span class="bodycopy" style="color:red;">Profile picture must be gif, jpg or png only.</span>');
			}
	        
	    	else if(!empty($this->data) && $this->data['User']['photo']['size']>0){
	          
				$file = $this->data['User']['photo']; 
	            $handle = new Upload($file);

	            if ($handle->uploaded){
					if($handle->image_src_x >= 100){
						$handle->image_resize = true;
		    			$handle->image_ratio_y = true;
		    			$handle->image_x = 100;
		    			
		    			if($handle->image_y >= 100){
		    				$handle->image_resize = true;
			    			$handle->image_ratio_x = true;
			    			$handle->image_y = 100;
		    			}
					}
	    			$handle->Process('img/uploads');
				
				}
	            if(!is_null($handle->file_dst_name) && $handle->file_dst_name!=''){
					$user_path = $handle->file_dst_name;
				}
               
  	            $handle->clean();
	            $this->User->read(null,$this->Auth->getUserId());
				$this->User->set('path', $user_path);
  	        	$this->User->save();
  	        }
         
	        $this->redirect(array('controller'=>'beta', 'action'=>'view_my_profile'));
	        exit;
	    }
	}
	
	
	
	
function _get($var) {
    return isset($this->params['url'][$var])? $this->params['url'][$var]: null;
}
    
function expressCheckout($step=1){
 // $this->Ssl->force();
    $this->set('step',$step);
	 //first get a token
    if ($step==1){
        $paymentInfo['Order']['theTotal']= 5;
        $paymentInfo['Order']['returnUrl']= "http://localhost:8888/users/expressCheckout/2/";
        $paymentInfo['Order']['cancelUrl']= "http://localhost:8888";
            
        // call paypal
        $result = $this->Paypal->processPayment($paymentInfo,"SetExpressCheckout");
        $ack = strtoupper($result["ACK"]);
        
	//	var_dump( $result );
		
		//Detect Errors
        if($ack!="SUCCESS")
            $error = $result['L_LONGMESSAGE0'];
        else {
			// send user to paypal
            $token = urldecode($result["TOKEN"]);
            $payPalURL = PAYPAL_URL.$token;
            $this->redirect($payPalURL);
		 }
    }
    //next have the user confirm
    elseif($step==2){
        //we now have the payer id and token, using the token we should get the shipping address
        //of the payer. Compile all the info into the session then set for the view.
        //Add the order total also
        $result = $this->Paypal->processPayment($this->_get('token'),"GetExpressCheckoutDetails");
        $result['PAYERID'] = $this->_get('PayerID');
        $result['TOKEN'] = $this->_get('token');
        $result['ORDERTOTAL'] = .01;
        $ack = strtoupper($result["ACK"]);
        //Detect errors
        if($ack!="SUCCESS"){
            $error = $result['L_LONGMESSAGE0'];
            $this->set('error',$error);
        }
        else {
            $this->set('result',$this->Session->read('result'));
            $this->Session->write('result',$result);
            /*
             * Result at this point contains the below fields. This will be the result passed 
             * in Step 3. I used a session, but I suppose one could just use a hidden field
             * in the view:[TOKEN] [TIMESTAMP] [CORRELATIONID] [ACK] [VERSION] [BUILD] [EMAIL] [PAYERID]
             * [PAYERSTATUS]  [FIRSTNAME][LASTNAME] [COUNTRYCODE] [SHIPTONAME] [SHIPTOSTREET]
             * [SHIPTOCITY] [SHIPTOSTATE] [SHIPTOZIP] [SHIPTOCOUNTRYCODE] [SHIPTOCOUNTRYNAME]
             * [ADDRESSSTATUS] [ORDERTOTAL]
             */
        }
    }
    //show the confirmation
    elseif($step==3){
        $result = $this->Paypal->processPayment($this->Session->read('result'),"DoExpressCheckoutPayment");
    //Detect errors
        $ack = strtoupper($result["ACK"]);
        if($ack!="SUCCESS"){
            $error = $result['L_LONGMESSAGE0'];
            $this->set('error',$error);
        }
        else {
            $this->set('result',$this->Session->read('result'));
        }
    }
}

	
	
	
}
?>