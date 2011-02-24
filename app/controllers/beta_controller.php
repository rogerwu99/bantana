<?php
//App::import('Vendor', 'simplegeo', array('file' => 'PEAR'.DS.'Services'.DS.'SimpleGeo.php'));
App::import('Vendor', 'simplegeo', array('file' => 'SimpleGeo.php'));
class BetaController extends AppController 
{
    var $name = 'Beta';
    var $uses = array('User', 'Mail','Redeem','Discount'); 
    var $helpers = array('Html', 'Form', 'Javascript', 'Xml', 'Crumb', 'Ajax');
    var $components = array('Utils', 'Email', 'RequestHandler');
   
    function index($id=null)
    {
		
		 if(is_null($this->Auth->getUserId())){
                       Controller::render('/deny');
         }
	
		$param_array=$this->Session->read('url_params');
	
		$this->User->recursive = -1;
	   	$user = $this->Auth->getUserInfo();
		$this->set(compact('user'));
		$user_id = $user['id'];
		$user_name = $user['username'];
		$lat = $user['latitude'];
		$long = $user['longitude'];
		$name = $user['name'];
		$range = $user['range'];
		$address=$user['address'];
		//determine if business or not
		
		
		//$url = 'http://alpha.WaftMe.com?uId='.$user_id.'&userName='.urlencode($name);
		if ($user['latitude']!=0 && $user['longitude']!=0){
			$lat = $user['latitude'];
			$long = $user['longitude'];
			$range = $user['range'];
			if (!is_null($id)) {
				$disc = $this->Discount->findById($id);
			//	echo $disc['Discount']['text'];
				$this->set('dtext',$disc['Discount']['text']);
				$this->set('dvalue',$disc['Discount']['value']);
			}
		
		}
		else {
			$this->redirect(array('action'=>'view_my_location'));
		}
		/*if ($param_array!=null){
			foreach ($param_array as $k => $v) {
				//echo $param_array['url'][$k].$k. '=>'. $v.' ';	
				if ($k!='url'){
					$url .= '&'.$k.'='. urlencode($v);
				}
			}
		}*/
	//	echo $url;
	//	$this->redirect($url); 
	//echo $url;
	
	
	
    }
    
 	
    	
    
    function view_my_profile($page = 1)
    {
		
		 if(is_null($this->Auth->getUserId())){
                       Controller::render('/deny');
         }
	
		if (empty($this->data)) {
			$root_url =ROOT_URL;
		
			$id = $this->Auth->getUserId();
            $results = $this->User->find('first', array('conditions' => (array('User.id'=>$id))));
			$image_link = ''; 
			$image_can_change = false;
			if ($results['User']['fb_pic_url']==''){
				if ($results['User']['tw_pic_url']==''){
					$image_link=$root_url.'/img/uploads/'.$results['User']['path'];
					$image_can_change = true;
				}
				else {
					$image_link=$results['User']['tw_pic_url'];
				}
			}
			else {
				$image_link = $results['User']['fb_pic_url'];
			}
			
			$this->set('image_can_change', $image_can_change);
			$this->set('image_link', $image_link);
			$this->set(compact('results'));
			
			$disc_array=array();
			$disc_desc=array();
			$db_results=$this->Redeem->find('all',array('conditions'=>array('Redeem.user_id'=>$id)));
			if (!empty($db_results)) {
				foreach ($db_results as $key=>$value){
					if ($db_results[$key]['Redeem']['hidden']!=1){
						$disc_results = $this->Discount->findById($db_results[$key]['Redeem']['disc_id']);
						$disc_user = $this->User->findById($disc_results['Discount']['user_id']);
						array_push($disc_array,$disc_results);
						array_push($disc_desc,$disc_user);
					}
				}
				$this->set('d_desc',$disc_desc);
				$this->set('d_results',$disc_array);
			}
			else {
				$this->set('none',true);
			}
			
			$this->render();
		}
		else {
			//echo 'doing stuff';
		}
			
	
			
    }
    function view_my_location($page = 1)
    {
		$my_long=$this->Session->read('my_long');
		$my_lat=$this->Session->read('my_lat');
		$my_address = $this->Session->read('my_address');
			
			 if(is_null($this->Auth->getUserId())){
                       Controller::render('/deny');
         	}
	
			$id = $this->Auth->getUserId();
            $profile = $this->User->findById($id);
			if ($my_long=='' && $my_lat=='' && trim($my_address)==''){
	
				$client = new Services_SimpleGeo('ZJNHYqVpyus8vEwG357mRa8Eh7gwq4WN','yzgWLLsY8QqAB3c2bDhNSCSbDDERaV8E');
	
				$ip=$_SERVER['REMOTE_ADDR'];
				if ($ip=='::1') {
					$results = $client->getContextFromIPAddress();
				}
				else {
					$results = $client->getContextFromIPAddress($ip);
				}
				$url = "http://where.yahooapis.com/geocode?q=".$results->query->latitude.",".$results->query->longitude."&gflags=R&flags=J&appid=cENXMi4g";
	
				$address = json_decode(file_get_contents($url));
				$full_address = $address->ResultSet->Results[0]->line1." ".$address->ResultSet->Results[0]->line2;
				$this->set('simplegeo_address',$full_address);
				$this->set('simplegeo_lat',$results->query->latitude);
				$this->set('simplegeo_long',$results->query->longitude);
				$this->Session->write('my_lat',$results->query->latitude);
				$this->Session->write('my_long',$results->query->longitude);
				$this->Session->write('my_address',$full_address);
				$this->set('show_discounts',true);
				
			}
			else{
	
				$this->set('simplegeo_address',$my_address);
				$this->set('simplegeo_lat',$my_lat);
				$this->set('simplegeo_long',$my_long);
				$this->set('show_discounts',true);
			}
			
    }
	function manual_location(){
			 if(is_null($this->Auth->getUserId())){
                       Controller::render('/deny');
         }
	
		$url="http://local.yahooapis.com/MapsService/V1/geocode?appid=89YEQTHIkY2SU4r0q7se6KONjW1X8WhRKA--&street=".urlencode($this->data['Beta']['Address']);
		$xmlObject = simplexml_load_string(file_get_contents($url));
		$lat= (string) $xmlObject->Result->Latitude;
		$long=(string) $xmlObject->Result->Longitude;
		
		
		$this->Session->write('my_lat',$lat);
		$this->Session->write('my_long',$long);
		$this->Session->write('my_address',$this->data['Beta']['Address']);
	
		
	
		$this->set('address',$this->data['Beta']['Address']);
		$this->set(compact('lat'));
		$this->set(compact('long'));
	
	
	}
	function getLocation(){
		$results = $this->params['url'];
		// this function is for auto finding.
		$this->Session->write('my_lat',$results['latitude']);
		$this->Session->write('my_long',$resuls['longitude']);
		$url = "http://where.yahooapis.com/geocode?q=".$results['latitude'].",".$results['longitude']."&gflags=R&flags=J&appid=cENXMi4g";
		$address = json_decode(file_get_contents($url));
		$full_address = $address->ResultSet->Results[0]->line1." ".$address->ResultSet->Results[0]->line2;
		$this->Session->write('my_address',$full_address);
				
		$this->set('address',$full_address);		
	//	return $full_address;
	//	exit;
		
		
		
		
	}
	function addTokens(){
		/*
			1 - 100 tokens ($5.00)
			2 - 250 tokens ($10.00)
			3 - 500 tokens ($18.00)
			4 - 1000 tokens ($31.00)
		
		*/
		
		if (!empty($this->data)) {
			$tokens = $this->data['Beta']['buy_more_tokens'];
			$bills = $this->data['Beta']['buy_more_bills'];
			switch($this->data['Beta']['buy_more_tokens']){
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
				default:
					$tokens=0;
			}
			$type = $tokens.'tok';
			switch($this->data['Beta']['buy_more_bills']){
				
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
				default:
					$bills = 0;
			}
	    	$type .= $bills.'bill';
			$val = $valtok + $valbill;
			
			
			
			$this->redirect(array('controller'=>'users','action'=>'expressCheckout',1,$val,$type));
		}
	}
    function code(){
		if (!empty($this->data)) {
			if ($this->data['DC']['text']=="2011SPR"){
				$this->set('starting','false');
			}
			else {
				$this->set('error','Unrecognized Code');
			}
		}
		$this->render('/elements/pay');
	
	}
}

?>
