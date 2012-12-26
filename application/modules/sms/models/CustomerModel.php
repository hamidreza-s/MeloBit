<?php
class Sms_Model_CustomerModel extends Zend_Db_Table_Abstract
{
	protected $_name = 'customers';
	protected $_referenceMap = array(
		'Company'	=>	array(
			'columns'		=>	array('company_id'),
			'refTableClass'	=>	'Sms_Model_CompanyModel',
			'refColumns'	=>	array('id'),
			'onDelete'		=>	self::RESTRICT,
			'onUpdate'		=>	self::RESTRICT
		)
	);
	
	public function createCustomer($company_id, $first_name, $last_name, $contact_number_1, $contact_number_2, $address)
	{
		$rowCustomer = $this->createRow();
		if ($rowCustomer)
		{
			$rowCustomer->company_id = $company_id;
			$rowCustomer->first_name = $first_name;
			$rowCustomer->last_name = $last_name;
			$rowCustomer->contact_number_1 = $contact_number_1;
			$rowCustomer->contact_number_2 =$contact_number_2;
			$rowCustomer->address = $address;
			return $rowCustomer->save();
		}
		else
		{
			throw new Zend_Exception("Could not create new customer!");		
		}
	}
	
	public static function retrieveCustomer($id = null)
	{
		$customerModel = new self();
		$select = $customerModel->select();
		
		if (is_null($id))
		{
			return $customerModel->fetchAll($select);
		}
		else
		{
			return $customerModel->find($id)->current();
		}
	}
	
	public function updateCustomer($id, $company_id, $first_name, $last_name, $contact_number_1, $contact_number_2, $address)
	{
		$rowCustomer = $this->find($id)->current();
		if ($rowCustomer)
		{
			$rowCustomer->company_id = $company_id;
			$rowCustomer->first_name = $first_name;
			$rowCustomer->last_name = $last_name;
			$rowCustomer->contact_number_1 = $contact_number_1;
			$rowCustomer->contact_number_2 =$contact_number_2;
			$rowCustomer->address = $address;
			return $rowCustomer->save();
		}
		else
		{
			throw new Zend_Exception("Could not update the customer!");
		}
	}
	
	public function deleteCustomer($id)
	{
		$rowCustomer = $this->find($id)->current();
		if ($rowCustomer)
		{
			return $rowCustomer->delete();
		}
		else
		{
			throw new Zend_Exception("Could not delete the customer!");
		}
	}
	
	public static function listCustomer()
	{
	
	}
}
