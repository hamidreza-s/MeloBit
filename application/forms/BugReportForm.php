<?php

class Form_BugReportForm extends Zend_Form
{
	public function init()
	{
		$this->setAttrib('class', 'jQueryValidation');
		
		// add element: hidden id
		$id = $this->createElement('hidden', 'id');
		$this->addElement($id);
		
		// add element: author textbox
		$author = $this->createElement('text', 'author');
		$author->setLabel('Enter your name:');
		$author->setRequired(true);
		$author->setAttrib('size', 30);
		$author->setAttrib('class', 'validate[required]');
		$this->addElement($author);
		
		// add element: email textbox
		$email = $this->createElement('text', 'email');
		$email->setLabel('Your email address:');
		$email->setRequired(true);
		$email->addValidator(new Zend_Validate_EmailAddress);
		$email->addFilters(array(new Zend_Filter_StringTrim(), new Zend_Filter_StringToLower()));
		$email->setAttrib('size', 30);
		$email->setAttrib('class', 'validate[required,custom[email]]');
		$this->addElement($email);
		
		// add element: date textbox
		$date = $this->createElement('text', 'date');
		$date->setLabel('Date the issue occurred (mm-dd-yyyy):');
		$date->setRequired(true);
		$date->addValidator(new Zend_Validate_Date('MM-DD-YYYY'));
		$date->setAttrib('size', 30);
		$date->setAttrib('class', 'validate[required,custom[date-mmddyyyy]]');
		$this->addElement($date);
		
		// add element: URL textbox
		$url = $this->createElement('text', 'url');
		$url->setLabel('Issue URL:');
		$url->setRequired(true);
		$url->setAttrib('size', 30);
		$url->setAttrib('class', 'validate[required,custom[url]]');
		$this->addElement($url);
		
		// add element: description text area
		$description = $this->createElement('textarea', 'description');
		$description->setLabel('Issue description:');
		$description->setRequired(true);
		$description->setAttrib('cols', 43);
		$description->setAttrib('rows', 4);
		$description->setAttrib('class', 'validate[required]');
		$this->addElement($description);
		
		// add element: priority select box
		$priority = $this->createElement('select', 'priority');
		$priority->setLabel('Issue priority:');
		$priority->setRequired(true);
		$priority->addMultiOptions(array(
			'low'	=>	'Low',
			'med'	=>	'Medium',
			'high'	=>	'High'
		));
		$this->addElement($priority);
		
		// add element: status select box
		$status = $this->createElement('select', 'status');
		$status->setLabel('Current status:');
		$status->setRequired(true);
		$status->addMultiOptions(array(
			'new'			=>	'New',
			'in_progress'	=>	'In Progress',
			'resolved'		=>	'Resolved'
		));
		$this->addElement($status);

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
		
		// add element: submit button
		$this->addElement('submit', 'submit', array('label' => 'Submit'));
	}
}





















