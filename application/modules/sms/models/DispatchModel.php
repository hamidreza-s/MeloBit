<?php
class Sms_Model_DispatchModel extends Zend_Db_Table_Abstract
{
	protected $_name = 'orders';
	protected $_dependentTables	= array(
		'Sms_Model_DestinationModel',
		'Sms_Model_TransactionModel'
	);
	protected $_referenceMap = array(
		'Users'	=>	array(
			'columns'		=>	array('user_id'),
			'refTableClass'	=>	'Model_UserModel',
			'refColumns'	=>	array('id'),
			'onDelete'		=>	self::CASCADE,
			'onUpdate'		=>	self::RESTRICT
		)
	);

	public static function retrieveOrder($id = null)
	{
		$dispatchModel = new self();
		
		if (is_null($id))
		{
			$select = $dispatchModel->select()
				->where('control_status = ?', 1);;
			return $dispatchModel->fetchAll($select);
		}
		else
		{
			return $dispatchModel->find($id)->current();
		}
	}
	
	public static function retrieveOrderByUserId($id)
	{
		$dispatchModel = new self();
		$select = $dispatchModel->select()
			->where('user_id = ?', $id);
		return $dispatchModel->fetchAll($select);
	}
		
	public function confirmOrder($id) 
	{
		$rowOrder = $this->find($id)->current();
		if ($rowOrder)
		{
			$rowOrder->dispatch_status = 1;
			return $rowOrder->save();
		}
		else
		{
			throw new Zend_Exception("Could not update the order!");
		}		
	}
	
	public function suspendOrder($id)	
	{
		$rowOrder = $this->find($id)->current();
		if ($rowOrder)
		{
			$rowOrder->dispatch_status = 0;
			return $rowOrder->save();
		}
		else
		{
			throw new Zend_Exception("Could not update the order!");
		}			
	}
	
}
