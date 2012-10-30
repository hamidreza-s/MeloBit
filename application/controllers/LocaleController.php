<?php
class LocaleController extends Zend_Controller_Action
{
  // action to manually override locale
  public function indexAction()
  { 
    // if supported locale, add to session
    if (Zend_Validate::is(
    	$this->getRequest()->getParam('locale'), 
    	'InArray', array('haystack' => array('en_US', 'en_GB', 'de_DE', 'fr_FR', 'fa_IR')))) 
    {
      $session = new Zend_Session_Namespace('Melobit.l10n');
      $session->locale = $this->getRequest()->getParam('locale');    
    } 
        
    // redirect to requesting URL
    $url = $this->getRequest()->getServer('HTTP_REFERER');
    $this->_redirect($url);      
  }
}
