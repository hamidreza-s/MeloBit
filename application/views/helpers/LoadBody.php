<?php
/**
 * this class loads the layout skin
 *
 * to create a new skin, designer has to create layout files
 * accourding to /application/layouts/scripts files
 */
class Zend_View_Helper_LoadBody extends Zend_View_Helper_Abstract
{
		// this function calls in /application/layouts/scripts/layoutFile.phtml
    // then according to layout scripts, reads counterpart files in
    // /pubic/skins/skinName/layoutFile.phtml
    public function loadBody($skin, $whichFile, $whichLang)
    {
        // read layout files from skin folder
        // then render it
        $this->view->addScriptPath(APPLICATION_PATH . '/../public/skins/' . $skin . '/' . $whichLang . '/');
        echo $this->view->render('header.phtml');
				echo $this->view->render($whichFile);
				echo $this->view->render('footer.phtml');
    }
}
