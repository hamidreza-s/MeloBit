<?php
class Sms_Model_ProvinceCityNameListModel extends Zend_Db_Table_Abstract
{
	protected $_name = 'province_city_name_list';
	

	public static function retrieveProvinceCityList($requestedRange, $requestedProvince)	
	{
		$provinceCityNameModel = new self();
		
		$select = $provinceCityNameModel->select()
			->where('city_code LIKE ?', $requestedRange . $requestedProvince . '%');
		$result = $provinceCityNameModel->fetchAll($select)->toArray();
		
		return $result;
	}
}
