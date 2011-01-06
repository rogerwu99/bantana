<?php 
class MailController extends AppController 
{
    var $name = 'Mail';
    var $uses = array('User');//, 'Error', 'ErrorCode', 'Alert');
    var $components = array('Email');
    
    function send_new_registrant($email, $name) 
    {
        $this->Email->to = 'rogerwu99@yahoo.com';
        $this->Email->subject = 'NEW REGISTRANT';
        $this->Email->replyTo = 'robot@klickable.tv';
        $this->Email->from = 'ROBOT <robot@klickable.tv>';
        $this->Email->template = 'new_registrant';
        $this->set('email', $email);
        $this->set('name', $name); 
		if ( $this->Email->send() ) {
          echo 'hey';
		  $this->Session->setFlash('Template html email sent');
        } else {
			echo 'bye';
            $this->Session->setFlash('Template html email not sent');
        }
		
		$this->redirect('/');
		
    } 
}
?> 
