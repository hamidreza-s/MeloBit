<?php
class Sms_CompanyController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$companies = Sms_Model_CompanyModel::retrieveCompany();
		if ($companies->count() > 0)
		{
			$this->view->companies = $companies->toArray();
		}
		else
		{
			$this->view->companies = null;
		}
	
	}
	
	public function createAction()
	{
		$form = new Sms_Form_CompanyForm;
			
		if ($this->getRequest()->isPost())
		{
			if ($form->isValid($_POST))
			{
				$data = $form->getValues();
				$companyModel = new Sms_Model_CompanyModel;
				$id = $companyModel->createCompany(
					$data['name'],
					$data['field'],
					$data['contact_number_1'],
					$data['contact_number_2'],
					$data['address']
				);

				return $this->_forward('index');
			}
		}
		
		$this->view->form = $form;
	}
	
	public function updateAction()
	{
		// --- to be scripted	
	}
	
	public function deleteAction()
	{
		// --- to be scripted	
	}
}


























