<?php
class DiscountsController extends AppController 
{
    var $name = 'Discounts';
    var $uses = array('User', 'Mail', 'Discount'); 
    var $helpers = array('Html', 'Form', 'Javascript', 'Xml', 'Crumb','Ajax');
    var $components = array('Utils', 'Email', 'RequestHandler');
   
    function index()
    {
    }
    
 	
    function create()
    {
		$text = $this->data['Discount']['text'];
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
		
		
		$this->data['Discount']['start'] = date('Y-m-d H:i:s',$start_time);
		$this->data['Discount']['end'] = date('Y-m-d H:i:s',$end_time);
	
		$this->data['Discount']['user_id']=$user_id;
		$this->data['Discount']['long']= $long;
		$this->data['Discount']['lat']= $lat;
		$this->Discount->save($this->data);	
		$this->set('discount',$this->Discount->findById($this->Discount->id));	
		       
    }
	function read(){
		
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
	function delete($id=null){
		$user = $this->Auth->getUserInfo();
		$user_id = $this->Discount->read('user_id', $id);
		if ($user['id']==$user_id['Discount']['user_id']){
			$this->Discount->set('deleted', 1);
			$this->Discount->save();
		}
		$this->redirect(array('controller'=>'beta','action'=>'index'));
	} 
	function edit($id=null){
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
		$user = $this->Auth->getUserInfo();
		$user_id = $this->Discount->read('user_id', $id);
		if ($user['id']==$user_id['Discount']['user_id']){
		
			$text = $this->data['Discount']['Text'];
			$start_normalized = $this->data['Discount']['Start_Time']['meridian'] == "pm" ? (int) $this->data['Discount']['Start_Time']['hour']+12 : $this->data['Discount']['Start_Time']['hour'];
			$end_normalized = $this->data['Discount']['End_Time']['meridian'] == "pm" ? (int) $this->data['Discount']['End_Time']['hour']+12 : $this->data['Discount']['End_Time']['hour'];
			$start_time = mktime($start_normalized,$this->data['Discount']['Start_Time']['min'],0,$this->data['Discount']['Start_Day']['month'],$this->data['Discount']['Start_Day']['day'],$this->data['Discount']['Start_Day']['year']);
			$end_time = mktime($end_normalized,$this->data['Discount']['End_Time']['min'],0,$this->data['Discount']['End_Day']['month'],$this->data['Discount']['End_Day']['day'],$this->data['Discount']['End_Day']['year']);
			
			$this->Discount->set(array(
									   'start'=> date('Y-m-d H:i:s',$start_time),
									   'end'=> date('Y-m-d H:i:s',$end_time),
									   'text'=>$text
									   ));
			$this->Discount->save();
		}
		$results = $this->Discount->read(null, $id);
		$this->set(compact('results'));
		
		
	
	
			
		
		
	}
}
?>
