<?php
class Model_UserModel extends Zend_Db_Table_Abstract
{
	protected $_name = 'users';
	protected $_dependentTables	= array('Sms_Model_OrderModel');
	
	public function createUser($username, $password, $firstname, $lastname, $role)
	{
		$rowUser = $this->createRow();
		if ($rowUser)
		{
			$rowUser->username = $username;
			$rowUser->password = md5($password);
			$rowUser->first_name = $firstname;
			$rowUser->last_name = $lastname;
			$rowUser->role = $role;
			return $rowUser->save();
		}
		else
		{
			throw new Zend_Exception("Could not create user!");
		}
	}
	
	public static function getUsers($id = null)
	{
		if (is_null($id))
		{
			$userModel = new self();
			$select = $userModel->select();
			$select->order(array('last_name', 'first_name'));
			return $userModel->fetchAll($select);
		}
		else
		{
			$userModel = new self();
			return $userModel->find($id)->current();
		}
	}
	
	public function updateUser($id, $username, $firstname, $lastname, $role)
	{
		$rowUser = $this->find($id)->current();
		if ($rowUser)
		{
			$rowUser->username = $username;
			$rowUser->first_name = $firstname;
			$rowUser->last_name = $lastname;
			$rowUser->role = $role;
			return $rowUser->save();
		}
		else
		{
			throw new Zend_Exception("User update failed. User not found!");
		}
	}
	
	public function updatePassword($id, $password)
	{
		$rowUser = $this->find($id)->current();
		if ($rowUser)
		{
			$rowUser->password = md5($password);
			return $rowUser->save();
		}
		else
		{
			throw new Zend_Exception("Password update failed. User not found!");
		}
	}
	
	public function deleteUser($id)
	{
		$rowUser = $this->find($id)->current();
		if ($rowUser)
		{
			$rowUser->delete();
		}
		else
		{
			throw new Zend_Exception("Could not delete user. User not found!");
		}
	}
}


























