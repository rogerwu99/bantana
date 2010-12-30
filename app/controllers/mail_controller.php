<?php 
class MailController extends AppController 
{
    var $name = 'Mail';
    //Not using a model
    var $uses = array('User', 'Contact')//, 'Error', 'ErrorCode', 'Alert');
    //The built in Cake Mailer
    var $components = array('Email');
    
    
    function send_new_contact() 
    {
        $user = $this->Auth->getUserInfo();
        
        $contact = $this->Contact->find('first', array('order'=>'Contact.id DESC'));
        
        //Configure::write('debug', 1);
        //pr($contact);
        //exit;
        
        $this->Email->to = 'roger@klickable.tv';
        $this->Email->subject = 'NEW CONTACT';
        $this->Email->replyTo = 'robot@klickable.tv';
        $this->Email->from = 'ROBOT <robot@klickable.tv>';
        $this->Email->template = 'new_contact';
        $this->set('email', $contact['Contact']['email']);
        $this->set('category', $contact['Contact']['category']);
        $this->set('message', $contact['Contact']['message']); 
        //Set the body of the mail as we send it.
        //Note: the text can be an array, each element will appear as a
        //seperate line in the message body.
	    $this->Email->sendAs = 'html';
        $this->Email->send();  
        if($this->Auth->isAllowed(array('Admin', 'Beta')))
        { 
            $this->redirect(array('controller'=>'beta', 'action'=>'thankyou'));
        }
        else
        {
            $this->redirect(array('controller'=>'pages', 'action'=>'thankyou'));
        }
    } 
    
    function send_new_registrant($email, $name) 
    {
	echo $email;
        $this->Email->to = 'roger@klickable.tv';
        
        $this->Email->subject = 'NEW REGISTRANT';
        $this->Email->replyTo = 'robot@klickable.tv';
        $this->Email->from = 'ROBOT <robot@klickable.tv>';
        $this->Email->template = 'new_registrant';
        $this->set('email', $email);
        $this->set('name', $name); 
        //Set the body of the mail as we send it.
        //Note: the text can be an array, each element will appear as a
        //seperate line in the message body.
        $this->Email->send();

       // $this->Session->setFlash(__('Thank you for registering', true));
		//$this->redirect(array('controller'=>'pages', 'action'=>'thankyou'));
		echo 'hey1';
        $this->redirect('/');
		echo 'hey2';
	//	exit();
		
    } 
    
    function send_beta_invite($user_id)
    {
        if($this->Auth->isAllowed(array('Admin')))
	    {
	        $user = $this->User->findById($user_id);
	        $email = $user['User']['email'];
	        
	        $this->Email->to = $email;
	        $this->Email->subject = 'Klickable Beta Invite';
	        $this->Email->replyTo = 'beta@klickable.tv';
	        $this->Email->from = 'Klickable <beta@klickable.tv>';
	        $this->Email->template = 'beta_invite';
	        $this->set('email', $email);
	
	        $this->Email->send();  
	        
	        $this->Session->setFlash(__('Thanks for Sharing!'.$email, true));
			$this->redirect(array('controller'=>'users', 'action'=>'index'));
	    }
    }
    
    function share_the_beta($user_id, $email, $message)
    {
        if($this->Auth->isAllowed(array('Admin', 'Beta')))
	    {
	       
	    }
	}

    function reset_password($email, $token)
    {
        $this->Email->to = $email;
        $this->Email->subject = 'Resetting your password';
        $this->Email->replyTo = 'robot@klickable.tv';
        $this->Email->from = 'ROBOT <robot@klickable.tv>';
        $this->Email->template = 'reset_password';        
        $this->set('email', $email);
        //$link = 'http://72.47.193.128/klickabletv/users/reset/'.$token;
        $link = 'http://klickable.tv/users/reset/'.$token;
        //$link = 'http://localhost/workspace/klick_staging/klickabletv/users/reset/'.$token;
        $this->set('link', $link);
        $this->Email->send();
        $this->redirect(array('controller'=>'pages', 'action'=>'thankyou'));
    }
	
    function send_alert()
    {
       
        //Configure::write('debug', 3); 
        //pr($this->data);
        //$text = $this->data['text'];
        //$id = $this->data['id']; 
     //   $alert = $this->Alert->find('first', array('order'=>'Alert.id DESC'));

        //pr($alert);
        //exit;
        $this->Email->to = 'roger@klickable.tv';
        $this->Email->subject = 'POTENTIAL PROBLEM';
        $this->Email->replyTo = 'robot@klickable.tv';
        $this->Email->from = 'ROBOT <robot@klickable.tv>';
        
        //$this->Email->template = 'new_contact';
        //$this->set('email', $contact['Contact']['email']);
        //$this->set('category', $contact['Contact']['category']);
        //$this->set('message', $contact['Contact']['message']); 
        
        
        //pr($error);
        //exit;
        $this->Email->template = 'problem';
        //$this->Email->sendAs = 'html';
      //  $this->set('msg', $alert['ErrorCode']['description']);
       // $this->set('id', $alert['Alert']['asset_id']);
        
        //pr($text);
        //pr($id);
        //Set the body of the mail as we send it.
        //Note: the text can be an array, each element will appear as a
        //seperate line in the message body.
        $this->Email->send();
        exit;
    }
	
}
?> 
