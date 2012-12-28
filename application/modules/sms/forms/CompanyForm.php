<?php
class Sms_Form_CompanyForm extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		$this->setAttrib('id', 'jQueryValidation');
		
		// create hidden id
		$id = $this->createElement('hidden', 'id');
		$id->setDecorators(array('ViewHelper'));
		$this->addElement($id);	
		
		// create name
		$name = $this->createElement('text', 'name')
			->setLabel('Company name:')
			->setRequired(true)
			->setAttrib('size', 30)
			->setAttrib('class', 'validate[required]');
		$this->addElement($name);
		
		// create field
		$field = $this->createElement('select', 'field')
			->setLabel('Select company field:')
			->setRequired(true);
		foreach ($this->getCompanyFields() as $c)
		{
			$field->addMultiOption($c, $c);
		}
		$this->addElement($field);
		
		// create contact_number_1
		$contact_number_1 = $this->createElement('text', 'contact_number_1')
			->setLabel('Contact Number (1):')
			->setRequired(true)
			->setAttrib('size', 30)
			->setAttrib('class', 'validate[required]');
		$this->addElement($contact_number_1);
		
		// create contact_number_1
		$contact_number_2 = $this->createElement('text', 'contact_number_2')
			->setLabel('Contact Number (2):')
			->setRequired(true)
			->setAttrib('size', 30)
			->setAttrib('class', 'validate[required]');
		$this->addElement($contact_number_2);
		
		// create address
		$address = $this->createElement('textarea', 'address')
			->setLabel('Address:')
			->setRequired(true)
			->setAttrib('class', 'validate[required]')
			->setAttrib('cols', 50)
			->setAttrib('rows', 2);
		$this->addElement($address);

		// create submit
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit Form');
		$this->addElement($submit);
	}
	
	public function getCompanyFields()
	{
		$fields[] = 'N/A';
		$fields[] = 'N/A';
		$fields[] = 'N/A';
		return $fields;
	}
}




























