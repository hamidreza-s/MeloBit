<?php
class Sms_Model_TransactionModel extends Zend_Db_Table_Abstract
{
	protected $_name = 'transactions';
	protected $_referenceMap = array(
		'Order'	=>	array(
			'columns'		=>	array('order_id'),
			'refTableClass'	=>	'Sms_Model_OrderModel',
			'refColumns'	=>	array('id'),
			'onDelete'		=>	self::CASCADE,
			'onUpdate'		=>	self::RESTRICT
		)
	);
	
	public function createTransaction()	{}
	
	public function updateTransaction() {}
	
	public function deleteTransaction() {}
	
}
