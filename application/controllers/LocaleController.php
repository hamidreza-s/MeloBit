<?php
class LocaleController extends Zend_Controller_Action
{
  // action to manually override locale
  public function indexAction()
  { 
  	$lang = $this->getRequest()->getParam('lang');

    // if supported locale, add to session
    if (Zend_Validate::is($lang, 
    	'InArray', array('haystack' => array(ar_SA, eu_ES, bg_BG, ca_AD, ca_ES, zh_CN, zh_TW, hr_HR, cs_CZ, nl_NL, nl_BE, en_US, en_GB, et_EE, fi_FI, fr_FR, gl_ES, de_DE, el_GR, iw_IL, hi_IN, hu_HU, in_ID, it_IT, ja_JP, ko_KR, nb_NO, fa_IR, pl_PL, pt_BR, pt_PT, ro_RO, ru_RU, sr_RS, sr_RS_latin, sl_SI, sk_SK, es_ES, sv_SE, tr_TR, uk_UA, vi_VN)))) 
    {
		  // redirect to requesting URL
			$previousUrl = parse_url($this->getRequest()->getServer('HTTP_REFERER'));
			$path = $previousUrl['path'];
			$newPath = substr_replace($path, $lang, 1, 5);
		  $this->_redirect($newPath); 
    }

    
    // disabble layout and view
    $this->_helper->layout->disableLayout();
  	$this->_helper->viewRenderer->setNoRender(TRUE); 
        
      
  }
}
