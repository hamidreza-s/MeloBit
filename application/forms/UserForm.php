<?php
class Form_UserForm extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
	
		// create hidden id element
		$id = $this->createElement('hidden', 'id');
		$id->setDecorators(array('ViewHelper'));
		$this->addElement($id);
	
		// create username element
		$username = $this->createElement('text', 'username');
		$username->setLabel('Username:');
		$username->setRequired(true);
		$username->addFilter('StripTags');
		$username->addErrorMessage('The username is required!');
		$this->addElement($username);
	
		// create password element
		$password = $this->createElement('password', 'password');
		$password->setLabel('Password:');
		$password->setRequired(true);
		$this->addElement($password);
	
		// create firstname element
		$username = $this->createElement('text', 'first_name');
		$username->setLabel('First Name:');
		$username->setRequired(true);
		$username->addFilter('StripTags');
		$this->addElement($username);
	
		// create lastname element
		$lastname = $this->createElement('text', 'last_name');
		$lastname->setLabel('Last Name:');
		$lastname->setRequired(true);
		$lastname->addFilter('StripTags');
		$this->addElement($lastname);

		// create role element
		$role = $this->createElement('select', 'role');
		$role->setLabel('Select a role:');
		$role->addMultiOption('user', 'User');
		$role->addMultiOption('administrator', 'Administrator');
		$this->addElement($role);
	
		// create submit element
		$submit = $this->addElement('submit', 'submit', array('label' => 'Submit'));
	}
}

























