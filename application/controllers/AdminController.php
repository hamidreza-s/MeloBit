<?php
class AdminController extends Zend_Controller_Action
{
	protected $_adminConfigPath;
	
	public function init()
	{
		// retrieve path to admin config file
		$configResources = $this->getInvokeArg('bootstrap')->getOption('configs');
		$this->_adminConfigPath = $configResources['adminConfig'];
	}
	
	public function indexAction()
	{
		# code...
	}
	
	// action to save configuration data
	public function configAction()
	{
		// generate input form
		$form = new Form_ConfigForm();
		$this->view->form = $form;
		
		// if config file exists
		// read config values
		// pre-populate form with values
		if (file_exists($this->_adminConfigPath))
		{
			$config = new Zend_Config_Ini($this->_adminConfigPath);
			
			$data['adminEmailAddress'] = $config->global->adminEmailAddress;
			$data['contactEmailAddress'] = $config->contact->contactEmailAddress;
			$data['fromContactEmail'] = $config->contact->fromEmailAddress;
			$data['fromProtocol'] = $config->contact->fromProtocol;
			$data['fromPort'] = $config->contact->fromPort;
			$data['passwordSpecific'] = $config->contact->appSpecificPassword;
			$data['headTitle'] = $config->global->headTitle;
			$data['siteTitle'] = $config->global->siteTitle;
			$data['siteDescription'] = $config->global->siteDescription;
			$data['skins'] = $config->global->skin;

			$form->populate($data);
		}
		
		// if POST
		// test for valid input
		// if valid, create new config object
		// create config sections
		// save config values to file,
		// overwriting previous version
		if ($this->getRequest()->isPost())
		{
			if ($form->isValid($this->getRequest()->getPost()))
			{
				$values = $form->getValues();
				
				$config = new Zend_Config(array(), true);
				
				$config->global = array();
				$config->contact = array();
				
					$config->global->adminEmailAddress = $values['adminEmailAddress'];
					$config->contact->contactEmailAddress = $values['contactEmailAddress'];
					$config->contact->fromEmailAddress = $values['fromContactEmail'];
					$config->contact->fromProtocol = $values['fromProtocol'];
					$config->contact->fromPort = $values['fromPort'];
					$config->contact->appSpecificPassword = $values['passwordSpecific'];
					$config->global->headTitle = $values['headTitle'];
					$config->global->siteTitle = $values['siteTitle'];
					$config->global->siteDescription = $values['siteDescription'];
					$config->global->skin = $values['skins'];
				
				$writer = new Zend_Config_Writer_Ini();
				$writer->write($this->_adminConfigPath, $config);
				
				$this->_redirect('admin/index');  
			}
		}
	}
}
