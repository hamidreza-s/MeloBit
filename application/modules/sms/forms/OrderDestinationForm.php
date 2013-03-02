<?php
class Sms_Form_OrderDestinationForm extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		$this->setAttrib('class', 'jQueryValidation');
		$this->setAttrib('id', 'destinationForm');

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

		// create destination_range
		$destination_range = $this->createElement('select', 'destination_range')
			->setLabel('Destination Range:')
			->setRequired(false)
			->addMultiOption(0, 'Etebari + Daeimi')
			->addMultiOption(1, 'Etebari')
			->addMultiOption(2, 'Daemi');
		$this->addElement($destination_range);
		
		// create destination_province
		$destination_province = $this->createElement('select', 'destination_province')
			->setLabel('Destination Province:')
			->setRequired(false);
		foreach ($this->getDestinationProvince() as $key => $value)
		{
			$destination_province->addMultiOption($key, $value);
		}
		$this->addElement($destination_province);
		
		// create destination_value
		$destination_value = $this->createElement('text', 'destination_value')
			->setLabel('Destination Value:')
			->setRequired(true)
			->setAttrib('class', 'validate[required]')
			->setAttrib('size', 30)
			->setAttrib('style', 'display: inline');
		$this->addElement($destination_value);

		// create dispatch_date
		$dispatch_date = $this->createElement('text', 'dispatch_date')
			->setLabel('Date the issue occurred (yyyy-mm-dd hh:mm):')
			->setRequired(true)
			->addValidator('regex', false, array(
				'pattern' => '/^(\d{2}|\d{4})(?:\-)?([0]{1}\d{1}|[1]{1}[0-2]{1})(?:\-)?([0-2]{1}\d{1}|[3]{1}[0-1]{1})(?:\s)?([0-1]{1}\d{1}|[2]{1}[0-3]{1})(?::)?([0-5]{1}\d{1})$/',
				'messages' => array(
					'regexInvalid'   => "Invalid type given, value should be yyyy-mm-dd hh:mm:ss",
					'regexNotMatch' => "'%value%' does not match against pattern '%pattern%'",
					'regexErrorous'  => "There was an internal error while using the pattern '%pattern%'"
				)
			))
			->setAttrib('size', 30)
			->setAttrib('class', 'validate[required,custom[dateTime24]]');
		$this->addElement($dispatch_date);
		
		// create destination_order
		$destination_order = $this->createElement('select', 'destination_order')
			->setLabel('Destination Order:')
			->setRequired(true)
			->addMultiOption('By Order', 'By Order')
			->addMultiOption('Random', 'Random');
		$this->addElement($destination_order);
		
		// create destination_start
		$destination_start = $this->createElement('text', 'destination_start')
			->setLabel('Destination Start:')
			->setRequired(true)
			->setAttrib('class', 'validate[required]')
			->setAttrib('size', 30);
		$this->addElement($destination_start);	
			
		// create destination_end
		$destination_end = $this->createElement('text', 'destination_end')
			->setLabel('Destination End:')
			->setRequired(true)
			->setAttrib('class', 'validate[required]')
			->setAttrib('size', 30);
		$this->addElement($destination_end);
		
		// create submit
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit Form')
			->setAttrib('id', 'destinationSubmit');
		$this->addElement($submit);
	}
	
	public function getDestinationTypes()
	{
		$types['Postal Code'] = 'Postal Code';
		$types['Province Name'] = 'Province Name';
		
		return $types;
	}
	
	public function getDestinationProvince()
	{
		$provinces['01'] = 'Azarbaijan Sharghi';
		$provinces['02'] = 'Azarbaijan Gharbi';
		
		return $provinces;
	}
	
}




























