<?php
class Form_UploadForm extends Zend_Form
{
	public function init()
	{
		$this->setAction('post');
		$this->setAttrib('enctype', 'multipart/form-data');
				
		$form = $this->createElement('file', 'file');
		$form->setLabel('Upload your file');
		$form->addValidator('size', false, 1024000000);
		$form->setDestination(APPLICATION_PATH . "/../public/temp");
		$this->addElement($form);
		
		$this->addElement('submit', 'submit', array('label' => 'Upload'));
	}
}
