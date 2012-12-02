<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	public $uri;
	public $lang;
	
	protected function _initGetUri()
	{
			// retrieve uri and store in $this->uri
		  $this->uri = ltrim($_SERVER["REQUEST_URI"], '/');
		  
		  // retrive lang and store in $this->lang
		  if($this->uri)
			{
		  	$this->lang = substr($this->uri, 0, 5);
			}
			// if not set, en_US is default
			else
			{
				$this->lang = 'en_US';
			}
	}
	
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
		$skin = $adminConfig->global->skin;
		
		// load language specific configuration from config.lang.ini
		$langConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/lang/config.' . $this->lang . '.ini');
		$headTitle = $langConfig->global->headTitle;
		$siteTitle = $langConfig->global->siteTitle;
		$siteDescription = $langConfig->global->siteDescription;

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

  protected function _initTranslate()
  {                         
    $translate = new Zend_Translate('csv', APPLICATION_PATH . '/lang/', 
      null, array('scan' => Zend_Translate::LOCALE_FILENAME, 'disableNotices' => 1));
    $registry = Zend_Registry::getInstance();
    $registry->set('Zend_Translate', $translate);
  }
  
	public function _initRoutes()
		  {
		      $this->bootstrap('FrontController');
		      $this->_frontController = $this->getResource('FrontController');
		      $router = $this->_frontController->getRouter();
		   		
		   		// note: default language is set here. now is en_US
		      $langRoute = new Zend_Controller_Router_Route(
		          ':lang/',
		          array(
		              'lang' => 'en_US',
		          )
		      );
					$moduleRoute = new Zend_Controller_Router_Route(
						':module/:controller/:action/*',
						array(
							'module'=>':module',
							'controller'=>'index',
							'action'=>'index'
						)
					);
			    $moduleRoute = $langRoute->chain($moduleRoute);
			    $router->addRoute('langRoute', $langRoute);
			    $router->addRoute('moduleRoute', $moduleRoute);
					$router->addRoute('pages',
							new Zend_Controller_Router_Route(':lang/pages/:id/:title',
										                           array('controller' => 'page',
										                                 'action' => 'open',
										                                 'title' => null))
					);
		  }

			protected function _initLanguage()
			{
			  $front = Zend_Controller_Front::getInstance();
			  $langPlugin = new Melobit_Controller_Plugin_Language();
			  $front->registerPlugin($langPlugin);
			}
			
			protected function _initSearch()
			{
				// set default encoding to bootstrap utf-8 languages (e.g. persian)
				Zend_Search_Lucene_Search_QueryParser::setDefaultEncoding('utf-8');
				Zend_Search_Lucene_Analysis_Analyzer::setDefault(
		  		new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive ()
				);
			}
			
			protected function _initTimeZone()
			{
				// if php.ini doesn't set time zone
				// we set it to UTC (Coordinated Universal Time)
				if (!ini_get('date.timezone')) 
				{
						date_default_timezone_set('UTC'); 
				}
			}

}























