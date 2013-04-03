<?php
class Sms_OrderController extends Zend_Controller_Action
{
	private $_authentication;
	private $_userIdentity;
	private $_userId;
	
	public function init()
	{
		// fetch the current user
		$this->_authentication = Zend_Auth::getInstance();
		$this->_userIdentity = $this->_authentication->getIdentity();
		$this->_userId = $this->_userIdentity->id;		
		$this->_userRole = $this->_userIdentity->role;
		$this->_lang = $this->_getParam('lang');
	}

	public function indexAction() 
	{
		// Filter value
		$startDate = $this->_getParam('start_date', null);
		$endDate = $this->_getParam('end_date', null);
		$companyId = $this->_getParam('company_id', null);
		$allFilterStatus = $this->_getParam('filter_status', null);
		
		// Filter form
		$orderFilterForm = new Sms_Form_OrderFilterForm();
		$orderFilterForm->getElement('start_date')->setValue($startDate);
		$orderFilterForm->getElement('end_date')->setValue($endDate);
		$orderFilterForm->getElement('company_id')->setValue($companyId);
		$orderFilterForm->getElement('filter_status')->setValue($allFilterStatus);
		$orderFilterForm->setAction('/' . $this->_lang . '/sms/order/index');
		$this->view->OrderFilterForm = $orderFilterForm;
		
		$whichPage = $this->_getParam('page');
		$rowPerPage = 3;
		$ordersPaginatorObject = Sms_Model_OrderModel::retrieveOrderByUserIdAndPage(
			$this->_userId, $this->_userRole, $whichPage, $rowPerPage, $startDate, $endDate, $companyId, $allFilterStatus
		);
		$ordersPaginatorArray = json_decode($ordersPaginatorObject->toJson(), true); // Conver JSON to Array

		if (count($ordersPaginatorArray) > 0)
		{
			$this->view->ordersObject = $ordersPaginatorObject;
			$this->view->ordersArray = $ordersPaginatorArray;
		}
		else
		{
			$this->view->ordersObject = null;
			$this->view->ordersArray = null;
		}
	}
	
	public function createOrderAction()
	{
		$form = new Sms_Form_OrderCreateForm;
		
		if ($this->getRequest()->isPost())
		{
			if ($form->isValid($_POST))
			{
				$data = $form->getValues();
				$orderModel = new Sms_Model_OrderModel;
				$id = $orderModel->createOrder(
					$data['customer_id'],
					$this->_userId,
					$data['sms_content'],
					$data['sms_quantity'],
					$data['test_phone'],
					$data['sms_fee']
				);
				
				return $this->_forward('review-order', 'order', null, array('id' => $id));
			}
		}
		
		$this->view->form = $form;	
	}
	
	public function updateOrderAction() 
	{
		$form = new Sms_Form_OrderCreateForm;
		$orderModel = new Sms_Model_OrderModel;
		
		if ($this->getRequest()->isPost())
		{
			if ($form->isValid($_POST))
			{
				$data = $form->getValues();
				$id = $orderModel->updateOrder(
					$data['id'],
					$data['customer_id'],
					$data['sms_content'],
					$data['sms_quantity'],
					$data['test_phone'],
					$data['sms_fee']
				);
				
				return $this->_forward('index');
			}
		}
		else
		{
			$requestedId = $this->_request->getParam('id');
			$requestedOrder = $orderModel->find($requestedId)->current();
			
			// If "current user" is not the same as "orderer user" or admin, go to error controller
			if ($requestedOrder->user_id != $this->_userId && $this->_userRole != "administrator") 
			{
				return $this->_forward('noauth', 'error', 'default', null);
			}
			
			$form->populate($requestedOrder->toArray());
		}
		$this->view->form = $form;		
	}
	
	public function deleteOrderAction() 
	{
		$requestedId = $this->_request->getParam('id');
		$orderModel = new Sms_Model_OrderModel;
		$requestedOrder = $orderModel->find($requestedId)->current();
		
		// If "current user" is not the same as "orderer user" or admin, go to error controller
		if ($requestedOrder->user_id != $this->_userId && $this->_userRole != "administrator") 
		{
			return $this->_forward('noauth', 'error', 'default', null);
		}
		
		$id = $orderModel->deleteOrder($requestedId);
		
		return $this->_forward('index');	
	}	

	public function listDestinationAction()
	{
		$requestedId = $this->_request->getParam('id');
		$destinationModel = new Sms_Model_DestinationModel;
		$destinations = $destinationModel->retrieveDestinations($requestedId);
		if ($destinations->count() > 0)
		{
			$this->view->destinations = $destinations->toArray();
		}
		else
		{
			$this->view->destinations = null;
		}
		
		// send order_id to view
		$this->view->order_id = $requestedId;
	}
	
	public function ajaxRetrieveDestinationAction()
	{
		// Set no view and layout
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);

		$requestedId = $this->_request->getParam('id');
		$destinationModel = new Sms_Model_DestinationModel;
		$destination = $destinationModel->retrieveDestination($requestedId);
		
		if ($destination->count() > 0)
		{
			$destinationObject = $destination->current();
			$destinationArray = array(
				'id'									=> $destinationObject->id,
				'order_id'						=> $destinationObject->order_id,
				'destination_type'			=> $destinationObject->destination_type,
				'destination_value'			=> $destinationObject->destination_value,
				'dispatch_date'				=> Melobit_Date_Convertor::timestamp_to_jalali($destinationObject->dispatch_date),
				'destinations_quantity'	=> $destinationObject->destinations_quantity,
				'requested'						=> $destinationObject->destination_end - $destinationObject->destination_start + 1,
			);

			header("Content-Type: application/json; charset=utf-8");
			echo json_encode($destinationArray);

		}		
	}
	
	public function ajaxCalculateDestinationsAction()
	{
		// Set no view and layout
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);

		$requestedType = $this->_request->getParam('type');
		$requestedCode = $this->_request->getParam('code');
		if ($requestedType == 'postal') 
		{
			echo Sms_Model_PostalCodeAllModel::countByPostal($requestedCode);
		}
		elseif ($requestedType == 'province') 
		{
			echo Sms_Model_ProvinceCodeAllModel::countByProvince($requestedCode);
		}
	}
	
	public function createDestinationAction()	
	{
		$form = new Sms_Form_OrderDestinationForm;
		
		if ($this->getRequest()->isPost())
		{
			if ($form->isValid($_POST))
			{
				$data = $form->getValues();
				$destinationModel = new Sms_Model_DestinationModel;
				$requestedId = $this->_request->getParam('id');
				$countPostal = Sms_Model_PostalCodeAllModel::countPostal($data['destination_value']);	
				$id = $destinationModel->createDestination(
					$requestedId,
					$data['destination_type'],
					$data['destination_value'],
					$data['destination_order'],
					$data['destination_start'],
					$data['destination_end'],
					$data['dispatch_date'],
					$countPostal
				);
				
				return $this->_forward('list-destination');
			}
		}
		
		$this->view->form = $form;			
	}

	public function ajaxCreateDestinationAction()	
	{
		// Set no view and layout
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$form = new Sms_Form_OrderDestinationForm;
		
		if ($this->getRequest()->isPost())
		{
			if ($form->isValid($_POST))
			{
				$data = $form->getValues();
				$destinationModel = new Sms_Model_DestinationModel;
				
				if ($data['destination_type'] == 'postal')
				{
					$countPhoneNo = Sms_Model_PostalCodeAllModel::countByPostal($data['destination_value']);	
				}
				elseif ($data['destination_type'] == 'province')
				{
					$countPhoneNo = Sms_Model_ProvinceCodeAllModel::countByProvince($data['destination_value']);	
				}
							
				$id = $destinationModel->createDestination(
					$data['order_id'],
					$data['destination_type'],
					$data['destination_value'],
					$data['destination_order'],
					$data['destination_start'],
					$data['destination_end'],
					$data['dispatch_date'],
					$countPhoneNo
				);
				
				if ($id)
				{
					echo $id;
				}
			}
		}		
	}
	
	public function updateDestinationAction() 
	{
		$form = new Sms_Form_OrderDestinationForm;
		$destinationModel = new Sms_Model_DestinationModel;
		
		if ($this->getRequest()->isPost())
		{
			if ($form->isValid($_POST))
			{
				$data = $form->getValues();
				
				if ($data['destination_type'] == 'postal')
				{
					$countPhoneNo = Sms_Model_PostalCodeAllModel::countByPostal($data['destination_value']);	
				}
				elseif ($data['destination_type'] == 'province')
				{
					$countPhoneNo = Sms_Model_ProvinceCodeAllModel::countByProvince($data['destination_value']);	
				}
				
				$id = $destinationModel->updateDestination(
					$data['id'],
					$data['order_id'],
					$data['destination_type'],
					$data['destination_value'],
					$data['destination_order'],
					$data['destination_start'],
					$data['destination_end'],
					$data['dispatch_date'],
					$countPhoneNo				
				);
				
				// return $this->_forward($action, $controller = null, $module = null, array($params = null))
				return $this->_forward('review-order', null, null, array('id' => $data['order_id']));
			}
		}
		else
		{
			$requestedId = $this->_request->getParam('id');
			$requestedDestination = $destinationModel->find($requestedId)->current();
			$form->populate($requestedDestination->toArray());
			
			// meanwhile; change timestamp to Jalali Date
			$timeStampDate = $form->getValue('dispatch_date');
			$jalaliDate = Melobit_Date_Convertor::timestamp_to_jalali($timeStampDate);
			$form->getElement('dispatch_date')->setValue($jalaliDate);
		}
		$this->view->form = $form;		
	}
	
	public function deleteDestinationAction() 
	{
		$requestedId = $this->_request->getParam('id');
		$destinationModel = new Sms_Model_DestinationModel;
		$returnedValue = $destinationModel->deleteDestination($requestedId);
		$id = $returnedValue['destination_id'];
		$order_id = $returnedValue['order_id'];
		
		return $this->_forward('review-order', null, null, array('id' => $order_id));
	}
	
	public function reviewOrderAction() 
	{
		/* --------- 1, Order Details --------- */
		
		$requestedId = $this->_request->getParam('id');
		$orderModel = new Sms_Model_OrderModel;
		$this->view->order = $orderModel::retrieveOrder($requestedId);
		
		/* --------- 2, Destinations Details --------- */
		
		// Destination details
		$destinationModel = new Sms_Model_DestinationModel;
		$destinations = $destinationModel::retrieveDestinations($requestedId);		
		if ($destinations->count() > 0)
		{
			$this->view->destinations = $destinations->toArray();
		}
		else
		{
			$this->view->destinations = null;
		}
		
		// Destination form
		$destinationForm = new Sms_Form_OrderDestinationForm;
		$destinationForm->getElement('order_id')->setValue($requestedId);
		$this->view->destinationForm = $destinationForm;
		
		/* --------- 3, Transactions Details --------- */
		
		// Transaction details
		$transactionModel = new Sms_Model_TransactionModel;
		$transactions = $transactionModel::retrieveTransactions($requestedId);
		if ($transactions->count() > 0)
		{
			$this->view->transactions = $transactions->toArray();
		}
		else
		{
			$this->view->transactions = null;
		}
		
		// Transaction form
		$transactionForm = new Sms_Form_OrderTransactionForm;
		$transactionForm->getElement('order_id')->setValue($requestedId);
		$this->view->transactionForm = $transactionForm;
	}
	
	public function confirmOrderAction()
	{
		$requestedId = $this->_request->getParam('id');
		$orderModel = new Sms_Model_OrderModel;	
		$id = $orderModel->confirmOrder($requestedId);
		
		return $this->_forward('review-order', null, null, array('id' =>$requestedId));
	}
	
	public function suspendOrderAction() 
	{
		$requestedId = $this->_request->getParam('id');
		$orderModel = new Sms_Model_OrderModel;	
		$id = $orderModel->suspendOrder($requestedId);
		
		return $this->_forward('review-order', null, null, array('id' =>$requestedId));
	}
	
	public function listTransactionAction()
	{
		$requestedId = $this->_request->getParam('id');
		$transactions = Sms_Model_TransactionModel::retrieveTransactions($requestedId);
		if ($transactions->count() > 0)
		{
			$this->view->transactions = $transactions->toArray();
		}
		else
		{
			$this->view->transactions = null;
		}
		
		// send order_id to view
		$this->view->order_id = $requestedId;
	}
	
	public function createTransactionAction()
	{
		$form = new Sms_Form_OrderTransactionForm;
		
		if ($this->getRequest()->isPost())
		{
			if ($form->isValid($_POST))
			{
				$data = $form->getValues();
				$transactionModel = new Sms_Model_TransactionModel;
				$requestedId = $this->_request->getParam('id');
				$id = $transactionModel->createTransaction(
					$requestedId,
					$data['receipt_number'],
					$data['bank_account'],
					$data['deposit_date'],
					$data['depositor_name'],
					$data['deposit_fee']
				);
				
				return $this->_forward('list-transaction');
			}
		}
		
		$this->view->form = $form;			
	}
	
	public function updateTransactionAction()
	{
		$form = new Sms_Form_OrderTransactionForm;
		$transactionModel = new Sms_Model_TransactionModel;
		
		if ($this->getRequest()->isPost())
		{
			if ($form->isValid($_POST))
			{
				$data = $form->getValues();
				$id = $transactionModel->updateTransaction(
					$data['id'],
					$data['order_id'],
					$data['receipt_number'],
					$data['bank_account'],
					$data['deposit_date'],
					$data['depositor_name'],
					$data['deposit_fee']
				);
				
				// return $this->_forward($action, $controller = null, $module = null, array($params = null))
				return $this->_forward('review-order', null, null, array('id' => $data['order_id']));
			}
		}
		else
		{
			$requestId = $this->_request->getParam('id');
			$requestedTransaction = $transactionModel->find($requestId)->current();
			$form->populate($requestedTransaction->toArray());
			
			// meanwhile; change timestamp to Jalali Date
			$timeStampDate = $form->getValue('deposit_date');
			$jalaliDate = Melobit_Date_Convertor::timestamp_to_jalali($timeStampDate);
			$form->getElement('deposit_date')->setValue($jalaliDate);
		}
		$this->view->form = $form;
	}
	
	public function deleteTransactionAction()
	{
		$requestedId = $this->_request->getParam('id');
		$transactionModel = new Sms_Model_TransactionModel;
		$returnedValue = $transactionModel->deleteTransaction($requestedId);
		$id = $returnedValue['transaction_id'];
		$order_id = $returnedValue['order_id'];
		
		return $this->_forward('review-order', null, null, array('id' => $order_id));
	}
	
	public function ajaxRetrieveTransactionAction()
	{
		// Set no view and layout
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$requestedId = $this->_request->getParam('id');
		$transactionModel = new Sms_Model_TransactionModel;
		$transaction = $transactionModel->retrieveTransaction($requestedId);	
		
		if ($transaction->count() > 0)
		{
			$transactionObject = $transaction->current();
			$transactionArray = array(
				'id'									=> $transactionObject->id,
				'order_id'						=> $transactionObject->order_id,
				'receipt_number'			=> $transactionObject->receipt_number,
				'bank_account'				=> $transactionObject->bank_account,
				'deposit_date'					=> Melobit_Date_Convertor::timestamp_to_jalali($transactionObject->deposit_date),
				'depositor_name'			=> $transactionObject->depositor_name,
				'deposit_fee'					=> $transactionObject->deposit_fee
			);
			
			header("Content-Type: application/json; charset=utf-8");
			echo json_encode($transactionArray);			
		}
	}
	
	public function ajaxCreateTransactionAction()
	{
		// Set no view and layout
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$form = new Sms_Form_OrderTransactionForm;
		
		if ($this->getRequest()->isPost())
		{
			if ($form->isValid($_POST))
			{
				$data = $form->getValues();
				$transactionModel = new Sms_Model_TransactionModel;
				$id = $transactionModel->createTransaction(
					$data['order_id'],
					$data['receipt_number'],
					$data['bank_account'],
					$data['deposit_date'],
					$data['depositor_name'],
					$data['deposit_fee']				
				);
				
				if ($id)
				{
					echo $id;
				}
			}
		}
	}
	
	public function ajaxRetrieveCityListAction()
	{
		// Set no view and layout
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$requestedProvince = $this->_request->getParam('province');	
		$requestedRange = $this->_request->getParam('range');	
		
		// retrieve data from database
		$provinceCityNameList = Sms_Model_ProvinceCityNameListModel::retrieveProvinceCityList($requestedRange, $requestedProvince);
		foreach ($provinceCityNameList as $provinceCity)
		{
			$provinceCityCode = $provinceCity['city_code'];
			$provinceCityName = $provinceCity['city_name'];
			$provinceCityNameListArray[$provinceCityCode] = $provinceCityName;
		}

			header("Content-Type: application/json; charset=utf-8");
			echo json_encode($provinceCityNameListArray);			

		
	}

}


























