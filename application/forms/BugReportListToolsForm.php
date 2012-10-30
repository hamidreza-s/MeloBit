<?php
class Form_BugReportListToolsForm extends Zend_Form
{
	public function init()
	{
		$options = array(
			'0'			=>	'None',
			'id'		=>	'ID',
			'priority'	=>	'Priority',
			'status'	=>	'Status',
			'date'		=>	'Date',
			'url'		=>	'URL',
			'author'	=>	'Submitter'
		);
		
		$sort = $this->createElement('select', 'sort');
		$sort->setLabel('Sort Records:');
		$sort->addMultiOptions($options);
		$this->addElement($sort);
		
		$filterField = $this->createElement('select', 'filter_field');
		$filterField->setLabel('Filter Field:');
		$filterField->addMultiOptions($options);
		$this->addElement($filterField);
		
		$filterText = $this->createElement('text', 'filter_text');
		$filterText->setLabel('Filter Value:');
		$filterText->setAttrib('size', 40);
		$this->addElement($filterText);
		
		$this->addElement('submit', 'submit', array('label' => 'Update List'));
	}
}
?>
