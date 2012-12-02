<?php
class MenuItemController extends Zend_Controller_Action
{
	public function init()
	{
		
	}
	
	public function indexAction()
	{
		$this->_redirect('/menu');
	}
	
	public function listAction()
	{
		if ($this->_request->getParam('menu'))
		{
			$menu = $this->_request->getParam('menu');
			$modelMenu = new Model_MenuModel();
			$modelMenuItem = new Model_MenuItemModel();
			$this->view->menu = $modelMenu->find($menu)->current();
			$this->view->items = $modelMenuItem->getItemsByMenu($menu);
		}
		else
		{
			$this->_redirect('/menu');
		}
	}
	
	public function addAction()
	{
		$menu = $this->_request->getParam('menu');

		$modelMenu = new Model_MenuModel();
		$this->view->menu = $modelMenu->find($menu)->current();
		$formMenuItem = new Form_MenuItemForm();
		
		if ($this->getRequest()->isPost())
		{
			if ($formMenuItem->isValid($_POST))
			{
				$data = $formMenuItem->getValues();
				$modelMenuItem = new Model_MenuItemModel();
				$modelMenuItem->addItem($data['menu_id'], $data['label'], $data['page_id'], $data['link']);
				
				// to redirect to /menu-item/list/menu/$menu_id
				$this->_request->setParam('menu', $data['menu_id']);
				$this->_forward('list');
			}
		}
		
		$formMenuItem->populate(array('menu_id' => $menu));
		$this->view->form = $formMenuItem;
	}
	
	public function moveAction()
	{
		$id = $this->_request->getParam('id');
		$direction = $this->_request->getParam('direction');
		$modelMenuItem = new Model_MenuItemModel();
		$menuItem = $modelMenuItem->find($id)->current();

		if ($direction == 'up')
		{
			$modelMenuItem->moveUp($id);
		}
		elseif ($direction = 'down')
		{
			$modelMenuItem->moveDown($id);
		}
		
		$this->_request->setParam('menu', $menuItem->menu_id);
		$this->_forward('list');		
	}
	
	public function updateAction()
	{
		// get url parameter of id
		$id = $this->_request->getParam('id');
		
		// if is a postback
		if ($this->getRequest()->isPost())
		{
			$formMenuItem = new Form_MenuItemForm();
			if ($formMenuItem->isValid($_POST))
			{
				$data = $formMenuItem->getValues();
				$modelMenuItem = new Model_MenuItemModel();
				$result = $modelMenuItem->updateItem($id, $data['label'], $data['page_id'], $data['link']);
				if ($result)
				{
					$this->_request->setParam('menu', $data['menu_id']);
					return $this->_forward('list');
				}
			}
		}
		
		// instansiate MenuItemModel to find MenuItem
		$modelMenuItem = new Model_MenuItemModel();
		$currentMenuItem = $modelMenuItem->find($id)->current();
		
		// instansiate MenuModel to fine Menu
		$modelMenu = new Model_MenuModel();
		$this->view->menu = $modelMenu->find($currentMenuItem->menu_id)->current();
		
		// create and populate the form
		$formMenuItem = new Form_MenuItemForm();
		$formMenuItem->populate($currentMenuItem->toArray());
		$this->view->form = $formMenuItem;
				
	}
	
	public function deleteAction()
	{
		$id = $this->_request->getParam('id');
		$modelMenuItem = new Model_MenuItemModel();
		$currentMenuItem = $modelMenuItem->find($id)->current();
		if ($modelMenuItem->deleteItem($id))
		{
			$this->_request->setParam('menu', $currentMenuItem->menu_id);
			return $this->_forward('list');
		}
	}
}






















