<?php
class Sms_Form_OrderForm extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		$this->setAttrib('id', 'jQueryValidation');

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
		
		// create order_status
		$order_status = $this->createElement('checkbox', 'order_status')
			->setLabel('Order Status')
			->setCheckedValue(1)
			->setUncheckedValue(2);

		// create submit
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Send Message');
		$this->addElement($submit);
	}
	
	public function getCustomers()
	{
		$customers['1'] = 'c1';
		$customers['2'] = 'c2';
		return $customers;
	}
}




























