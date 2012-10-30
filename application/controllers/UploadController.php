<?php
class UploadController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$form = new Form_UploadForm;
		$form->setAction('/upload');
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost())
		{
			if ($form->isValid($_POST))
			{
				$this->view->uploadedFile = $form->file->receive();
				$this->view->uploadedFileName = basename($form->file->getFileName());
			}
		}
	}
}
