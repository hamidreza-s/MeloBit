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
		$this->view->destinations = $destinationModel::retrieveDestinations($requestedId);
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
		
		// Get order ID from $_GET
		$requestedId = $this->_request->getParam('id');
		
		// Retrieve all possible destinations_value destination_start/end (destinations table)
		$destinationModel = new Sms_Model_DestinationModel;
		$destinationRow = $destinationModel->find($requestedId)->current();
		
		// Initialize $finalDestinations string
		$finalDestinations = null;
	
		// Calculate destination parameters
		$orderId = $destinationRow->order_id;
		$value	= $destinationRow->destination_value;
		$start = $destinationRow->destination_start;
		$end = $destinationRow->destination_end;
		$datetime = date('o-m-d\TH:i:s', $destinationRow->dispatch_date);
		$until = $end - $start;
		
		// fetch phone_no in limited area
		$postalCodeAllModel = Sms_Model_PostalCodeAllModel::retrievePostal($value, $until, $start)->toArray();
		
		// compose $finalDestinations
		for ($i = 0; $i < $until; $i++)
		{
			$finalDestinations .= $postalCodeAllModel[$i]['phone_no'] . "\n";
		}
		
		// Retrieve sms_content (orders table)
		$orderModel = Sms_Model_OrderModel::retrieveOrder($orderId);
		$smsContent = $orderModel->sms_content;
		
		// Retrieve test_phone (orders table)
		$testPhone = $orderModel->test_phone;


		// Sent Bulk
		$bulk_id = $client->SendBulk(array(
			'username'			 		=> 'bulkarmaghan', 
			'password' 					=> '___PASSWORD___', 
			'to' 								=> $testPhone . "\n" . $finalDestinations, 
			'from' 							=> '54000004',
			'text' 							=> $smsContent, 
			'scheduleDateTime' 	=> $datetime));

		// convert bulk_id to string
		$bulk_id = $bulk_id->SendBulkResult;

		// if succeed
		if ($bulk_id)
		{
			// Save bulk_id (transaction table)
			$destinationRow->bulk_id = $bulk_id;
			$result = $destinationRow->save();		
			
			return $this->_forward("review-dispatch", "dispatch", "sms", array("id" => $orderId));
		}
		else
		{
			echo "There was a problem in SMS Gateway!";
		}
	}
	
	public function getStatusAction()
	{	
		// Connect to SOAP Web Service
        $client = new Zend_Soap_Client($this->_WSDL);

		// Get destination ID from $_GET
		$requestedId = $this->_request->getParam('id');
		
		// Retrieve destination values (destinations table)
		$destinationModel = new Sms_Model_DestinationModel;
		$destinationRow = $destinationModel->find($requestedId)->current();
		
		// Send destination information to view
		$this->view->destination = $destinationRow;
		
		// Get Status
		$status = $client->GetStatus(array(
			'bulkId' 	=> $destinationRow->bulk_id, 
			'status' 	=> true,
			'delivered' => true,
			'sent' 		=> true));
			
		// Send bulk status to view
		$this->view->status = $status;
	}
}


























