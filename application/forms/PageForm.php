<?php
class Form_PageForm extends Zend_Form
{
	public function init()
	{
		$this->setAttrib('enctype', 'multipart/form-data');
		
		// create id element
		$id = $this->createElement('hidden', 'id');
		$id->setDecorators(array('ViewHelper'));
		$this->addElement($id);
		
		// create name element
		$name = $this->createElement('text', 'name');
		$name->setLabel('Page Name:');
		$name->setRequired(true);
		$name->setAttrib('size', 20);
		$name->addFilter('StringToLower');
		$name->addFilter('pregReplace', array(
				  array('match' => array('/[^a-z0-9]+/'),
				        'replace' => array('-'))));
		$name->addFilter('StringTrim', '-');
		$this->addElement($name);
		
		// create headline element
		$headline = $this->createElement('text', 'headline');
		$headline->setLabel('Headline:');
		$headline->setRequired(true);
		$headline->setAttrib('size', 20);
		$this->addElement($headline);

		/*
		// create parentId element
		$parentId = $this->createElement('select', 'parendId');
		$parentId->setLabel('Parent Page:');
		$parentId->setRequired(true);
		$parentId->addMultiOptions(array(
			'foo'	=>	'bar',
			'baz'	=>	'baf'
		));
		$this->addElement($parentId);
		*/
		
		// create image element
		$image = $this->createElement('file', 'image');
		$image->setLabel('Image:');
		$image->setRequired(false);
		$image->setDestination(APPLICATION_PATH . '/../public/images/upload');
		$image->addValidator('count', false, 1);
		$image->addValidator('size', false, 102400);
		$image->addValidator('extension', false, 'jpg,png,gif');
		$this->addElement($image);
		
		// create description element
		$description = $this->createElement('textarea', 'description');
		$description->setLabel('Description:');
		$description->setRequired(true);
		$description->setAttrib('cols', 40);
		$description->setAttrib('rows', 4);
		$description->setAttrib('class', 'withEditor');
		$this->addElement($description);
		
		// create content element
		$content = $this->createElement('textarea', 'content');
		$content->setLabel('Content:');
		$content->setRequired(true);
		$content->setAttrib('cols', 40);
		$content->setAttrib('rows', 4);
		$content->setAttrib('class', 'withEditor');
		$this->addElement($content);
		
		// create submit element
		$this->addElement('submit', 'submit', array('label' => 'Submit'));
	}
}






















