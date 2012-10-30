<?php
class Model_MenuModel extends Zend_Db_Table_Abstract
{
	protected $_name = 'menus';
	protected $_dependentTables	= array('Model_MenuItemModel');
	
	public function createMenu($name, $pageId = 0, $link = null, $access_level = 'public')
	{
		// first clear the cache to show the new menu
		$cache = Zend_Registry::get('cache');
	    $cache->clean(Zend_Cache::CLEANING_MODE_ALL);
	    
	    // then create new menu
		$row = $this->createRow();
		$row->name = $name;
		$row->page_id = $pageId;
		$row->link = $link;
		$row->access_level = $access_level;
		$row->position = $this->_getLastPosition() + 1;
		return $row->save();
	}
	
	public function getMenu()
	{
		$select = $this->select();
		$select->order('position DESC');
		$menus = $this->fetchAll($select);
		if ($menus->count() > 0)
		{
			return $menus;
		}
		else
		{
			return null;
		}
	}
	
	public function updateMenu($id, $name, $pageId = 0, $link = null, $access_level = 'public')
	{
		$currentMenu = $this->find($id)->current();
		if ($currentMenu)
		{
			// first clear the cached entry for this menu
			$cache = Zend_Registry::get('cache');
		    $cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('cache_tag_menu_' . $id));
			
			// then update the menu
			$currentMenu->name = $name;
			$currentMenu->page_id = $pageId;	
			$currentMenu->access_level = $access_level;		
			if ($pageId < 1)
			{
				$currentMenu->link = $link;
			}
			else
			{
				$currentMenu->link = null;
			}
			return $currentMenu->save();
		}
		else
		{
			return false;
		}
	}
	
	public function deleteMenu($menuId)
	{
		$row = $this->find($menuId)->current();
		if ($row)
		{
			// first clear the cached entry for this menu
			$cache = Zend_Registry::get('cache');
		    $cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('cache_tag_menu_' . $menuId));
		    
		    // then delete it
			return $row->delete();
		}
		else
		{
			throw new Zend_Exception("Error loadin manu");
		}
	}
	
	public function moveDown($menuId)
	{
		$row = $this->find($menuId)->current();
		if ($row)
		{
			// first clear the cached entry for this menu
			$cache = Zend_Registry::get('cache');
		    $cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('cache_tag_menu_' . $menuId));
		    
		    // then move it
			if ($row->position < 1)
			{
				// this is already the first
				return null;
			}
			else
			{
				// find the privious item
				$select = $this->select();
				$select->order("position DESC");
				$select->where("position < ?", $row->position);
				$previousItem = $this->fetchRow($select);
				if ($previousItem)
				{
					// switch positions with the previous item
					$previousPosition = $previousItem->position;
					$previousItem->position = $row->position;
					$previousItem->save();
					$row->position = $previousPosition;
					$row->save();
				}
			}
		}
		else
		{
			throw new Zend_Exception("Error loading menu item");
		}
	}
	
	public function moveUp($menuId)
	{
		$row = $this->find($menuId)->current();
		if ($row)
		{
			// first clear the cached entry for this menu
			$cache = Zend_Registry::get('cache');
		    $cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('cache_tag_menu_' . $menuId));
		    
		    // then move it
			if ($row->position < 1)
			{
				// this is already the first
				return null;
			}
			else
			{
				// find the privious item
				$select = $this->select();
				$select->order("position ASC");
				$select->where("position > ?", $row->position);
				$nextItem = $this->fetchRow($select);
				if ($nextItem)
				{
					// switch positions with the next item
					$nextPosition = $nextItem->position;
					$nextItem->position = $row->position;
					$nextItem->save();
					$row->position = $nextPosition;
					$row->save();
				}
			}
		}
		else
		{
			throw new Zend_Exception("Error loading menu item");
		}
	}

	private function _getLastPosition()
	{
		$select = $this->select();
		$select->order("position DESC");
		$row = $this->fetchRow($select);
		if ($row)
		{
			return $row->position;
		}
		else
		{
			return 0;
		}
	}
}
















