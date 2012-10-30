<?php
class Form_SearchForm extends Zend_Form
{
	public function init()
	{
		$this->setAction('/search');
		$this->setMethod('get');
		
		// create query element
		$query = $this->createElement('text', 'query');
		$query->setRequired(true);
		$query->setLabel('Search');
		$query->setAttrib('size', 10);
		$this->addElement($query);
		
		// create submit element
		$submit = $this->createElement('submit', 'search');
		$submit->setLabel('Search');
		$submit->setDecorators(array('ViewHelper'));
		$this->addElement($submit);
	}
}
