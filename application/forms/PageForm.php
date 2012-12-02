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
		
		// create en headline element
		$headline_en = $this->createElement('text', 'headline_en');
		$headline_en->setLabel('Headline (en):');
		$headline_en->setRequired(true);
		$headline_en->setAttrib('size', 20);
		$this->addElement($headline_en);

		// create fa headline element
		$headline_fa = $this->createElement('text', 'headline_fa');
		$headline_fa->setLabel('Headline (fa):');
		$headline_fa->setRequired(true);
		$headline_fa->setAttrib('size', 20);
		$this->addElement($headline_fa);

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
		
		// create en description element
		$description_en = $this->createElement('textarea', 'description_en');
		$description_en->setLabel('Description (en):');
		$description_en->setRequired(true);
		$description_en->setAttrib('cols', 40);
		$description_en->setAttrib('rows', 4);
		$description_en->setAttrib('class', 'withEditor');
		$this->addElement($description_en);

		// create description element
		$description_fa = $this->createElement('textarea', 'description_fa');
		$description_fa->setLabel('Description (fa):');
		$description_fa->setRequired(true);
		$description_fa->setAttrib('cols', 40);
		$description_fa->setAttrib('rows', 4);
		$description_fa->setAttrib('class', 'withEditor');
		$this->addElement($description_fa);
		
		// create content element
		$content_en = $this->createElement('textarea', 'content_en');
		$content_en->setLabel('Content (en):');
		$content_en->setRequired(true);
		$content_en->setAttrib('cols', 40);
		$content_en->setAttrib('rows', 4);
		$content_en->setAttrib('class', 'withEditor');
		$this->addElement($content_en);

		// create content element
		$content_fa = $this->createElement('textarea', 'content_fa');
		$content_fa->setLabel('Content (fa):');
		$content_fa->setRequired(true);
		$content_fa->setAttrib('cols', 40);
		$content_fa->setAttrib('rows', 4);
		$content_fa->setAttrib('class', 'withEditor');
		$this->addElement($content_fa);
		
		// create submit element
		$this->addElement('submit', 'submit', array('label' => 'Submit'));
	}
}






















