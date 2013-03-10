<?php
class Sms_Model_ProvinceNameListModel extends Zend_Db_Table_Abstract
{
	protected $_name = 'province_name_list';
	

	public static function retrieveProvinceList()	
	{
		$provinceNameModel = new self();

		$select = $provinceNameModel->select();
		$result = $provinceNameModel->fetchAll($select)->toArray();
		
		return $result;
	}
}
