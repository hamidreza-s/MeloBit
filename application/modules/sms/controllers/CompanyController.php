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
		$form = new Sms_Form_CompanyForm;
		$companyModel = new Sms_Model_CompanyModel;
		
		if ($this->getRequest()->isPost())
		{
			if ($form->isValid($_POST))
			{
				$data = $form->getValues();
				$id = $companyModel->updateCompany(
					$data['id'],
					$data['name'],
					$data['field'],
					$data['contact_number_1'],
					$data['contact_number_2'],
					$data['address']				
				);
				
				return $this->_forward('index');
			}
		}
		else
		{
			$requestedId = $this->_request->getParam('id');
			$requestedCompany = $companyModel->find($requestedId)->current();
			$form->populate($requestedCompany->toArray());
		}
		$this->view->form = $form;
	}
	
	public function deleteAction()
	{
		$requestedId = $this->_request->getParam('id');
		$companyModel = new Sms_Model_CompanyModel;
		$id = $companyModel->deleteCompany($requestedId);
		
		return $this->_forward('index');
		
	}
}


























