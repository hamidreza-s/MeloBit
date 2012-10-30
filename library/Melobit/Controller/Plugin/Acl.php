<?php
class Melobit_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		// setup Acl
		$acl = new Zend_Acl();
		
		// add roles
		$acl->addRole(new Zend_Acl_Role('guest'));
		$acl->addRole(new Zend_Acl_Role('user'), 'guest');
		$acl->addRole(new Zend_Acl_Role('administrator', 'user'));
		
		// add resources
		$acl->add(new Zend_Acl_Resource('index'));
		$acl->add(new Zend_Acl_Resource('error'));
		$acl->add(new Zend_Acl_Resource('page'));
		$acl->add(new Zend_Acl_Resource('menu'));
		$acl->add(new Zend_Acl_Resource('menu-item'));
		$acl->add(new Zend_Acl_Resource('user'));
		$acl->add(new Zend_Acl_Resource('search'));
		$acl->add(new Zend_Acl_Resource('bug'));
		$acl->add(new Zend_Acl_Resource('feed'));
		$acl->add(new Zend_Acl_Resource('upload'));
		$acl->add(new Zend_Acl_Resource('locale'));
		$acl->add(new Zend_Acl_Resource('admin'));
		$acl->add(new Zend_Acl_Resource('installer'));
		
		// set up the access rules
		// note: $acl->allow(WHO, WHICH CONTROLLER, WHICH ACTIONS)
		// note: NULL means ALL
		$acl->allow(null, array('index', 'error', 'locale', 'installer'));
		$acl->allow(null, 'bug', array('create'));
		
		// a guest can only read content and login
		$acl->allow('guest', 'page', array('index', 'open'));
		$acl->allow('guest', 'menu', array('render'));
		$acl->allow('guest', 'user', array('login'));
		$acl->allow('guest', 'search', array('index'));
		$acl->allow('guest', 'feed');
		
		// MeloBit user can also work with content
		$acl->allow('user', 'page', array('list', 'create', 'edit', 'delete'));
		$acl->allow('user', 'user', array('logout'));
		$acl->allow('user', 'bug', array('index', 'create', 'success'));
		
		// admin can do anything
		$acl->allow('administrator', null);
		
		// fetch the current user
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity())
		{
			$identity = $auth->getIdentity();
			$role = strtolower($identity->role);
		}
		else
		{
			$role = 'guest';
		}

		$controller = $request->controller;
		$action = $request->action;



		if (!$acl->isAllowed($role, $controller, $action))
		{
			// store requested uri in session
			$session = new Zend_Session_Namespace('Melobit.auth');
			$session->requestUri = $this->getRequest()->getRequestUri();

			if ($role == 'guest')
			{
				$request->setControllerName('user');
				$request->setActionName('login');
			}
			else
			{
				$request->setControllerName('error');
				$request->setActionName('noauth');
			}
		}
	}
}



























