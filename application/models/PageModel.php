<?php
class Model_PageModel extends Zend_Db_Table_Abstract
{
	protected $_name = 'pages';
	protected $_dependentTables	= array('Model_NodeModel');
	protected $_referenceMap	= array(
		'Page' => array(
			'columns'		=>	array('parent_id'),
			'refTableClass'	=>	'Model_PageModel',
			'refColumns'	=>	array('id'),
			'onDelete'		=>	self::CASCADE,
			'onUpdate'		=>	self::RESTRICT
		)
	);
	
	public function createPage($name, $namespace, $parentId = 0)
	{
		// create the new page
		$row = $this->createRow();
		$row->name = $name;
		$row->namespace = $namespace;
		$row->parent_id = $parentId;
		$row->date_created = time();
		$id = $row->save();
		
		// return the id of the just created row
		return $id;
	}
	
	public function updatePage($id, $data)
	{
		// find the page
		$row = $this->find($id)->current();
		if ($row)
		{
			// first clear the cached entry for this page
			$cache = Zend_Registry::get('cache');
			$cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('cache_tag_content_' . $id));
			
			// update each column of page
			$row->name = $data['name'];
			$row->parent_id = $data['parent_id'];
			$row->save();
			
			// unset page value to find nodes
			unset($data['id']);
			unset($data['name']);
			unset($data['parent_id']);
			
			// find other nodes and update them
			if (count($data) > 0)
			{
				$nodeModel = new Model_NodeModel();
				foreach ($data as $key => $value)
				{
					$nodeModel->setNode($id, $key, $value);
				}
			}
		}
		else
		{
			throw new Zend_Exception('Could not open the page to update!');
		}
	}
	
	public function deletePage($id)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();
		if ($row)
		{
			// first clear the cached entry for this page
			$cache = Zend_Registry::get('cache');
			$cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('cache_tag_content_' . $id));
			
			// then delete the page
			$id = $row->delete();
			return $id;
		}
		else
		{
			throw new Zend_Exception('Delete function failed; could not find the Page!');
		}
	}
	
	public function getRecentPages($count = 10, $namespace = 'page')
	{
		$select = $this->select();
		$select->order('date_created DESC');
		$select->where('namespace = ?', $namespace);
		$select->limit($count);
		$results = $this->fetchAll($select);
		
		if ($results->count() > 0)
		{
			// cycle through the results, opening each page
			$pages = array();
			foreach ($results as $result)
			{
				$pages[$result->id] = new Melobit_Content_Item_Page($result->id);
			}
			return $pages;
		}
		else
		{
			return null;
		}
	}
}



















