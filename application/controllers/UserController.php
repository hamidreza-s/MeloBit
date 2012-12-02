<?php
class UserController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity())
		{
			$this->view->identity = $auth->getIdentity();
		}
	}

	public function navAction()
	{
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity())
		{
			$this->view->identity = $auth->getIdentity();
		}
	}

	public function createAction()
	{
		$userForm = new Form_UserForm();
		if ($this->getRequest()->isPost())
		{
			if ($userForm->isValid($_POST))
			{
				$userModel = new Model_UserModel();
				$data = $userForm->getValues();
				$userModel->createUser(
					$data['username'], $data['password'], $data['first_name'], $data['last_name'], $data['role']
				);
				return $this->_forward('list');
			}
		}
		$this->view->form = $userForm;
	}
	
	public function listAction()
	{
		$currentUsers = Model_UserModel::getUsers();
		if ($currentUsers->count() > 0)
		{
			$this->view->users = $currentUsers;
		}
		else
		{
			$this->view->users = null;
		}
	}
	
	public function updateAction()
	{
		$userForm = new Form_UserForm();
		$userForm->removeElement('password');		

		
		if ($this->getRequest()->isPost())
		{
			if ($userForm->isValid($_POST))
			{
				$data = $userForm->getValues();
				$userModel = new Model_UserModel();
				$userModel->updateUser(
					$data['id'], $data['username'], $data['first_name'], $data['last_name'], $data['role']);
				return $this->_forward('list');
			}
		}		
		else
		{
			$userId = $this->_request->getParam('id');
			$userModel = new Model_UserModel();
			$currentUser = $userModel->find($userId)->current();
			$userForm->populate($currentUser->toArray());
		}	
		$this->view->form = $userForm;
	}
	
	public function passwordAction()
	{
		$passwordForm = new Form_UserForm();
		$passwordForm->removeElement('first_name');
		$passwordForm->removeElement('last_name');
		$passwordForm->removeElement('username');
		$passwordForm->removeElement('role');
		$userModel = new Model_UserModel();
		if ($this->getRequest()->isPost())
		{
			if ($passwordForm->isValid($_POST))
			{
				$userModel->updatePassword(
					$passwordForm->getValue('id'),
					$passwordForm->getValue('password')
				);
				return $this->_forward('list');
			}
		}
		else
		{
			$id = $this->_request->getParam('id');
			$currentUser = $userModel->find($id)->current();
			$passwordForm->populate($currentUser->toArray());
		}
		$this->view->form = $passwordForm;
	}
	
	public function deleteAction()
	{
		$userId = $this->_request->getParam('id');
		$userModel = new Model_UserModel();
		$userModel->deleteUser($userId);
		return $this->_forward('list');
	}
	
	public function loginAction()
	{
		$userForm = new Form_UserForm();
		$userForm->removeElement('first_name');
		$userForm->removeElement('last_name');
		$userForm->removeElement('role');
		if ($this->_request->isPost() && $userForm->isValid($_POST))
		{
			$data = $userForm->getValues();
			
			// set up the auth adapter
			// get the default db adapter
			$db = Zend_Db_Table::getDefaultAdapter();
			
			// create the auth adapter
			$authAdapter =  new Zend_Auth_Adapter_DbTable($db, 'users', 'username', 'password');
			
			// set the username and password
			$authAdapter->setIdentity($data['username']);
			$authAdapter->setCredential(md5($data['password']));
			
			// authenticate
			$result = $authAdapter->authenticate();
			if ($result->isValid())
			{
				// store the username, role, first and lastname of the user
				$auth = Zend_Auth::getInstance();
				$storage = $auth->getStorage();
				$storage->write($authAdapter->getResultRowObject(
					array('id', 'username', 'first_name', 'last_name', 'role')));
					
				// redirect to the requested page
				// note: session was set in Melobit_Controller_Plugin_Acl class
				$session = new Zend_Session_Namespace('Melobit.auth');
				$requestUri = $session->requestUri;
				unset($session->requestUri);	
				if (isset($requestUri))
				{
					return $this->_redirect($requestUri);
				}
				else
				{
					return $this->_forward('index');
				}
			}
			else
			{
				$this->view->loginMessage = "Sorry, your username or passwordd was incorrect";
			}
		}
		$this->view->form = $userForm;
	}
	
	public function logoutAction()
	{
		$authAdapter = Zend_Auth::getInstance();
		$authAdapter->clearIdentity();
	}
}





















