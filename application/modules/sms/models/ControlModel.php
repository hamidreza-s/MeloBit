<?php
class Sms_Model_ControlModel extends Zend_Db_Table_Abstract
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
		$controlModel = new self();
		
		if (is_null($id))
		{
			$select = $controlModel->select()
				->where('order_status = ?', 1);
			return $controlModel->fetchAll($select);
		}
		else
		{
			return $controlModel->find($id)->current();
		}
	}
	
	public static function retrieveOrderByUserId($id)
	{
		$controlModel = new self();
		$select = $controlModel->select()
			->where('user_id = ?', $id);
		return $controlModel->fetchAll($select);
	}
		
	public function confirmOrder($id) 
	{
		$rowOrder = $this->find($id)->current();
		if ($rowOrder)
		{
			$rowOrder->control_status = 1;
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
		if ($rowOrder && $rowOrder->dispatch_status == 0)
		{
			$rowOrder->control_status = 0;
			return $rowOrder->save();
		}
		else
		{
			throw new Zend_Exception("Could not update the order!");
		}			
	}
	
}
