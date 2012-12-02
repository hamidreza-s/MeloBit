<?php
class AdminController extends Zend_Controller_Action
{
	protected $_adminConfigPath;
	protected $_langConfigPath;
	protected $_lang;
	
	public function init()
	{
		// retrieve path to admin config file
		$configResources = $this->getInvokeArg('bootstrap')->getOption('configs');
		$this->_adminConfigPath = $configResources['adminConfig'];
		
		// retrieve path to lang config file
		$registry = Zend_Registry::getInstance();
		$this->_lang = $registry->get('Zend_Locale');
		$this->_langConfigPath = APPLICATION_PATH . '/configs/lang/config.' . $this->_lang . '.ini';
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
			// admin config
			$config = new Zend_Config_Ini($this->_adminConfigPath);		
			$data['adminEmailAddress'] = $config->global->adminEmailAddress;
			$data['contactEmailAddress'] = $config->contact->contactEmailAddress;
			$data['fromContactEmail'] = $config->contact->fromEmailAddress;
			$data['fromProtocol'] = $config->contact->fromProtocol;
			$data['fromPort'] = $config->contact->fromPort;
			$data['passwordSpecific'] = $config->contact->appSpecificPassword;
			$data['skins'] = $config->global->skin;

			// language config
			$langConfig = new Zend_Config_Ini($this->_langConfigPath);
			$data['headTitle'] = $langConfig->global->headTitle;
			$data['siteTitle'] = $langConfig->global->siteTitle;
			$data['siteDescription'] = $langConfig->global->siteDescription;
			
			// populate admin and language configs
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
				
				// write admin config
				$config = new Zend_Config(array(), true);				
				$config->global = array();
				$config->contact = array();				
					$config->global->adminEmailAddress = $values['adminEmailAddress'];
					$config->contact->contactEmailAddress = $values['contactEmailAddress'];
					$config->contact->fromEmailAddress = $values['fromContactEmail'];
					$config->contact->fromProtocol = $values['fromProtocol'];
					$config->contact->fromPort = $values['fromPort'];
					$config->contact->appSpecificPassword = $values['passwordSpecific'];
					$config->global->skin = $values['skins'];			
				$writer = new Zend_Config_Writer_Ini();
				$writer->write($this->_adminConfigPath, $config);
	
				// write lang config
				$langConfig = new Zend_Config(array(), true);				
				$langConfig->global = array();		
					$langConfig->global->headTitle = $values['headTitle'];
					$langConfig->global->siteTitle = $values['siteTitle'];
					$langConfig->global->siteDescription = $values['siteDescription'];	
				$writer = new Zend_Config_Writer_Ini();
				$writer->write($this->_langConfigPath, $langConfig);
				
				// redirect to admin controller, index action			
				$this->_redirect($this->_lang . '/default/admin/index');  
			}
		}
	}
}
