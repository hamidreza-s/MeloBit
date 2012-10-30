<?php
class Form_MenuForm extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		
		// create hiddent id element
		$id = $this->createElement('hidden', 'id');
		$id->setDecorators(array('ViewHelper'));
		$this->addElement($id);

		// create name element
		$name = $this->createElement('text', 'name');
		$name->setLabel('Name:');
		$name->setRequired(true);
		$name->setAttrib('size', 30);
		$name->addFilter('StripTags');
		$this->addElement($name);
		
		// create pageId element
		$pageId = $this->createElement('select', 'page_id');
		$pageId->setLabel('Select a page to link to:');
		$pageId->setRequired(true);
		// populate this with pages
		$modelPage = new Model_PageModel();
		$pages = $modelPage->fetchAll(null, 'name');
		$pageId->addMultiOption(0, 'None');
		if ($pages->count() > 0)
		{
			foreach ($pages as $page)
			{
				if ($page->namespace == 'page')
				{
					$pageId->addMultiOption($page->id, $page->name);
				}
			}
		}
		$this->addElement($pageId);
		
		// create link element
		$link = $this->createElement('text', 'link');
		$link->setLabel('or specify a link:');
		$link->setRequired(false);
		$link->setAttrib('size', 30);
		$this->addElement($link);
		
		// create access level element
		$access = $this->createElement('select', 'access_level');
		$access->setLabel('Select menu access level:');
		$access->setRequired(true);
		$access->addMultiOption('public', 'Public');
		$access->addMultiOption('private', 'Private');
		$this->addElement($access);
		
		// create submit element
		$this->addElement('submit', 'submit', array('label' => 'Submit')); 
	}
}












