<?php
class Sms_Form_OrderTransactionForm extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		$this->setAttrib('class', 'jQueryValidation');
		$this->setAttrib('id', 'transactionForm');

		// create hidden id
		$id = $this->createElement('hidden', 'id');
		$id->setDecorators(array('ViewHelper'));
		$this->addElement($id);
		
		// create hidden order_id
		$order_id = $this->createElement('hidden', 'order_id');
		$order_id->setDecorators(array('ViewHelper'));
		$this->addElement($order_id);

		// create receipt_number
		$receipt_number = $this->createElement('text', 'receipt_number')
			->setLabel('Receipt Number:')
			->setRequired(true)
			->setAttrib('class', 'validate[required]')
			->setAttrib('size', 30);
		$this->addElement($receipt_number);				
		
		// create bank_account
		$bank_account = $this->createElement('select', 'bank_account')
			->setLabel('Bank Account:')
			->setRequired(true);
		foreach ($this->getBankAccounts() as $key => $value)
		{
			$bank_account->addMultiOption($key, $value);
		}
		$this->addElement($bank_account);
	
		// create deposit_date
		$deposit_date = $this->createElement('text', 'deposit_date')
			->setLabel('Diposit Date (yyyy-mm-dd hh:mm):')
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
			->setAttrib('style', 'display: inline')			
			->setAttrib('class', 'validate[required,custom[dateTime24]]')
			->setDecorators(array(
				'ViewHelper',
				'Description',
				'Errors',
				array('Label', array('tag' => 'dt')),	
				array(
					array('CalcImage' => 'HtmlTag'), 
					array(
						'tag' => 'img', 
						'src' =>'/images/misc/calendar-icon.png', 
						'placement' => 'append', 
						'class' => 'textInputImage',
						'id' => 'depositDateChooserImge'
					),
				),
			));;
		$this->addElement($deposit_date);
	
		// create depositor_name 	
		$depositor_name 	 = $this->createElement('text', 'depositor_name')
			->setLabel('Depositor Name:')
			->setRequired(true)
			->setAttrib('class', 'validate[required]')
			->setAttrib('size', 30);
		$this->addElement($depositor_name 	);	

		// create deposit_fee 	
		$deposit_fee 	 = $this->createElement('text', 'deposit_fee')
			->setLabel('Deposit Fee:')
			->setRequired(true)
			->setAttrib('class', 'validate[required]')
			->setAttrib('size', 30);
		$this->addElement($deposit_fee);	

		// create submit
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit Form')
			->setAttrib('id', 'transactionSubmit');
		$this->addElement($submit);		
	}
	
	public function getBankAccounts()
	{
		$account['0102355672008'] = 'Saderat 2008';
		$account['6037691089150882'] = 'Saderat Card';
		$account['0100225975005'] = 'Saderat 5005';
		$account['1867185866'] = 'Mellat';
		
		return $account;
	}
}




























