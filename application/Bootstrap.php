<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initDb()
	{
		try
		{
			// get database config file
			$dbConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/database.ini');
			
			// factory Zend Db Adapter
			$dbAdapter = Zend_Db::factory($dbConfig->db->adapter, $dbConfig->db->params->toArray());
			
			// set Zend default adapter
			Zend_Db_Table_Abstract::setDefaultAdapter($dbAdapter);		
		}
		catch (Exception $e)
		{
			// your database file was not found
			die("MeloBit Database file was not found in application/config folder!");
		}
		
	}
    
	protected function _initView()
	{
		// load configuration from adminConfig.ini
		$configResource = $this->getOption('configs'); 
		$adminConfig = new Zend_Config_Ini($configResource['adminConfig']);	
		$headTitle = $adminConfig->global->headTitle;
		$siteTitle = $adminConfig->global->siteTitle;
		$siteDescription = $adminConfig->global->siteDescription;
		$skin = $adminConfig->global->skin;

		// Initialize view
		$view = new Zend_View();
		
		/*
		// Set Dojo
		// add helper path to view
		Zend_Dojo::enableView($view);
		// configure Dojo view helper, disable
		$view->dojo()->setLocalPath('/javascripts/dojo-release-1.8.1/dojo/dojo.js')
			->addStyleSheetModule('dijit.themes.tundra')
			->disable();
		*/
		
		// Set HTML properties
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
        $view->setEncoding('UTF-8');
        $view->doctype('XHTML1_STRICT');
		$view->headTitle($headTitle)->setSeparator(' - ');
		$view->siteTitle = $siteTitle;
		$view->siteDescription = $siteDescription;
		$view->skin = $skin;


		
		// Add it to the ViewRenderer
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
			'ViewRenderer'
		);
		$viewRenderer->setView($view);
		
		// Return it, so that it can be stored by the bootstarp
		return $view;
	}
	
	protected function _initAutoload()
	{
		// Add autoloader empty namespace
		$autoLoader = Zend_Loader_Autoloader::getInstance();
		$autoLoader->registerNamespace('Melobit_');
		$resourceLoader = new Zend_Loader_Autoloader_Resource(array(
			'basePath'		=>	APPLICATION_PATH,
			'namespace'		=>	'',
			'resourceTypes'	=>	array(
				'form'	=>	array(
					'path'		=>	'forms/',
					'namespace'	=>	'Form_',
				),
				'model' => array(
					'path'		=>	'models/',
					'namespace'	=>	'Model_',
				)
			),
		));
		
		// Return it so that it can be stored by the bootstrap
		return $autoLoader;
	}

  protected function _initLocale()
  {               
    $session = new Zend_Session_Namespace('Melobit.l10n');
    if ($session->locale) 
    {
      $locale = new Zend_Locale($session->locale);                 
    } 
    else
    {
      try 
      {
        $locale = new Zend_Locale('browser'); 
      } 
      catch (Zend_Locale_Exception $e) 
      {
        $locale = new Zend_Locale('en_US');               
      } 
    }

    $registry = Zend_Registry::getInstance();
    $registry->set('Zend_Locale', $locale); 
  }


  protected function _initTranslate()
  {                         
    $translate = new Zend_Translate('csv', APPLICATION_PATH . '/lang/', 
      null, array('scan' => Zend_Translate::LOCALE_FILENAME, 'disableNotices' => 1));
    $registry = Zend_Registry::getInstance();
    $registry->set('Zend_Translate', $translate);
  }
}























