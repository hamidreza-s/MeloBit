<?php

class Melobit_Controller_Plugin_Language extends Zend_Controller_Plugin_Abstract
{
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        $lang = $request->getParam('lang', 'fa_IR');
		$registry = Zend_Registry::getInstance();
		$registry->set('Zend_Locale', $lang);
 				
        $translate = Zend_Registry::get('Zend_Translate'); 
		$translate->setLocale($lang);
        	
		/*
		Note: because of language folders with language_LOCALE
		we have to set default language to en_US which is compatible
		
			  try 
			  {
				$translate->setLocale('browser');
			  } 
			  catch (Zend_Locale_Exception $e) 
			  {
				$translate->setLocale('en_US');               
			  } 
			  */           
 
        // Set language to global param so that our language route can
        // fetch it nicely.
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();
        $router->setGlobalParam('lang', $lang);
		
		// get view from bootstrap
		$bootstrap = $front->getParam('Bootstrap');
		$view = $bootstrap->getResource('view');
		
		// load language specific configuration from config.lang.ini
		$langConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/lang/config.' . $lang . '.ini');
		$headTitle = $langConfig->global->headTitle;
		$siteTitle = $langConfig->global->siteTitle;
		$siteDescription = $langConfig->global->siteDescription;
		
		// Set HTML properties
		$view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
		$view->setEncoding('UTF-8');
		$view->doctype('XHTML1_STRICT');
		$view->headTitle($headTitle)->setSeparator(' - ');
		$view->siteTitle = $siteTitle;
		$view->siteDescription = $siteDescription;				
    }
}

