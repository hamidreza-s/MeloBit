<?php
class Sms_Model_CompanyModel extends Zend_Db_Table_Abstract
{
	protected $_name = 'companies';
	protected $_dependentTables	= array('Sms_Model_CustomerModel');
	
	public function createCompany($name, $field, $contact_number_1, $contact_number_2, $address)
	{
		$rowCompany = $this->createRow();
		if ($rowCompany)
		{
			$rowCompany->name = $name;
			$rowCompany->field = $field;
			$rowCompany->contact_number_1 = $contact_number_1;
			$rowCompany->contact_number_2 = $contact_number_2;
			$rowCompany->address = $address;
			return $rowCompany->save();
		}
		else
		{
			throw new Zend_Exception("Could not create new company!");
		}
	}
	
	public static function retrieveCompany($id = null)
	{
		$companyModel = new self();
		$select = $companyModel->select();
		
		if (is_null($id))
		{
			return $companyModel->fetchAll($select);
		}
		else
		{
			return $companyModel->find($id)->current();
		}
	}
	
	public function updateCompany($id, $name, $field, $contact_number_1, $contact_number_2, $address)
	{
		$rowCompany = $this->find($id)->current();
		if ($rowCompany)
		{
			$rowCompany->name = $name;
			$rowCompany->field = $field;
			$rowCompany->contact_number_1 = $contact_number_1;
			$rowCompany->contact_number_2 = $contact_number_2;
			$rowCompany->address = $address;
			return $rowCompany->save();		
		}
		else
		{
			throw new Zend_Exception("Could not update the company!");
		}
	}
	
	public function deleteCompany($id)
	{
		$rowCompany = $this->find($id)->current();
		if ($rowCompany)
		{
			return $rowCompany->delete();
		}
		else
		{
			throw new Zend_Exception("Could not delete the compnay!");
		}
	}
	
	public static function listCompany($id = null)
	{
		$companyModel = new self();
		$select = $companyModel->select(array('id', 'name'));   

		if (is_null($id))
		{
			return $companyModel->fetchAll($select);
		}
		else
		{
			return $companyModel->find($id)->current();
		}

	}
}
