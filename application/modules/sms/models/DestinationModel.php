<?php
class Sms_Model_DestinationModel extends Zend_Db_Table_Abstract
{
	protected $_name = 'destinations';
	protected $_referenceMap = array(
		'Order'	=>	array(
			'columns'		=>	array('order_id'),
			'refTableClass'	=>	'Sms_Model_OrderModel',
			'refColumns'	=>	array('id'),
			'onDelete'		=>	self::RESTRICT,
			'onUpdate'		=>	self::RESTRICT
		)
	);
	
	public function createDestination($order_id, $destination_type, $destination_value, $dispatch_date, $destinations_quantity)	
	{
		$rowDestination = $this->createRow();
		if ($rowDestination)
		{
			// date object
			$dateObject = new Zend_Date($dispatch_date);

			$rowDestination->order_id = $order_id;
			$rowDestination->destination_type = $destination_type;
			$rowDestination->destination_value = $destination_value;
			$rowDestination->dispatch_date = $dateObject->get(Zend_Date::TIMESTAMP);
			$rowDestination->destinations_quantity 	 = $destinations_quantity 	;
			return $rowDestination->save();
		}
		else
		{
			throw new Zend_Exception("Could not create new destination!");
		}
	}
	
	public static function retrieveDestination($order_id)
	{
		$destinationModel = new self();
		$select = $destinationModel->select()
			->where("order_id = ?", $order_id);

		return $destinationModel->fetchAll($select);
	}
	
	public function updateDestination($id, $order_id, $destination_type, $destination_value, $dispatch_date, $destinations_quantity) 
	{
		$rowDestination = $this->find($id)->current();
		if ($rowDestination)
		{
			// date object
			$dateObject = new Zend_Date($dispatch_date);
			
			$rowDestination->order_id = $order_id;
			$rowDestination->destination_type = $destination_type;
			$rowDestination->destination_value = $destination_value;
			$rowDestination->dispatch_date = $dateObject->get(Zend_Date::TIMESTAMP);
			$rowDestination->destinations_quantity 	 = $destinations_quantity;
			return $rowDestination->save();
		}
		else
		{
			throw new Zend_Exception("Could not update the order!");
		}			
	}
	
	public function deleteDestination($id) 
	{
		$rowDestination = $this->find($id)->current();
		if ($rowDestination)
		{
			$returnValue = array(
				'order_id' => $rowDestination->order_id,
				'destination_id' => $rowDestination->delete()
			);
			return $returnValue;
		}
		else
		{
			throw new Zend_Exception("Could not delete the customer!");
		}			
	}
	
}
