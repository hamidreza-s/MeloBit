<?php
class Model_MenuItemModel extends Zend_Db_Table_Abstract
{
	protected $_name = 'menu_items';
	protected $_referenceMap = array(
		'Menu'	=>	array(
			'columns'		=>	array('menu_id'),
			'refTableClass'	=>	'Model_MenuModel',
			'refColumns'	=>	array('id'),
			'onDelete'		=>	self::CASCADE,
			'onUpdate'		=>	self::RESTRICT
		)
	);
	
	public function getItemsByMenu($menuId)
	{
		$select = $this->select();
		$select->where("menu_id = ?", $menuId);
		$select->order("position");
		$items = $this->fetchAll($select);
		if ($items->count() > 0)
		{
			return $items;
		}
		else
		{
			return null;
		}
	}
	
	public function addItem($menuId, $label, $pageId = 0, $link = null)
	{
		// first clear the cached entry for this menu
		$cache = Zend_Registry::get('cache');
	    $cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('cache_tag_menu_' . $menuId));
	    
		$row = $this->createRow();
		$row->menu_id = $menuId;
		$row->label = $label;
		$row->page_id = $pageId;
		$row->link = $link;
		$row->position = $this->_getLastPosition($menuId) + 1;
		return $row->save();
	}
	
	private function _getLastPosition($menuId)
	{
		$select = $this->select();
		$select->where("menu_id = ?", $menuId);
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
	
	public function moveUp($itemId)
	{
		$row = $this->find($itemId)->current();
		if ($row)
		{
			// first clear the cached entry for this menu item
			$cache = Zend_Registry::get('cache');
			$cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('cache_tag_menu_item_' . $itemId));
			
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
				$select->where("menu_id = ?", $row->menu_id);
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
	
	public function moveDown($itemId)
	{
		$row = $this->find($itemId)->current();
		if ($row)
		{
			// first clear the cached entry for this menu item
			$cache = Zend_Registry::get('cache');
			$cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('cache_tag_menu_item_' . $itemId));

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
				$select->where("menu_id = ?", $row->menu_id);
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
	
	public function updateItem($itemId, $label, $pageId = 0, $link = null)
	{
		$row = $this->find($itemId)->current();
		if ($row)
		{
			// first clear the cached entry for this menu
			$cache = Zend_Registry::get('cache');
		    $cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('cache_tag_menu_item_' . $itemId));
		    
		    // then update the menu item
			$row->label = $label;
			$row->page_id = $pageId;
			if ($pageId < 1)
			{
				$row->link = $link;
			}
			else
			{
				$row->link = null;
			}
			return $row->save();
		}
		else
		{
			throw new Zend_Exception ("Error loading menu item");
		}
	}
	
	public function deleteItem($itemId)
	{
		$row = $this->find($itemId)->current();
		if ($row)
		{
			// first clear the cached entry for this menu item
			$cache = Zend_Registry::get('cache');
			$cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('cache_tag_menu_item_' . $itemId));
			
			// then delete it
			return $row->delete();
		}
		else
		{
			throw new Zend_Exception ("Error loading menu item");
		}
	}
}






















