<?php
App::import('Vendor', 'oauth', array('file' => 'OAuth'.DS.'oauth_consumer.php'));
App::import('Vendor', 'facebook');
class UsersController extends AppController {

	var $name = 'Users';
	var $helpers = array('Html', 'Form', 'Ajax');
	var $components = array('Auth', 'Email','Paypal');//,'Ssl');
	var $uses = array('User', 'Mail', 'Token', 'Bill');
	var $facebook;
	var $twitter_id;

	
	function logout()
	{
		$user=$this->Auth->getUserInfo();
			
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

	private function createConsumer() {
        return new OAuth_Consumer('3PnqSPtc9vf4jj9sXehROw', 'eY8760Xe74NupOEq4Ey9wzp1rahNo85QCXQ8dAtNCq8');
    }
	
	function getRequestURL(){
	
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
		$this->set('ranges',range(1,25)); 
	}
	
	public function corpReg(){
		if (!empty($this->data)){
			$plan = $this->data['User']['plan'];
			$plan_value = $this->_getPlanCode($plan);
			// need to do some type of confirmation on the zip code and address
		//	var_dump($this->data);
			$email = $this->data['User']['email'];
			$address_raw = $this->data['User']['Address'];
			$address1 = str_replace('+','%20',urlencode($this->data['User']['Address']));
			$zip = $this->data['User']['Zip'];
			$range = $this->data['User']['Range'];
			$name=$this->data['User']['Name'];
			$password = $this->data['User']['new_password'];
			$confirm =$this->data['User']['confirm_password'];
			$this->data=array();
			$this->User->create();
			$this->data['User']['name']=$name;
			$this->data['User']['email'] = (string) $email;
			$this->data['User']['address']=$address_raw;
			$this->data['User']['range'] = $range;
			$this->data['User']['new_password']=$password;
			$this->data['User']['confirm_password']=$confirm;
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
			if ($this->User->save($this->data)) { 
				
				$user_record_1=array();
				$user_record_1['Auth']['username']=$username;
				$user_record_1['Auth']['password']=$password;
				$joe = $username;
				$this->Auth->authenticate_from_oauth($user_record_1['Auth']);
				
				$this->redirect('/users/expressCheckout/1/'.$plan_value.'/co');
			
			
			//decrypt plan
			
			}	
			else { 
				$this->set('errors', $this->User->validationErrors);
				unset($this->data['User']['new_password']);
		    	unset($this->data['User']['confirm_password']);
			}
		}
		else {
			$this->render();
		}
	
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
				$password = $this->data['User']['password']= $this->data['User']['new_password'] = $this->data['User']['confirm_password'] = $this->__randomString();
				$username = $this->data['User']['username']= (string) $email_address;
			
			}
			
			$this->User->save($this->data);
			$id = $this->User->id;
			//echo $id;
		$this->Token->create();
		$this->Token->set(array(
						'user_id'=>$id,
						'tokens'=>50,
						'tokens_updated'=>date("Y-m-d H:i:s")
						));
						$this->Token->save();	
			$this->Bill->create();
			$this->Bill->set(array(
							'user_id'=>$id,
							'amount'=>2
							));
			$this->Bill->save();
			
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
				$this->redirect($login_url);
			}
	
		}
		else{
			$this->redirect($login_url);
		}
	}
	
	public function fbCallback(){
		$facebook = $this->createFacebook();
		$session=$facebook->getSession();
			$facebook_id = $facebook->getUser();
	
			$db_results = $this->User->find('first', array('conditions' => (array('User.fb_uid'=>$facebook_id)), 'fields'=>(array('User.username','User.password'))));

			if (!empty($db_results)) {
				$user_record_1=array();
				$user_record_1['Auth']['username']=$db_results['User']['username'];
				$user_record_1['Auth']['password']=$db_results['User']['password'];
				$this->Auth->authenticate_from_oauth($user_record_1['Auth']);
				$this->redirect('/');
			}
		$this->layout = 'page';
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
	
	function getTokenCount(){
		
	
		$tok = $this->Token->find('first',array('conditions'=>array('Token.user_id'=>$this->Auth->getUserId())));
		return $tok['Token']['tokens'];
		
	}
	
	function getTokenUpdated(){
		$tok = $this->Token->find('first',array('conditions'=>array('Token.user_id'=>$this->Auth->getUserId())));
		return $tok['Token']['tokens_updated'];
	}
	function getUpdateTime(){
		$update_time = $this->getTokenUpdated();
		$eyear=substr($update_time,0,4); 
		$emonth=substr($update_time,5,2);
		$eday=substr($update_time,8,2);
		$ehour=substr($update_time,11,2);
		$emin=substr($update_time,14,2);
		$esec=substr($update_time,17,2);
		return date("Y-m-d H:i:s",mktime($ehour, $emin, $esec, $emonth  , $eday+1, $eyear));	
		
	}
	function getBillCount(){
		$amt = $this->Bill->find('first',array('conditions'=>array('Bill.user_id'=>$this->Auth->getUserId())));
		return $amt['Bill']['amount'];
		
	}
		function emptyBank(){
		
		$user= $this->Auth->getUserInfo();
		$start_date= $this->getTokenUpdated();
		
		$eyear=substr($start_date,0,4); 
		$emonth=substr($start_date,5,2);
		$eday=substr($start_date,8,2);
		$ehour=substr($start_date,11,2);
		$emin=substr($start_date,14,2);
		$esec=substr($start_date,17,2);
		
		$tomorrow  = date_parse(date("Y-m-d H:i:s",mktime($ehour, $emin, $esec, $emonth  , $eday+1, $eyear)));	
		
		$start_tokens = $this->getTokenCount();
		$now= date_parse(date('Y-m-d H:i:s'));
		$diffday = $tomorrow['day']-$now['day'];
		$diffhour= $tomorrow['hour']-$now['hour'];
        
		if ($diffday==0){
			$hours_til_full = $diffhour;		
		}
		else {
			$hours_til_full = 24 - $now['hour'] + $tomorrow['hour'];
			
		}
		$per_hour = FULL_BANK / 24;
	
		
		
		if ($hours_til_full<0){
			$earned=FULL_BANK;
		}
		
		else {
			if ($now['minute'] > $tomorrow['minute']){
				$earned = $per_hour * (24 - $hours_til_full) + $per_hour * ($now['minute']-$tomorrow['minute'])/60;
	//			echo $per_hour * ($now['minute']-$tomorrow['minute'])/60;
		//		echo '<BR>'.'1'.'<BR>';
			}
			else if ($now['minute'] == $tomorrow['minute']){
				$earned = $per_hour * (24 - $hours_til_full);
			//	echo '<BR>'.'2'.'<BR>';
			}
	
			else {
				$earned = $per_hour * (24 - $hours_til_full) + $per_hour * (60-$now['minute']+$tomorrow['minute'])/60;
				//echo $per_hour * (60-$now['minute']+$tomorrow['minute'])/60;
				//echo '<BR>'.'3'.'<BR>';
			}
		}
		$new_tokens = $start_tokens+floor($earned);
		
//		if earned is zero we don't reset the clock.
		if (floor($earned)!=0){
					
			$tok = $this->Token->find('first',array('conditions'=>array('Token.user_id'=>$this->Auth->getUserId())));
			
			$this->Token->read(null,$tok['Token']['id']);
			$this->Token->set(array(
							'tokens'=>$new_tokens,
							'tokens_updated'=>date('Y-m-d H:i:s')
							));
				
			$this->Token->save($this->data);
		}
	
	
	}
	
	/*function forgot() {
  		if(!empty($this->data)) {
   			 $this->User->contain();
    			$user = $this->User->findByEmail($this->data['User']['email']);
    		if($user) {
      			$user['User']['tmp_password'] = $this->User->createTempPassword(7);
      			$user['User']['password'] = $this->Auth->password($user['User']['tmp_password']);
      			if($this->User->save($user, false)) {
       			 $this->__sendPasswordEmail($user, $user['User']['tmp_password']);
        			$this->Session->setFlash('An email has been sent with your new password.');
        			$this->redirect($this->referer());
      			}
    		} else {
     		 $this->Session->setFlash('No user was found with the submitted email address.');
    		}
  		}
	}
	*/
	
	
	

	
	
	
function _get($var) {
    return isset($this->params['url'][$var])? $this->params['url'][$var]: null;
}
function _creditConsumerAccount($type){
	if (substr($type,0,1)!='0'){
		switch (substr($type,0,1)){
			case 1:
				$valtok=100;
				break;
			case 2:
				$valtok=250;
				break;
			case 3:
				$valtok=500;
				break;
			case 4:
				$valtok=1000;
				break;
		}				
		$tok = $this->Token->find('first',array('conditions'=>array('Token.user_id'=>$this->Auth->getUserId())));
		$this->Token->read(null, $tok['Token']['id']);
		$new_tok = $tok['Token']['tokens']+$valtok;
		$this->Token->set('tokens',$new_tok);
		$this->Token->save();	
	}
	if (substr($type,4,5)!='0'){
		switch(substr($type,4,5)){
			case 1:
				$valbill=5;
				break;
			case 2:
				$valbill=12;
				break;
			case 3:
				$valbill=20;
				break;
			case 4:
				$valbill=30;
				break;
		}
		$bill = $this->Bill->find('first',array('conditions'=>array('Bill.user_id'=>$this->Auth->getUserId())));
		$this->Bill->read(null, $bill['Bill']['id']);
		$new_bill = $bill['Bill']['amount']+$valbill;
		$this->Bill->set('amount',$new_bill);
		$this->Bill->save();
	}
}
function _getPlanCode($plan){
		$value = 0;
		switch($plan){
			case "Premium":
				$value = 99;
				break;
			case "Super":
				$value = 59;
				break;
			case "Starter":
				$value = 35;
				break;
			case "Premium_Disc":
				$value = 79;
				break;
			case "Super_Disc":
				$value = 49;
				break;
			case "Starter_Disc":
				$value = 29;
				break;
		}
		return $value;
	}	
	function _getPlanType($amt){
		if ($amt > 60) return 3;
		else if ($amt < 60 && $amt > 36) return 2;
		else if ($amt < 36 && $amt > 19) return 1;
		else return 0;
	
	
	}
function _parseType($type){
	$flag = false;
	if ($type=='co') return 'co';
	if (substr($type,0,1)!='0'){
		switch (substr($type,0,1)){
			case 1:
				$valtok=5;
				break;
			case 2:
				$valtok=10;
				break;
			case 3:
				$valtok=18;
				break;
			case 4:
				$valtok=31;
				break;
		}				
		$returnval = '$'.$valtok . ' worth of tokens';
		$flag = true;
	}
	if (substr($type,4,5)!='0'){
		switch(substr($type,4,5)){
			case 1:
				$valbill=5;
				break;
			case 2:
				$valbill=10;
				break;
			case 3:
				$valbill=18;
				break;
			case 4:
				$valbill=31;
				break;
		}
		if ($flag) $returnval .= ' & ';
		$returnval .= '$'.$valbill . ' worth of bills';
	}
	return $returnval;
}
function _parsePackage($amt){
	switch ($amt){
		case 59:
			$package = "Super Package";
			break;
	}
	return $package;
}
	

function expressCheckout($step=1,$amt=99.95,$type='co'){
 // $this->Ssl->force();
    $this->set('step',$step);
	 //first get a token
	// echo $type;
    if ($step==1){
        $paymentInfo['Order']['theTotal']= $amt;
        $paymentInfo['Order']['returnUrl']= ROOT_URL."/users/expressCheckout/2/".$amt."/".$type;
        $paymentInfo['Order']['cancelUrl']= ROOT_URL;
		
		if ($type=="co"){
	//		echo 'yes';
			$paymentInfo['Order']['L_BILLINGTYPE0']='RecurringPayments';
			$paymentInfo['Order']['L_BILLINGAGREEMENTDESCRIPTION0']='Premium subscription';
			$paymentInfo['Order']['theTotal']=0;
			  
		}
		
            
        // call paypal
        $result = $this->Paypal->processPayment($paymentInfo,"SetExpressCheckout");
        $ack = strtoupper($result["ACK"]);
    	    
//		var_dump( $result );
		
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
        
		$package = $result['AMT'];
		
		$result['PAYERID'] = $this->_get('PayerID');
        $result['TOKEN'] = $this->_get('token');
        $result['ORDERTOTAL'] = $package;
			
        $ack = strtoupper($result["ACK"]);
        //Detect errors
        if($ack!="SUCCESS"){
            $error = $result['L_LONGMESSAGE0'];
            $this->set('error',$error);
        }
        else {
            $this->set('result',$this->Session->read('result'));
			$this->Session->write('type',$type);
			if ($type != 'co'){
				$this->set('package',$package);
				$item = $this->_parseType($type);
				$this->set('item',$item);
				
			}
			else {
				$item = $this->_parsePackage($amt);
				$this->set('item',$item);
				$this->set('package',$amt);			
			}
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
			$type = $this->Session->read('type');
			if ($type!='co'){
				//for consumers 
	        	$result = $this->Paypal->processPayment($this->Session->read('result'),"DoExpressCheckoutPayment");
    
				// credit your account
				$ack = strtoupper($result["ACK"]);
        		if($ack!="SUCCESS"){
            		$error = $result['L_LONGMESSAGE0'];
            		$this->set('error',$error);
        		}
        		else {
            		$type = $this->Session->read('type');
					$this->_creditConsumerAccount($type);
	        		$this->set('result',$this->Session->read('result'));
       			}
			}
			else {
				$result = $this->Session->read('result');
		  		$result['BILLINGPERIOD'] = 'Month';
		  		$result['Description']= 'Premium subscription';
          		$result['BILLINGFREQUENCY']=1;
        		if (true){  //is there a trial period?
					$result['TRIALBILLINGPERIOD']='Month';
        			$result['TRIALBILLINGFREQUENCY']=1;
					$result['TRIALTOTALBILLINGCYCLES']=1;
        			$result['AMT']=$amt;
					$trial_amt = $amt*2;
        			$result['TRIALAMT']=$trial_amt;
				}
				//var_dump($result);
				$response = $this->Paypal->processPayment($result,"CreateRecurringPayments");
				$ack = strtoupper($response["ACK"]);
        		if($ack!="SUCCESS"){
            		$error = $response['L_LONGMESSAGE0'];
            		$this->set('error',$error);
					$this->logout();
					
					// need to delete this record
					
					
        		}
        		else {
            		$type = $this->Session->read('type');
					$plan_type = $this->_getPlanType($amt);
					$this->User->read(null,$this->Auth->getUserId());
					$this->User->set('plan',$plan_type);
					$this->User->save();
					
	
					$this->redirect(array('controller'=>'mail', 'action'=>'send_welcome_message', $email, $joe));//$this->data['User']['name']));
			
				
			
			
				}

			}
		}
	}
}

?>