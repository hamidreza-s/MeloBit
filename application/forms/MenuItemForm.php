<?php
class Form_MenuItemForm extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');
		
		// create hidden id element
		$id = $this->createElement('hidden', 'id');
		$id->setDecorators(array('ViewHelper'));
		$this->addElement($id);
		
		// create hidden menuId element
		$menuId = $this->createElement('hidden', 'menu_id');
		$menuId->setDecorators(array('ViewHelper'));
		$this->addElement($menuId);
		
		// create label element
		$label = $this->createElement('text', 'label');
		$label->setLabel('Label:');
		$label->setRequired(true);
		$label->addFilter('StripTags');
		$label->setAttrib('size', 30);
		$this->addElement($label);
		
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
				$pageId->addMultiOption($page->id, $page->name);
			}
		}
		$this->addElement($pageId);
		
		// create link element
		$link = $this->createElement('text', 'link');
		$link->setLabel('or specify a link:');
		$link->setRequired(false);
		$link->setAttrib('size', 30);
		$this->addElement($link);
		
		// create submit element
		$this->addElement('submit', 'submit', array('label' => 'Submit'));
	}
}

















