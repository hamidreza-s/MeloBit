<?php
class Sms_ControlController extends Zend_Controller_Action
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
	}

	public function indexAction()
	{
		$orders = Sms_Model_ControlModel::retrieveOrder();
		if ($orders->count() > 0)
		{
			$this->view->orders = $orders->toArray();
		}
		else
		{
			$this->view->orders = null;
		}
	}
	
	public function reviewControlAction() 
	{
		// Order details
		$requestedId = $this->_request->getParam('id');
		$controlModel = new Sms_Model_ControlModel;
		$this->view->order = $controlModel::retrieveOrder($requestedId);
		
		// Destination details
		$destinationModel = new Sms_Model_DestinationModel;	
		$this->view->destinations = $destinationModel::retrieveDestinations($requestedId);
		
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
	}
	
	public function confirmControlAction()
	{
		$requestedId = $this->_request->getParam('id');
		$controlModel = new Sms_Model_ControlModel;	
		$id = $controlModel->confirmOrder($requestedId);
		
		return $this->_forward('review-control', null, null, array('id' =>$requestedId));
	}
	
	public function suspendControlAction() 
	{
		$requestedId = $this->_request->getParam('id');
		$controlModel = new Sms_Model_ControlModel;	
		$id = $controlModel->suspendOrder($requestedId);
		
		return $this->_forward('review-control', null, null, array('id' =>$requestedId));
	}
}


























