<?php
class Sms_Model_PostalCodeAllModel extends Zend_Db_Table_Abstract
{
	protected $_name = 'postal_code_all_filtered';
	

	public static function countPostal($pattern = null)	
	{
		$postalModel = new self();
		
		if (is_null($pattern))
		{
			$select = $postalModel->select()
				->from($postalModel, 'count(*)');
			$result = $postalModel->fetchAll($select)->toArray();
		
			return $result[0]['count(*)'];	
		}
		else
		{
			$select = $postalModel->select()
				->from($postalModel, 'count(*)')
				->where("postal_code LIKE ? ", $pattern . '%');
			$result = $postalModel->fetchAll($select)->toArray();
			
			return $result[0]['count(*)'];
		}
	}
	
	public static function retrievePostal($pattern, $until, $start)	
	{
		$postalModel = new self();

		$select = $postalModel->select()
			->from($postalModel, 'phone_no')
			->where("postal_code LIKE ? ", $pattern . '%')
			->limit($until, $start);
		$result = $postalModel->fetchAll($select);
		
		return $result;

	}
}
