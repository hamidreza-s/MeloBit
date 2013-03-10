<?php
class Sms_Model_ProvinceCodeAllModel extends Zend_Db_Table_Abstract
{
	protected $_name = 'province_code_all_filtered';
	

	public static function countByProvince($pattern = null)	
	{
		$provinceModel = new self();
		
		if (is_null($pattern))
		{
			$select = $provinceModel->select()
				->from($provinceModel, 'count(*)');
			$result = $provinceModel->fetchAll($select)->toArray();
		
			return $result[0]['count(*)'];	
		}
		else
		{
			$select = $provinceModel->select()
				->from($provinceModel, 'count(*)')
				->where("province_code LIKE ? ", $pattern . '%');
			$result = $provinceModel->fetchAll($select)->toArray();
			
			return $result[0]['count(*)'];
		}
	}
	
	public static function retrieveProvince($pattern, $until, $start)	
	{
		$provinceModel = new self();
		
		$select = $provinceModel->select()
			->from($provinceModel, 'phone_no')
			->where("province_code LIKE ? ", $pattern . '%')
			->limit($until, $start);
		$result = $postalModel->fetchAll($select);
		
		return $result;
	}
}









