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
    
    var $validate = array(
    	
    	'email' => array(
    					'emailFormat' => array(
    							'rule'=>'email',
	   							'required' =>true,
    							'message' => 'Please input valid email address',
    							'last'=>true,
								'on' => 'create'
    					),
						'emailUnique' => array(
							'rule'=>'isUnique',
							'message' => 'This email has already been registered with Bantana.',
							'last'=>true,
							'on' => 'create'
							
						)
    			),
		'new_password' => array
    					(
    					'ruleNotEmpty' => array(
    						'rule' => array('minLength', '8'),
    						'required' =>true,
    						'message' => 'Please provide password of at least 8 characters.',
    						'last'=>true,
							'on' => 'create'
    											), 
    					'newPasswordRule' => array(
    						'rule' => array('identicalFieldValues', 'confirm_password'),
    						'required' =>true,
    						'message' => 'Passwords must match.',
							'on' => 'create'
    					)
    		)

  		);
    
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
