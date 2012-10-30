<?php
abstract class Melobit_Content_Item_Abstract
{
	public $id;
	public $name;
	public $parent_id = 0;
	protected $_namespace = 'page';
	protected $_pageModel;
	const NO_SETTER = 'setter method does not exist';
	
	public function __construct($pageRow = null)
	{
		$this->_pageModel = new Model_PageModel();
		if (null != $pageRow)
		{
			$this->loadPageObject($pageRow);
		}
	}
	
	protected function _getInnerRow($id = null)
	{
		if ($id == null)
		{
			$id = $this->id;
		}
		
		return $this->_pageModel->find($id)->current();
	}
	
	protected function _getProperties()
	{
		$propertyArray = array();
		$class = new Zend_Reflection_Class($this);
		$properties = $class->getProperties();
		foreach ($properties as $property)
		{
			if ($property->isPublic())
			{
				$propertyArray[] = $property->getName();
			}
		}
		
		return $propertyArray;
	}
	
	// checks if _setExamplePropertyName method exists
	// if yes, use it to assign DB's node value to Class's node
	protected function _callSetterMethod($property, $data)
	{
		// create the method name (example: short_description => ShortDescription)
		$method = Zend_Filter::filterStatic($property, 'Word_UnderscoreToCamelCase');
		$methodName = '_set' . $method;
		if (method_exists($this, $methodName))
		{
			return $this->methodName($data);
		}
		else
		{
			return self::NO_SETTER;
		}
	}
	
	public function loadPageObject($rowPage)
	{
		// if passed parameter is an istance of Zend_Db_Table_Row
		// then it doesn't neet to query again in database
		// to save system resources ;)
		if (is_object($rowPage) && get_class($rowPage) == 'Zend_Db_Table_Row')
		{
			$row = $rowPage;
			$this->id = $row->id;
		}
		else
		{
			$this->id = intval($rowPage);
			$row = $this->_getInnerRow(); 
		}

		// if row exist 
		if ($row)
		{
			if ($row->namespace != $this->_namespace)
			{
				throw new Zend_Exception('Unable to cast page type: ' .
					$row->namespace . ' to type: ' . $this->_namespace);
			}
			
			// load page properties
			$this->name = $row->name;
			$this->parend_id =  $row->parent_id;
			
			// load page's nodes properties from DB
			$contentNode = new Model_NodeModel();
			$nodes = $row->findDependentRowset($contentNode);
			if ($nodes)
			{ 
				// get class properties			
				$properties = $this->_getProperties(); 
				
				// assign each DB's node to Class's node
				foreach ($nodes as $node)
				{
				
					// 1, $key is node name
					$key = $node['node'];
					
					// it check if there is this DB's node in Class's node
					if (in_array($key, $properties))
					{
						// try to call the setter method
						$value = $this->_callSetterMethod($key, $nodes);
						
						// if no child setter method exists; do it here
						if ($value === self::NO_SETTER)
						{
							// 2, $value is node content
							$value = $node['content'];
						}
						$this->$key = $value;
					}
				}
			}
			
		}
		else
		{
			return null;
		}
	}
	
	public function toArray()
	{
		$properties = $this->_getProperties();
		foreach ($properties as $property)
		{
			$array[$property] = $this->$property;
		}
		
		return $array;
	}
	
	public function save()
	{
		if (isset($this->id))
		{
			$this->_update();
		}
		else
		{
			$this->_insert();
		}
		
		return true;
	}
	
	protected function _insert()
	{
		$pageId = $this->_pageModel->createPage($this->name, $this->_namespace, $this->parent_id);
		$this->id = $pageId;
		$this->_update();
	}
	
	protected function _update()
	{
		$data = $this->toArray();
		$this->_pageModel->updatePage($this->id, $data);
	}
	
	public function delete()
	{
		if (isset($this->id))
		{
			$this->_pageModel->deletePage($this->id);
		}
		else
		{
			throw new Zend_Exception('Unable to delete item; the item is empty!');
		}
	}
}




















