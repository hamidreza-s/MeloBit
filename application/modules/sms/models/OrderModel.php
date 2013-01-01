<?php
class Sms_Model_OrderModel extends Zend_Db_Table_Abstract
{
	protected $_name = 'orders';
	protected $_dependentTables	= array(
		'Sms_Model_DestinationModel',
		'Sms_Model_TransactionModel'
	);
	
	public function createOrder($customer_id, $sms_content, $test_phone)	
	{
		$rowOrder = $this->createRow();
		if ($rowOrder)
		{
			$date = new DateTime();

			$rowOrder->customer_id = $customer_id;
			$rowOrder->sms_content = $sms_content;
			$rowOrder->order_date = $date->getTimestamp();
			$rowOrder->test_phone = $test_phone;
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
		$select = $orderModel->select();
		
		if (is_null($id))
		{
			return $orderModel->fetchAll($select);
		}
		else
		{
			return $orderModel->find($id)->current();
		}
	}
	
	public function updateOrder($id, $customer_id, $sms_content, $test_phone) 
	{
		$rowOrder = $this->find($id)->current();
		if ($rowOrder)
		{
			$date = new DateTime();
			
			$rowOrder->customer_id = $customer_id;
			$rowOrder->sms_content = $sms_content;
			$rowOrder->order_date = $date->getTimestamp();
			$rowOrder->test_phone = $test_phone;
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
		if ($rowOrder)
		{
			return $rowOrder->delete();
		}
		else
		{
			throw new Zend_Exception("Could not delete the customer!");
		}	
	}
		
	public function confirmOrder() {}
	
}
