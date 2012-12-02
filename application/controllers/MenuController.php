<?php
class MenuController extends Zend_Controller_Action
{
	public function init()
	{
		
	}
	
	public function indexAction()
	{
		$menuModel = new Model_MenuModel();
		$this->view->menus = $menuModel->getMenu();
	}
	
	public function editAction()
	{
		$id = $this->_request->getParam('id');
		$formMenu = new Form_MenuForm();
		
		// if this is a postback, process the form
		if ($this->getRequest()->isPost())
		{
			if ($formMenu->isValid($_POST))
			{
				$data = $formMenu->getValues();
				$modelMenu = new Model_MenuModel();
				$result = $modelMenu->updateMenu($id, $data['name'], $data['page_id'], $data['link'], $data['access_level']);
				if ($result)
				{
					// redirect to the index action
					return $this->_forward('index');
				}
			}
		}
		
		// fetch the current menu from DB
		$modelMenu = new Model_MenuModel();
		$currentMenu = $modelMenu->find($id)->current();
		
		// populate the form
		$formMenu->populate($currentMenu->toArray());
		$this->view->form = $formMenu;
	}
	
	public function createAction()
	{
		$formMenu = new Form_MenuForm();
		
		if ($this->getRequest()->isPost())
		{
			if ($formMenu->isValid($_POST))
			{
				$data = $formMenu->getValues();
				$menuModel = new Model_MenuModel();
				$result = $menuModel->createMenu(
					$data['name'], $data['page_id'], $data['link'], $data['access_level']);
				if ($result)
				{
					$this->_forward('/index');
				}
			}
		}
		
		$this->view->form = $formMenu;
	}
	
	public function deleteAction()
	{
		$id = $this->_request->getParam('id');
		$modelMenu = new Model_MenuModel();
		$modelMenu->deleteMenu($id);
		$this->_forward('index');
	}
	
	public function renderAction()
	{
		// fetch the Zend_Cache object
		$bootstrap = $this->getInvokeArg('bootstrap');
		$cache = $bootstrap->getResource('cache');

		// which menu load from cache
		$auth = Zend_Auth::getInstance();
		$cacheKey = (!$auth->hasIdentity()) ? "menus_public" : "menus_private";

		// atempt to load menus from cache
		$container = $cache->load($cacheKey);
		if (!$container)
		{
			$menus = new Model_MenuModel();
			$menus = $menus->getMenu();
			$menuItemModel = new Model_MenuItemModel;
		
			if ($menus)
			{			
				// loop menus
				foreach ($menus as $menu)
				{
					// if user is "guest"
					// hide private menu
					if ($menu->access_level == 'private')
					{
						$auth = Zend_Auth::getInstance();
						if (!$auth->hasIdentity())
						{
							continue;
						}
					}	
				
					// set up menu uri		
					if (!empty($menu->link))
					{
						$MenuUri = $menu->link;
					}
					else
					{
						// SEO-friendly url
						$page = new Melobit_Content_Item_Page($menu->page_id);
						if ($page) 
						{
							$MenuUri = '/pages/' . $menu->page_id . '/' . $page->name;
						}
						else
						{
							$MenuUri = '/page/dead-link';
						}
					}

					// add a cache tag so you can update the menus
					$tags[] = 'cache_tag_menu_' . $menu->id;
				
					// loop item 
					$menuItems = $menuItemModel->getItemsByMenu($menu->id);
					if ($menuItems)
					{
						foreach ($menuItems as $menuItem)
						{
							if (!empty($menuItem->link))
							{
								$MenuItemUri = $menuItem->link;
							}
							else
							{
								// SEO-friendly url
								$page = new Melobit_Content_Item_Page($menuItem->page_id);
								if ($page)
								{
									$MenuItemUri = '/pages/' . $menuItem->page_id . '/' . $page->name;
								}
								else
								{
									$MenuItemUri = '/dead-link';
								}
							}

							// add a cache tag so you can update the menu items
							$tags[] = 'cache_tag_menu_item_' . $menuItem->id;

							$navMenuItems[] = Zend_Navigation_Page::factory(array(
									'label'		=> $menuItem->label,
									'uri'		=> $MenuItemUri,
							));
						}
						
						$itemArray[] = array(
								'label'	=> $menu->name, 
								'uri'	=> $MenuUri, 
								'pages'	=> $navMenuItems);
					}
					else
					{
						$itemArray[] = array(
						'label'	=> $menu->name, 
						'uri'	=> $MenuUri);					
					}
					
					// empty $navMenuItems
					$navMenuItems = null;
				}
			// create Zend_Navigation	
			$container = new Zend_Navigation($itemArray);
			
			// cache the container
			$cache->save($container, $cacheKey, $tags);
			}
		}
		if ($container) $this->view->navigation()->setContainer($container);
	}

	public function moveAction()
	{
		$id = $this->_request->getParam('id');
		$direction = $this->_request->getParam('direction');
		$modelMenu = new Model_MenuModel();
		$menu = $modelMenu->find($id)->current();

		if ($direction == 'up')
		{
			$modelMenu->moveUp($id);
		}
		elseif ($direction = 'down')
		{
			$modelMenu->moveDown($id);
		}
		
		$this->_forward('index');		
	}
}

















