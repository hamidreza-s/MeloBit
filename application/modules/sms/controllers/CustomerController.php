<?php
class Sms_CustomerController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$customers = Sms_Model_CustomerModel::retrieveCustomer();
		if ($customers->count() > 0)
		{
			$this->view->customers = $customers->toArray();
		}
		else
		{
			$this->view->customers = null;
		}
	}
	
	public function createAction()
	{
		$form = new Sms_Form_CustomerForm;
		
		if ($this->getRequest()->isPost())
		{
			if ($form->isValid($_POST))
			{
				$data = $form->getValues();
				$customerModel = new Sms_Model_CustomerModel;
				$id = $customerModel->createCustomer(
					$data['company_id'],
					$data['first_name'],
					$data['last_name'],
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
		$form = new Sms_Form_CustomerForm;
		$customerModel = new Sms_Model_CustomerModel;
		
		if ($this->getRequest()->isPost())
		{
			if ($form->isValid($_POST))
			{
				$data = $form->getValues();
				$id = $customerModel->updateCustomer(
					$data['id'],
					$data['company_id'],
					$data['first_name'],
					$data['last_name'],
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
			$requestedCustomer = $customerModel->find($requestedId)->current();
			$form->populate($requestedCustomer->toArray());
		}
		$this->view->form = $form;
	}
	
	public function deleteAction()
	{
		$requestedId = $this->_request->getParam('id');
		$customerModel = new Sms_Model_CustomerModel;
		$id = $customerModel->deleteCustomer($requestedId);
		
		return $this->_forward('index');
	}
}


























