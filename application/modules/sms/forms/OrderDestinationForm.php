<?php
class Sms_Form_OrderDestinationForm extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		$this->setAttrib('id', 'jQueryValidation');

		// create hidden id
		$id = $this->createElement('hidden', 'id');
		$id->setDecorators(array('ViewHelper'));
		$this->addElement($id);
		
		// create hidden order_id
		$order_id = $this->createElement('hidden', 'order_id');
		$order_id->setDecorators(array('ViewHelper'));
		$this->addElement($order_id);

		// create destination_type
		$destination_type = $this->createElement('select', 'destination_type')
			->setLabel('Destination Type:')
			->setRequired(true);
		foreach ($this->getDestinationTypes() as $key => $value)
		{
			$destination_type->addMultiOption($key, $value);
		}
		$this->addElement($destination_type);
		
		// create destination_value
		$destination_value = $this->createElement('textarea', 'destination_value')
			->setLabel('Destination Value:')
			->setRequired(true)
			->setAttrib('class', 'validate[required]')
			->setAttrib('cols', 43)
			->setAttrib('rows', 4);
		$this->addElement($destination_value);		
		
		// create dispatch_date
		$dispatch_date = $this->createElement('text', 'dispatch_date')
			->setLabel('Date the issue occurred (mm-dd-yyyy):')
			->setRequired(true)
			->addValidator(new Zend_Validate_Date('MM-DD-YYYY'))
			->setAttrib('size', 30)
			->setAttrib('class', 'validate[required,custom[date-mmddyyyy]]');
		$this->addElement($dispatch_date);
		
		// create submit
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit Form');
		$this->addElement($submit);
	}
	
	public function getDestinationTypes()
	{
		$types[] = '';
		$types[] = 'Type 1';
		$types[] = 'Type 2';
		$types[] = 'Type 3';
		$types[] = 'Type 4';
		
		return $types;
	}
}




























