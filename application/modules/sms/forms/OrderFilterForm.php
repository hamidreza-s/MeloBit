<?php
class Sms_Form_OrderFilterForm extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		$this->setAttrib('class', 'jQueryValidation');
		$this->setAttrib('id', 'orderFilterForm');

		// create start_date
		$start_date = $this->createElement('text', 'start_date')
			->setLabel('Start Date (yyyy-mm-dd hh:mm):')
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
			//->setAttrib('class', 'validate[custom[dateTime24]]')
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
						'id' => 'startDateChooserImge'
					),
				),
			));;
		$this->addElement($start_date);

		// create end_date
		$end_date = $this->createElement('text', 'end_date')
			->setLabel('End Date (yyyy-mm-dd hh:mm):')
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
			//->setAttrib('class', 'validate[required,custom[dateTime24]]')
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
						'id' => 'endDateChooserImge'
					),
				),
			));;
		$this->addElement($end_date);		

		// create company_id
		$company_id = $this->createElement('select', 'company_id')
			->setLabel('Select company:')
			->addMultiOption('',''); // default
		foreach ($this->getCompanies() as $key => $value)
		{
			$company_id->addMultiOption($key, $value);
		}
		$this->addElement($company_id);
		
		// create filter_status
		$filter_status = $this->createElement('MultiCheckbox', 'filter_status')
			->setLabel('Filter status:')
			->addMultiOption('order_status','Order status')
			->addMultiOption('control_status','Control status')
			->addMultiOption('dispatch_status','Dispatch status');
		$this->addElement($filter_status);
		
		// create submit
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Filter Results')
			->setAttrib('id', 'transactionSubmit');
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




























