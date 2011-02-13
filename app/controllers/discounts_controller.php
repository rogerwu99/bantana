<?php
class DiscountsController extends AppController 
{
    var $name = 'Discounts';
    var $uses = array('User', 'Mail', 'Discount','Redeem'); 
    var $helpers = array('Html', 'Form', 'Javascript', 'Xml', 'Crumb','Ajax');
    var $components = array('Utils', 'Email', 'RequestHandler');
   
    function index()
    {
    }
    
 	
    function create()
	{
		if(is_null($this->Auth->getUserId())){
        	Controller::render('/deny');
        }
	
//	var_dump($this->data);
	
		$text = $this->data['Discount']['text'];
		$value = $this->data['Discount']['value'];
		$start_normalized = $this->data['Discount']['Start_Time']['meridian'] == "pm" ? (int) $this->data['Discount']['Start_Time']['hour']+12 : $this->data['Discount']['Start_Time']['hour'];
		$end_normalized = $this->data['Discount']['End_Time']['meridian'] == "pm" ? (int) $this->data['Discount']['End_Time']['hour']+12 : $this->data['Discount']['End_Time']['hour'];
		$start_time = mktime($start_normalized,$this->data['Discount']['Start_Time']['min'],0,$this->data['Discount']['Start_Day']['month'],$this->data['Discount']['Start_Day']['day'],$this->data['Discount']['Start_Day']['year']);
		$end_time = mktime($end_normalized,$this->data['Discount']['End_Time']['min'],0,$this->data['Discount']['End_Day']['month'],$this->data['Discount']['End_Day']['day'],$this->data['Discount']['End_Day']['year']);
	
		$user = $this->Auth->getUserInfo();
		$user_id = $user['id'];
		$lat = $user['latitude'];
		$long = $user['longitude'];
		$name = $user['name'];
	
		$this->Discount->create();
		$this->data['Discount']['name']=$name;
		$this->data['Discount']['text']=$text;
		$this->data['Discount']['value']=$value;
		
		$this->data['Discount']['start'] = date('Y-m-d H:i:s',$start_time);
		$this->data['Discount']['end'] = date('Y-m-d H:i:s',$end_time);
	
		$this->data['Discount']['user_id']=$user_id;
		$this->data['Discount']['long']= $long;
		$this->data['Discount']['lat']= $lat;
		$this->Discount->save($this->data);	
		$this->set('discount',$this->Discount->findById($this->Discount->id));	
		       
    }
	function read(){
		
		if(is_null($this->Auth->getUserId())){
                       Controller::render('/deny');
         }
	
		
		$lat=$this->data['Discounts']['myLat'];
		$long=$this->data['Discounts']['myLong'];
		
		$results = $this->Discount->find('all', array('conditions' => (array('Discount.lat BETWEEN ? AND ?'=>array($lat-5,$lat+5),
																			 'Discount.long BETWEEN ? AND ?'=>array($long-5,$long+5),
																			 'Discount.end >' => date(	'Y-m-d H:i:s'),
																			 'Discount.start <'=> date(	'Y-m-d H:i:s')	
																		))));
			
		$this->set('myLat',$lat);
		$this->set('myLong',$long);
		$this->set(compact('results'));
	//	var_dump($results);
	}
	function get($id=null){
		return $this->Discount->find('all', array('conditions'=>array('Discount.user_id'=>$id, 'Discount.deleted'=>0)));
	}
	function getusers($id=null){
		$user_array=array();
		$user_results = $this->Redeem->find('all',array('conditions'=>array('Redeem.disc_id'=>$id)));
		foreach ($user_results as $key=>$value){
			$user = $this->User->findById($user_results[$key]['Redeem']['user_id']);
			$this->set('user_created'.$user['User']['id'],$user_results[$key]['Redeem']['created']);
			array_push($user_array,$user);
	//		echo $user['User']['id'];
		}
		$this->set('user_array',$user_array);
	//var_dump($user_array);
	}
	function delete($id=null){
	 if(is_null($this->Auth->getUserId())){
                       Controller::render('/deny');
         }
	
		
		$user = $this->Auth->getUserInfo();
		$user_id = $this->Discount->read('user_id', $id);
		if ($user['id']==$user_id['Discount']['user_id']){
			$this->Discount->set('deleted', 1);
			$this->Discount->save();
		}
		$this->redirect(array('controller'=>'beta','action'=>'index'));
	} 
	function edit($id=null){
			 if(is_null($this->Auth->getUserId())){
                       Controller::render('/deny');
         }
	
		$results = $this->Discount->find('first', array('conditions'=>array('Discount.id'=>$id)));
		$start_date = $results['Discount']['start']; 
		$end_date= $results['Discount']['end'];
	
		$syear=substr($start_date,0,4); 
		$smonth=substr($start_date,5,2);
		$sday=substr($start_date,8,2);
		$shour=substr($start_date,11,2);
		$smin=substr($start_date,14,2);
		
		$eyear=substr($end_date,0,4); 
		$emonth=substr($end_date,5,2);
		$eday=substr($end_date,8,2);
		$ehour=substr($end_date,11,2);
		$emin=substr($end_date,14,2);
		
		$this->set(compact('results'));
		$this->set(compact('syear'));
		$this->set(compact('smonth'));
		$this->set(compact('sday'));
		$this->set(compact('shour'));
		$this->set(compact('smin'));
	
		$this->set(compact('eyear'));
		$this->set(compact('emonth'));
		$this->set(compact('eday'));
		$this->set(compact('ehour'));
		$this->set(compact('emin'));
		
	
	}
	function update($id=null){
			 if(is_null($this->Auth->getUserId())){
                       Controller::render('/deny');
         }
	
		$user = $this->Auth->getUserInfo();
		$user_id = $this->Discount->read('user_id', $id);
		if ($user['id']==$user_id['Discount']['user_id']){
			$text = $this->data['Discount']['Text'];
			$val = $this->data['Discount']['Value'];
			$start_normalized = $this->data['Discount']['Start_Time']['meridian'] == "pm" ? (int) $this->data['Discount']['Start_Time']['hour']+12 : $this->data['Discount']['Start_Time']['hour'];
			$end_normalized = $this->data['Discount']['End_Time']['meridian'] == "pm" ? (int) $this->data['Discount']['End_Time']['hour']+12 : $this->data['Discount']['End_Time']['hour'];
			$start_time = mktime($start_normalized,$this->data['Discount']['Start_Time']['min'],0,$this->data['Discount']['Start_Day']['month'],$this->data['Discount']['Start_Day']['day'],$this->data['Discount']['Start_Day']['year']);
			$end_time = mktime($end_normalized,$this->data['Discount']['End_Time']['min'],0,$this->data['Discount']['End_Day']['month'],$this->data['Discount']['End_Day']['day'],$this->data['Discount']['End_Day']['year']);
			
			$this->Discount->set(array(
									   'start'=> date('Y-m-d H:i:s',$start_time),
									   'end'=> date('Y-m-d H:i:s',$end_time),
									   'text'=>$text,
									   'value'=>$val
									   ));
			$this->Discount->save();
		}
		$results = $this->Discount->read(null, $id);
		$this->set(compact('results'));
	}
	function demo(){
		$results=array();
		$results[0]=array();
		$results[1]=array();
		$results[2]=array();
		$results[0]['lat']= 40.74719;
		$results[0]['long']=-73.991694;
		$results[0]['text']='50% off lunch from 2-3pm - 5 left!';
		$results[0]['name']='Canaan Sushi';
		$results[1]['lat']= 40.747427;
		$results[1]['long']=-73.993409;
		$results[1]['text']='Free draft beer with lunch purchase 12-12:30 everyday!';
		$results[1]['name']='Mustang Sally';
		$results[2]['lat']= 40.747077;
		$results[2]['long']=-73.994515;
		$results[2]['text']='Extra seat in Fashion 101 Class - Starts in 10 minutes! - $10 for first class';
		$results[2]['name']='Fashion Institute of Technology';
		return $results;
	
	}
	function show($id=null){
		$disc = $this->Discount->findById($id);
		if ($disc['Discount']['deleted']==1){
			$this->set('deleted',true);
		}
		else {
			$db_results=$this->Redeem->find('all',array('conditions'=>array('Redeem.disc_id'=>$disc['Discount']['id'],'Redeem.user_id'=>$this->Auth->getUserId())));
			$vendor = $this->User->findById($disc['Discount']['user_id']);
			$this->set(compact('vendor'));
			$this->set(compact('disc'));

			if (empty($db_results)){
				$this->set('redeemed',false);
			}
			else {
				$this->set('redeemed',true);	
			}
		}
	}
	function hide($id=null){
		$db_results=$this->Redeem->find('first',array('conditions'=>array('Redeem.disc_id'=>$id,'Redeem.user_id'=>$this->Auth->getUserId())));
		if (empty($db_results)) {
			$this->set('error','You did not redeem this offer!');
		}
		else {
			$this->Redeem->read(null,$db_results['Redeem']['id']);
			$this->Redeem->set('hidden',1);
			$this->Redeem->save();
		}
		$this->redirect(array('controller'=>'beta','action'=>'view_my_profile'));
	}
	function redeem(){
		$id=$this->data['Discount']['id'];
		$user_id=$this->Auth->getUserId();
		$db_results=$this->Redeem->find('all',array('conditions'=>array('Redeem.disc_id'=>$id,'Redeem.user_id'=>$user_id)));
		$disc_value = $this->Discount->read('value',$id);
		$user_tokens = $this->User->read('tokens',$user_id);
		if ($disc_value['Discount']['value'] * CONVERSION_RATE > $user_tokens['User']['tokens']){
			$this->set('error','You do not have enough tokens!');
		}
		else {
			if (empty($db_results)) {
				$this->Redeem->create();
				$this->data=array();
				$this->data['Redeem']['user_id'] = $user_id; 
				$this->data['Redeem']['disc_id'] = $id;
				$this->Redeem->save($this->data);
				$diff = $user_tokens['User']['tokens']-$disc_value['Discount']['value']*CONVERSION_RATE;
				$this->User->set('tokens', $diff);
				$this->User->save();
				$this->set('success',true);
			}
			else {
				$this->set('error','You have already redeemed this offer!');
			}
		}
		$this->redirect(array('controller'=>'discounts','action'=>'show',$id));
	}
}
?>
