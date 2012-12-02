<?php

class Melobit_Controller_Plugin_Language extends Zend_Controller_Plugin_Abstract
{
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {	
        $lang = $request->getParam('lang', null);
 				$registry = Zend_Registry::getInstance();
 				$registry->set('Zend_Locale', $lang);
 				
        $translate = Zend_Registry::get('Zend_Translate'); 
        if ($translate->isAvailable($lang)) 
        {
            $translate->setLocale($lang);
        } 
        else 
        {
        	$translate->setLocale('en_US');
        	
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
            
        }
 
        // Set language to global param so that our language route can
        // fetch it nicely.
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();
        $router->setGlobalParam('lang', $lang);
    }
}

