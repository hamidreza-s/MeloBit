<?php
class Form_ConfigForm extends Zend_Form
{
	public function init()
	{
		// initialize form
		$this->setMethod('post');
			
		// create text input for site head title
		$headTitle = new Zend_Form_Element_Text('headTitle');
		$headTitle->setLabel('Head Title:')
			->setOptions(array('Size' => '30'))
			->setRequired(true)
			->addFilter('HtmlEntities')
			->addFilter('StringTrim');

		// create text input for site name
		$siteTitle = new Zend_Form_Element_Text('siteTitle');
		$siteTitle->setLabel('Website Title:')
			->setOptions(array('Size' => '30'))
			->setRequired(true)
			->addFilter('HtmlEntities')
			->addFilter('StringTrim');

		// create text input for site description
		$siteDescription = new Zend_Form_Element_Text('siteDescription');
		$siteDescription->setLabel('Website Description:')
			->setOptions(array('Size' => '30'))
			->setRequired(true)
			->addFilter('HtmlEntities')
			->addFilter('StringTrim');

		// create select input for skins
		$skin = new Zend_Form_Element_Select('skins');
		$skin->setLabel('Select skin:')
		        ->setRequired(true)               
		        ->addFilter('HtmlEntities'); 	
		foreach ($this->getSkin() as $s) 
		{
	  		$skin->addMultiOption($s, $s);
		} 
		
			
		// create text input for default email
		$admin = new Zend_Form_Element_Text('adminEmailAddress');
		$admin->setLabel('Admin email address:')
			->setOptions(array('Size' => '30'))
			->setRequired(true)
			->addValidator('EmailAddress')
			->addFilter('HtmlEntities')
			->addFilter('StringTrim');
			
		// create text input for contact email
		$contact = new Zend_Form_Element_Text('contactEmailAddress');
		$contact->setLabel('Contact email address:')
			->setOptions(array('Size' => '30'))
			->addValidator('EmailAddress')
			->addFilter('HtmlEntities')
			->addFilter('StringTrim');

		// create from contact input for contact email
		$fromContact = new Zend_Form_Element_Text('fromContactEmail');
		$fromContact->setLabel('SMTP Transport Username:')
			->setOptions(array('Size' => '30'))
			->addValidator('EmailAddress')
			->addFilter('HtmlEntities')
			->addFilter('StringTrim');

		// create from protocol input for contact email
		$fromProtocol = new Zend_Form_Element_Text('fromProtocol');
		$fromProtocol->setLabel('SMTP Transport Protocol:')
			->setOptions(array('Size' => '30'))
			->addFilter('HtmlEntities')
			->addFilter('StringTrim');

		// create from port input for contact email
		$fromPort = new Zend_Form_Element_Text('fromPort');
		$fromPort->setLabel('SMTP Transport port:')
			->setOptions(array('Size' => '30'))
			->addFilter('HtmlEntities')
			->addFilter('StringTrim');

		// create password specific input for contact email
		$password = new Zend_Form_Element_Text('passwordSpecific');
		$password->setLabel('SMTP Transport Password:')
			->setOptions(array('Size' => '30'))
			->addFilter('HtmlEntities')
			->addFilter('StringTrim');
	
			
		// create submit button
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Save Configuration')
			->setOptions(array('class' => 'submit'));
			
		// attach elements to form
		$this->addElement($headTitle)
			->addElement($siteTitle)
			->addElement($siteDescription)
			->addElement($skin)
			->addElement($admin)
			->addElement($contact)
			->addElement($fromContact)
			->addElement($fromProtocol)
			->addElement($fromPort)
			->addElement($password)
			->addElement($submit);

		// add display group
		$this->addDisplayGroup(
			array('headTitle', 'siteTitle', 'siteDescription', 'skins'), 'site-information');
		$this->getDisplayGroup('site-information')->setLegend('Site Information');   
		
		$this->addDisplayGroup(
			array('adminEmailAddress', 'contactEmailAddress'),'contact-information');
		$this->getDisplayGroup('contact-information')->setLegend('Contact Information');
		
		$this->addDisplayGroup(
			array('fromContactEmail', 'fromProtocol', 'fromPort', 'passwordSpecific'),'smtp-information');
		$this->getDisplayGroup('smtp-information')->setLegend('SMTP Information');
	}
	
	public function getSkin()
	{
		$d = APPLICATION_PATH . '/../public/skins';
    	foreach (array_diff(scandir($d),array('.','..')) as $f)if(is_dir($d.'/'.$f))$l[]=$f;
       	return $l;
	} 
}


















