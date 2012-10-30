<?php
class PageController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$pageModel = new Model_PageModel();
		$recentPages = $pageModel->getRecentPages();

		if (is_array($recentPages))
		{
			// the 3 most recent items are the featured items
			for ($i = 1; $i <= 4; $i++)
			{
				if (count($recentPages) > 0)
				{
					$featuredItems[] = array_shift($recentPages);
				}
			}

			$this->view->featuredItems = $featuredItems;
			
			// show remaining items; if exist
			if (count($recentPages) > 0)
			{
				$this->view->recentPages = $recentPages;
			}
			else
			{
				$this->view->recentPages = null;
			}
		}
	}
	
	public function openAction()
	{
		$id = $this->_request->getParam('id');
		
		// confirm the page exists
		$pageModel = new Model_PageModel();
		$select = $pageModel->select();
		$select->where('id = ?', $id);
		$row = $pageModel->fetchRow($select);

		// check the cache
		$bootstrap = $this->getInvokeArg('bootstrap');
		$cache = $bootstrap->getResource('cache');
		$cacheKey = 'content_page_' . $id;
		$page = $cache->load($cacheKey);
		if (!$page)
		{
			if ($row instanceof Zend_Db_Table_Row)
			{
				$page = new Melobit_Content_Item_Page($row);
			}
			else
			{
				$page = new Melobit_Content_Item_Page($id);
			}
			// add a cache tag to this menu
			// so that you can update the cached menu when you update the page
			$tags[] = 'cache_tag_content_' . $page->id;
			$cache->save($page, $cacheKey, $tags);
		}
		$this->view->page = $page;
		$this->_helper->layout->setLayout('page');
	}

	public function createAction()
	{
		$pageForm = new Form_PageForm;
		$pageForm->setAction('/page/create');
		
		// if form is posted back
		if ($this->getRequest()->isPost())
		{
			if ($pageForm->isValid($_POST))
			{
				// 1, create a new page item
				$itemPage = new Melobit_Content_Item_Page();
				$itemPage->name = $pageForm->getValue('name');
				$itemPage->headline = $pageForm->getValue('headline');
				$itemPage->description = $pageForm->getValue('description');
				$itemPage->content = $pageForm->getValue('content');
				$itemPage->parent_id = $pageForm->getValue('parentId');
				// 2, rename and upload the image
				if ($pageForm->image->isUploaded())
				{
					$newImageName = time() . '_' . basename($pageForm->image->getFileName());
					$pageForm->image->addFilter('Rename', $newImageName);
					$pageForm->image->receive();
					$itemPage->image = '/images/upload/' . $newImageName;
				}
				// 3, save the content item
				$itemPage->save();
				return $this->_forward('list');
			}
		}
		
		//$pageModel = new Model_PageModel();
		//Zend_Debug::dump($pageModel->getDefinition());
		//Zend_Debug::dump(get_class_methods(Model_PageModel)); die;

		
		$this->view->form = $pageForm;
	}
	
	public function listAction()
	{
		$pageModel = new Model_PageModel();
		
		// fetch all of the current pages
		$select = $pageModel->select();
		$select->order('name');
		$select->where("namespace = ?", "page");
		$currentPages = $pageModel->fetchAll($select);
		if ($currentPages->count() > 0)
		{
			$this->view->pages = $currentPages;
		}
		else
		{
			$this->view->pages = null;
		}
	}
	
	public function editAction()
	{
		$id = $this->_request->getParam('id');
		$itemPage = new Melobit_Content_Item_Page($id);
		$pageForm = new Form_PageForm();
		$pageForm->setAction('/page/edit');

		// if form is posted back
		if ($this->_request->isPost())
		{
			if ($pageForm->isValid($_POST))
			{
				// 1, edit the page item
				$itemPage->name = $pageForm->getValue('name');
				$itemPage->headline = $pageForm->getValue('headline');
				$itemPage->description = $pageForm->getValue('description');
				$itemPage->content = $pageForm->getValue('content'); 
				// 2, upload the image
				if ($pageForm->image->isUploaded())
				{
					// first delete previous image				
					if ($itemPage->image)
					{	
						unlink(APPLICATION_PATH . '/../public' . $itemPage->image);
					}
					
					// then upload new image
					$newImageName = time() . '_' . basename($pageForm->image->getFileName());
					$pageForm->image->addFilter('Rename', $newImageName);
					$pageForm->image->receive();
					$itemPage->image = '/images/upload/' . $newImageName;
				}
				// 3, save the content item
				$itemPage->save();
				return $this->_forward('list');
			}
		}
		
		$pageForm->populate($itemPage->toArray());
		
		// create the image preview
		$imagePreview = $pageForm->createElement('image', 'image_preview');
		$imagePreview->setLabel('Preview Image:');
		$imagePreview->setAttrib('style', 'width:200px;height:auto;');
		$imagePreview->setOrder(4);
		$imagePreview->setImage($itemPage->image);
		$pageForm->addElement($imagePreview);
		
		$this->view->form = $pageForm;
	}
	
	public function deleteAction()
	{
		$id = $this->_request->getParam('id');
		$itemPage = new Melobit_Content_Item_Page($id);
		if ($itemPage->image) { unlink(APPLICATION_PATH . '/../public' . $itemPage->image); }
		$itemPage->delete();
		return $this->_forward('list');
	}
}





























