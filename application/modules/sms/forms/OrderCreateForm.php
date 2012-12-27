<?php
class Sms_Form_OrderCreateForm extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		$this->setAttrib('id', 'jQueryValidation');

		// create hidden id
		$id = $this->createElement('hidden', 'id');
		$id->setDecorators(array('ViewHelper'));
		$this->addElement($id);
		
		// create customer_id
		$customer_id = $this->createElement('select', 'customer_id')
			->setLabel('Select a customer:')
			->setRequired(true);
		foreach ($this->getCustomers() as $key => $value)
		{
			$customer_id->addMultiOption($key, $value);
		}
		$this->addElement($customer_id);

		// create sms_content
		$sms_content = $this->createElement('textarea', 'sms_content')
			->setLabel('Enter your message:')
			->setRequired(true)
			->setAttrib('class', 'validate[required]')
			->setAttrib('cols', 43)
			->setAttrib('rows', 4);
		$this->addElement($sms_content);
		
		// create test_phone
		$test_phone = $this->createElement('text', 'test_phone')
			->setLabel('Test Phone:')
			->setRequired(true)
			->setAttrib('size', 30)
			->setAttrib('class', 'validate[required]');
		$this->addElement($test_phone);

		// create submit
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit Form');
		$this->addElement($submit);
	}
	
	public function getCustomers()
	{
		$customerModel = Sms_Model_CustomerModel::listCustomer()->toArray();
		
		$customers[] = '';
		foreach ($customerModel as $customer)
		{
			$customers[$customer['id']] = $customer['first_name'] . ' ' . $customer['last_name']; 
		}
		
		return $customers;
	}
}




























