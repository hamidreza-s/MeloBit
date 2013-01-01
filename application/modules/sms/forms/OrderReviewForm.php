<?php
class Sms_Form_OrderReviewForm extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		$this->setAttrib('id', 'jQueryValidation');

		// create hidden order_id
		$order_id = $this->createElement('hidden', 'order_id');
		$id->setDecorators(array('ViewHelper'));
		$this->addElement($order_id);
		
		// create order_status
		$order_status = $this->createElement('checkbox', 'order_status')
			->setLabel('Order Status')
			->setCheckedValue(1)
			->setUncheckedValue(0);
		$this->addElement($order_status);		
		
		// create submit
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit Form');
		$this->addElement($submit);
	}
}




























