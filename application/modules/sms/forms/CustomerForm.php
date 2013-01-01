<?php
class Sms_Form_CustomerForm extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		$this->setAttrib('id', 'jQueryValidation');
		
		// create hidden id
		$id = $this->createElement('hidden', 'id');
		$id->setDecorators(array('ViewHelper'));
		$this->addElement($id);
		
		// create company_id
		$company_id = $this->createElement('select', 'company_id')
			->setLabel('Select company:')
			->setRequired(true);
		foreach ($this->getCompanies() as $key => $value)
		{
			$company_id->addMultiOption($key, $value);
		}
		$this->addElement($company_id);
		
		// create first_name
		$first_name = $this->createElement('text', 'first_name')
			->setLabel('First name:')
			->setRequired(true)
			->setAttrib('size', 30)
			->setAttrib('class', 'validate[required]');
		$this->addElement($first_name);

		// create last_name
		$last_name = $this->createElement('text', 'last_name')
			->setLabel('Last name:')
			->setRequired(true)
			->setAttrib('size', 30)
			->setAttrib('class', 'validate[required]');
		$this->addElement($last_name);
	
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
	
	public function getCompanies()
	{
		$companyModel = Sms_Model_CompanyModel::listCompany()->toArray();

		foreach ($companyModel as $company)
		{
			$companies[$company['id']] = $company['name']; 
		}
		
		return $companies;
	}
}




























