<?php
class Sms_Model_OrderModel extends Zend_Db_Table_Abstract
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
	
	public function createOrder($customer_id, $user_id, $sms_content, $sms_quantity, $test_phone, $sms_fee)	
	{
		$rowOrder = $this->createRow();
		if ($rowOrder)
		{
			$date = new DateTime();

			$rowOrder->customer_id = $customer_id;
			$rowOrder->user_id = $user_id;
			$rowOrder->sms_content = $sms_content;
			$rowOrder->sms_quantity = $sms_quantity;
			$rowOrder->order_date = $date->getTimestamp();
			$rowOrder->test_phone = $test_phone;
			$rowOrder->sms_fee = $sms_fee;
			return $rowOrder->save();
		}
		else
		{
			throw new Zend_Exception("Could not create new order!");
		}
	}

	public static function retrieveOrder($id = null)
	{
		$orderModel = new self();
		
		if (is_null($id))
		{
			$select = $orderModel->select();
			return $orderModel->fetchAll($select);
		}
		else
		{
			return $orderModel->find($id)->current();
		}
	}
	
	public static function retrieveOrderByUserId($id, $role = null)
	{
		$orderModel = new self();
		
		// If user is admin show all orders
		if (isset($role) && $role == 'administrator')
		{
			$select = $orderModel->select();
			return $orderModel->fetchAll($select);
		}
		// Otherwise show just current user's orders
		else
		{	
			$select = $orderModel->select()
				->where('user_id = ?', $id);
			return $orderModel->fetchAll($select);
		}
	}
	
	public static function retrieveOrderByUserIdAndPage($id, $role = null, $whichPage = 1, $rowPerPage = 5)
	{
		$orderModel = new self();
		
		// If user is admin show all orders
		if (isset($role) && $role == 'administrator')
		{
			$select = $orderModel->select();
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage($rowPerPage);
			$paginator->setCurrentPageNumber($whichPage);
			return $paginator;
		}
		// Otherwise show just current user's orders
		else
		{	
			$select = $orderModel->select()
				->where('user_id = ?', $id);
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage($rowPerPage);
			$paginator->setCurrentPageNumber($whichPage);
			return $paginator;
		}
	}
	
	public static function retrieveOrderStatusByOrderId($order_id)
	{
		$orderModel = new self();
		$select = $orderModel->select()->from($orderModel, array('order_status'))->where('id = ?', $order_id);
		$result = $orderModel->fetchRow($select)->toArray();
		return $result;
	}
	
	public function updateOrder($id, $customer_id, $sms_content, $sms_quantity, $test_phone, $sms_fee) 
	{
		$rowOrder = $this->find($id)->current();
		if ($rowOrder && $rowOrder->order_status != 1)
		{
			$date = new DateTime();
			
			$rowOrder->customer_id = $customer_id;
			$rowOrder->sms_content = $sms_content;
			$rowOrder->sms_quantity = $sms_quantity;
			$rowOrder->order_date = $date->getTimestamp();
			$rowOrder->test_phone = $test_phone;
			$rowOrder->sms_fee = $sms_fee;
			return $rowOrder->save();
		}
		else
		{
			throw new Zend_Exception("Could not update the order!");
		}		
	}
	
	public function deleteOrder($id) 
	{
		$rowOrder = $this->find($id)->current();
		if ($rowOrder && $rowOrder->order_status != 1)
		{
			return $rowOrder->delete();
		}
		else
		{
			throw new Zend_Exception("Could not delete the order!");
		}	
	}
		
	public function confirmOrder($id) 
	{
		$rowOrder = $this->find($id)->current();
		if ($rowOrder)
		{
			$rowOrder->order_status = 1;
			return $rowOrder->save();
		}
		else
		{
			throw new Zend_Exception("Could not confirm the order!");
		}		
	}
	
	public function suspendOrder($id)	
	{
		$rowOrder = $this->find($id)->current();
		if ($rowOrder && $rowOrder->control_status == 0 && $rowOrder->dispatch_status == 0)
		{
			$rowOrder->order_status = 0;
			return $rowOrder->save();
		}
		else
		{
			throw new Zend_Exception("Could not suspend the order!");
		}			
	}
	
}
