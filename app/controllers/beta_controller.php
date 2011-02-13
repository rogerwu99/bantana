<?php

App::import('Vendor', 'simplegeo', array('file' => 'PEAR'.DS.'SimpleGeo.php'));


Configure::write('current_url', 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT']);

class BetaController extends AppController 
{
    var $name = 'Beta';
    var $uses = array('User', 'Mail','Redeem','Discount'); 
    var $helpers = array('Html', 'Form', 'Javascript', 'Xml', 'Crumb', 'Ajax');
    var $components = array('Utils', 'Email', 'RequestHandler');
   
    function index()
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
		
			 if(is_null($this->Auth->getUserId())){
                       Controller::render('/deny');
         }
	
			$id = $this->Auth->getUserId();
            $profile = $this->User->findById($id);
			
			
    }
	function manual_location(){
		
			 if(is_null($this->Auth->getUserId())){
                       Controller::render('/deny');
         }
	
		$url="http://local.yahooapis.com/MapsService/V1/geocode?appid=89YEQTHIkY2SU4r0q7se6KONjW1X8WhRKA--&street=".urlencode($this->data['Beta']['Address']);
		$xmlObject = simplexml_load_string(file_get_contents($url));
		$lat=$xmlObject->Result->Latitude;
		$long=$xmlObject->Result->Longitude;
		
		Configure::write('my_lat',$lat);
		Configure::write('my_long',$long);
		
		
		
		$this->set(compact('lat'));
		$this->set(compact('long'));
	
	
	}
    
}


?>
