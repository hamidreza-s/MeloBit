<?php
class Contact_Form_ContactForm extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		$this->setAttrib('id', 'jQueryValidation');
	
		// create name element
		$name = $this->createElement('text', 'name');
		$name->setLabel('Enter your name:');
		$name->setRequired(true);
		$name->setAttrib('size', 30);
		$name->setAttrib('class', 'validate[required]');
		$this->addElement($name);
		
		// create email element
		$email = $this->createElement('text', 'email');
		$email->setLabel('Enter your email address:');
		$email->setRequired(true);
		$email->setAttrib('size', 30);
		$email->setAttrib('class', 'validate[required,custom[email]]');
		$email->addValidator('EmailAddress');
		$email->addErrorMessage('Invalid email Address!');
		$this->addElement($email);
		
		//create subject element
		$subject = $this->createElement('text', 'subject');
		$subject->setLabel('Subject:');
		$subject->setRequired(true);
		$subject->setAttrib('size', 30);
		$subject->setAttrib('class', 'validate[required]');
		$this->addElement($subject);
		
		// create attachment element
		$attachment = $this->createElement('file', 'attachment');
		$attachment->setLabel('Attach a file:');
		$attachment->setDestination(APPLICATION_PATH . '/../temp');
		$attachment->addValidator('count', false, 1);
		$attachment->addValidator('size', false, 102400); // 100KB
		$attachment->addValidator('extension', false, 'jpg,jpeg,png,gif');
		$this->addElement($attachment);
		
		// create message element
		$message = $this->createElement('textarea', 'message');
		$message->setLabel('Message:');
		$message->setRequired(true);
		$message->setAttrib('cols', 50);
		$message->setAttrib('rows', 12);
		$message->setAttrib('class', 'validate[required]');
		$this->addElement($message);
		
		/*
		// configure the captcha service
		$privateKey = '6LcrmdcSAAAAAGE8z8AFg39n9jlZTSZWVmxNlwBJ';
		$publicKey = '6LcrmdcSAAAAAJe4T1hbUfwW9cWLVN4Nt2KDCkBK';
		$recaptcha = new Zend_Service_ReCaptcha($privateKey, $publicKey);
		
		// create captcha element
        $captcha = new Zend_Form_Element_Captcha('captcha',
            array(
                'captcha'       => 'ReCaptcha',
                'captchaOptions' => array('captcha' => 'ReCaptcha', 'service' => $recaptcha),
                'ignore' => true
                ));
    	$this->addElement($captcha);	
		*/

		// OR create figlet captcha
		$captcha = new Zend_Form_Element_Captcha('captcha', array(
			'captcha' => array(
			'captcha' => 'Figlet',
			'wordLen' => '5',
			'timeout' => 300
		)
		));
		$captcha->setLabel('Verification:'); 
		$captcha->setAttrib('class', 'validate[required]');
    	$this->addElement($captcha);	

					
		
		// create submit element
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Send Message');
		$this->addElement($submit);
	}
}




























