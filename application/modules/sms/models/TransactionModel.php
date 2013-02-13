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
	
	public function createTransaction($order_id, $receipt_number, $bank_account, $jalali_deposit_date, $depositor_name, $deposit_fee)
	{
		$rowTransaction = $this->createRow();
		if ($rowTransaction)
		{
			// Convert Jalali to Timestamp
			$timestamp_dispatch_date = Melobit_Date_Convertor::jalali_to_timestamp($jalali_deposit_date);
			
			$rowTransaction->order_id = $order_id;
			$rowTransaction->receipt_number = $receipt_number;
			$rowTransaction->bank_account = $bank_account;
			$rowTransaction->deposit_date = $timestamp_dispatch_date;
			$rowTransaction->depositor_name = $depositor_name;
			$rowTransaction->deposit_fee = $deposit_fee;
			return $rowTransaction->save();
		}
		else
		{
			throw new Zend_Exception("Could not create new transaction!");
		}
	}
	
	public static function retrieveTransactions($order_id)
	{
		$transactionModel = new self();
		$select = $transactionModel->select()
			->where("order_id = ?", $order_id);
			
		return $transactionModel->fetchAll($select);
	}
	
	public function updateTransaction($id, $order_id, $receipt_number, $bank_account, $jalali_deposit_date, $depositor_name, $deposit_fee) 
	{
		$rowTransaction = $this->find($id)->current();
		if ($rowTransaction)
		{
			// Convert Jalali to Timestamp
			$timestamp_dispatch_date = Melobit_Date_Convertor::jalali_to_timestamp($jalali_deposit_date);
			
			$rowTransaction->order_id = $order_id;
			$rowTransaction->receipt_number = $receipt_number;
			$rowTransaction->bank_account = $bank_account;
			$rowTransaction->deposit_date = $timestamp_dispatch_date;
			$rowTransaction->depositor_name = $depositor_name;
			$rowTransaction->deposit_fee = $deposit_fee;
			return $rowTransaction->save();
		}
		else
		{
			throw new Zend_Exception("Could not update the order transaction!");
		}
	
	}
	
	public function retrieveTransaction($transaction_id)
	{
		$transactionModel = new self();
		$select = $transactionModel->select()
			->where("id = ?", $transaction_id);

		return $transactionModel->fetchAll($select);	
	}
	
	public function deleteTransaction($id) 
	{
		$rowTransaction = $this->find($id)->current();
		if ($rowTransaction)
		{
			$returnValue = array(
				'order_id' => $rowTransaction->order_id,
				'transaction_id' => $rowTransaction->delete()
			);
			return $returnValue;
		}
		else
		{
			throw new Zend_Exception("Could not delete the order transaction!");
		}
	}
	
}
































