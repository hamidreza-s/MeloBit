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
		
		// add resources "module>controller"
		$acl->addResource(new Zend_Acl_Resource('default>index'));
		$acl->addResource(new Zend_Acl_Resource('default>error'));
		$acl->addResource(new Zend_Acl_Resource('default>page'));
		$acl->addResource(new Zend_Acl_Resource('default>menu'));
		$acl->addResource(new Zend_Acl_Resource('default>menu-item'));
		$acl->addResource(new Zend_Acl_Resource('default>user'));
		$acl->addResource(new Zend_Acl_Resource('default>search'));
		$acl->addResource(new Zend_Acl_Resource('default>bug'));
		$acl->addResource(new Zend_Acl_Resource('default>feed'));
		$acl->addResource(new Zend_Acl_Resource('default>upload'));
		$acl->addResource(new Zend_Acl_Resource('default>locale'));
		$acl->addResource(new Zend_Acl_Resource('default>admin'));
		$acl->addResource(new Zend_Acl_Resource('default>installer'));
		$acl->addResource(new Zend_Acl_Resource('contact>index'));
		$acl->addResource(new Zend_Acl_Resource('sms>index'));
		$acl->addResource(new Zend_Acl_Resource('sms>admin'));		
		$acl->addResource(new Zend_Acl_Resource('sms>company'));		
		$acl->addResource(new Zend_Acl_Resource('sms>customer'));		
		$acl->addResource(new Zend_Acl_Resource('sms>order'));
		
		// set up the access rules
		// note: $acl->allow(WHO, WHICH CONTROLLER, WHICH ACTIONS)
		// note: NULL means ALL
		$acl->allow(null, array('default>index', 'default>error', 'default>locale', 'default>installer'));
		$acl->allow(null, 'default>bug', array('create'));
		
		// a guest can only read content and login
		$acl->allow('guest', 'default>page', array('index', 'open'));
		$acl->allow('guest', 'default>menu', array('render'));
		$acl->allow('guest', 'default>user', array('login'));
		$acl->allow('guest', 'default>search', array('index'));
		$acl->allow('guest', 'default>feed');
		$acl->allow('guest', 'contact>index', array('index'));
		$acl->allow('guest', 'sms>index', array('index'));
		$acl->allow('guest', 'sms>order', array('index'));
		
		// MeloBit user can also work with content
		$acl->allow('user', 'default>page', array('list', 'create', 'edit', 'delete'));
		$acl->allow('user', 'default>user', array('logout'));
		$acl->allow('user', 'default>bug', array('index', 'create', 'success'));
		
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
		
		// fetch request module, action and controller
		$module = $request->getModuleName() ;
		$controller = $request->controller;
		$action = $request->action;
		$resource = "{$module}>{$controller}";
		
		// check if userController and loginAction are NOT requested
		// we store session to user in redirection in userController loginAction
		if ($controller !== 'user' && $action !== 'login')
		{
			// store requested uri in session
			$session = new Zend_Session_Namespace('Melobit.auth');
			$session->requestUri = $this->getRequest()->getRequestUri();
		}
		
		
		if (!$acl->isAllowed($role, $resource, $action))
		{
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


