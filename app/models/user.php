<?php
class User extends AppModel {

	var $name = 'User';
    var $actsAs = array('Containable');
     
	function identicalFieldValues($field=array(), $compare_field=null ) 
    {
        foreach( $field as $key => $value )
        {
            $v1 = $value;
            $v2 = $this->data[$this->name][ $compare_field ];                 
            if($v1 !== $v2) 
            {
                return false;
            } 
            else 
            {
                continue;
            }
        }
        return true;
    } 
    /*
    var $validate = array(
    	
    	'email' => array(
    					'emailFormat' => array(
    							//'rule'=>array('custom',"/^[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9-_](?:[a-z0-9-_]*[a-z0-9])?\.)+(?:[a-z]{2,4}|museum|travel)$/i"),
    							'required' =>true,
    							'message' => 'Please input valid email address',
    							'last'=>true
    											),
					'emailUnique' => array(
							'rule'=>'isUnique',
							'message' => 'This email has already been registered with Klickable.'
											)
    					),
    	'new_password' => array
    					(
    					'ruleNotEmpty' => array(
    						'rule' => array('custom', '/^[^\s]+$/'),
    						'required' =>true,
    						'message' => 'Please provide password.',
    						'last'=>true
    											), 
    					'newPasswordRule' => array(
    						'rule' => array('identicalFieldValues', 'confirm_password'),
    						'required' =>true,
    						'message' => 'Passwords can\'t be empty and must match.'
    											)
    					),
	 'accept' =>array(
             				'rule' => array('comparison', '!=', 0),  
             				'required' => true,  
             				'message' => 'You must agree to the terms of use'
					)


  		);
    */
    /*
	var $validate = array(
	                        'email' => array('Required Field' => VALID_NOT_EMPTY, 'rule' => array('email')), 
	                        'first_name' => array('Required Field' => VALID_NOT_EMPTY, 'rule' => array('alphaNumeric')),
	                        'new_password' => array(
	                                'identicalFieldValues' => array(
							            'rule' => array('identicalFieldValues', 'confirm_password'),
						                'message' => 'Passwords do not match'
									),
							        'Required Field' => VALID_NOT_EMPTY
						      ),
	                         'confirm_password' => array('Required Field' => VALID_NOT_EMPTY) 
	                     );
	
	*/
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	/*var $hasOne = array(
			'UserProfile' => array('className' => 'UserProfile',
								'foreignKey' => 'user_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);
	*/
	



}
?>
