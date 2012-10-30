<?php
class Model_BugModel extends Zend_Db_Table_Abstract
{
	// define table name
	protected $_name = 'bugs';
	
	public function createBug($name, $email, $date, $url, $description, $priority, $status)
	{
		// create a new row in the bugs table
		$row = $this->createRow();
		
		// set the row data
		$row->author		=	$name;
		$row->email			=	$email;
		$dateObject 		= 	new Zend_Date($date);
		$row->date			=	$dateObject->get(Zend_Date::TIMESTAMP);
		$row->url			=	$url;
		$row->description	=	$description;
		$row->priority		=	$priority;
		$row->status		=	$status;
		
		// save the new row
		// and fetch the id of last inserted row
		$id = $row->save();

        // return the id
        return $id;
	}
	
	public function fetchPaginatorAdapter($filters = array(), $sortField = null)
	{
		$select = $this->select();
		
		// add any filters which are set
		if (count($filters) > 0)
		{
			foreach ($filters as $field => $filter)
			{
				$select->where($field . ' = ?', $filter);
			}
		}
		
		// add the sort field if it is set
		if (null != $sortField)
		{
			$select->order($sortField);
		}
		
		// create a paginator adapter and return it
		$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
		return $adapter;
	}
	
	public function updateBug($id, $name, $email, $date, $url, $description, $priority, $status)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();
		
		if ($row)
		{
			// set the row data
			$row->author		= $name;
			$row->email			= $email;
			$dateObject 		= new Zend_Date($date);
			$row->date			= $dateObject->get(Zend_Date::TIMESTAMP);
			$row->url			= $url;
			$row->description	= $description;
			$row->priority		= $priority;
			$row->status		= $status;
			
			// save the updated row
			$id = $row->save();
			return $id;
		}
		else
		{
			throw new Zend_Exception("Update function failed; could not find row!");
		}
	}
	
	public function deleteBug($id)
	{
		// find the row that matches the id
		$row = $this->find($id)->current();
		
		if ($row)
		{
			$id = $row->delete();
			return $id;
		}
		else
		{
			throw new Zend_Exception("Delete function failed; could not find row!");
		}
	}
}



















