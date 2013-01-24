<?php
class Sms_DispatchController extends Zend_Controller_Action
{
	protected $_WSDL = 'http://bulk.armaghan.net/post/bulk.asmx?WSDL';

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
		$orders = Sms_Model_DispatchModel::retrieveOrder();
		if ($orders->count() > 0)
		{
			$this->view->orders = $orders->toArray();
		}
		else
		{
			$this->view->orders = null;
		}
	}

	public function reviewDispatchAction() 
	{
		$requestedId = $this->_request->getParam('id');
		$dispatchModel = new Sms_Model_DispatchModel;
		$destinationModel = new Sms_Model_DestinationModel;
		$this->view->order = $dispatchModel::retrieveOrder($requestedId);
		$this->view->destinations = $destinationModel::retrieveDestination($requestedId);
	}
	
	public function confirmDispatchAction()
	{
		$requestedId = $this->_request->getParam('id');
		$dispatchModel = new Sms_Model_DispatchModel;	
		$id = $dispatchModel->confirmOrder($requestedId);
		
		return $this->_forward('review-dispatch', null, null, array('id' =>$requestedId));
	}
	
	public function suspendDispatchAction() 
	{
		$requestedId = $this->_request->getParam('id');
		$dispatchModel = new Sms_Model_DispatchModel;	
		$id = $dispatchModel->suspendOrder($requestedId);
		
		return $this->_forward('review-dispatch', null, null, array('id' =>$requestedId));
	}
	
	public function sendBulkAction()
	{
		// Set no view and layout
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		// Connect to SOAP Web Service
        $client = new Zend_Soap_Client($this->_WSDL);
		
		// Sent Bulk
		$response = $client->SendBulk(array(
			'username'			 	=> '__username__', 
			'password' 				=> '__password__', 
			'to' 							=> '______to______', 
			'from' 						=> '_____from____',
			'text' 						=> '_____body____', 
			'scheduleDateTime' 	=> '___datetime__'));
	}
	
	public function getStatusAction()
	{
		// Set no view and layout
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		// Connect to SOAP Web Service
        $client = new Zend_Soap_Client($this->_WSDL);

		// Get Status
		$response = $client->GetStatus(array(
			'bulkId' 	=> 16496, 
			'status' 	=> true,
			'delivered' => true,
			'sent' 		=> true));
			
		echo "<pre>";
		print_r($response);
		echo "</pre>";
	}
}


























