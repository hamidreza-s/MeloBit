<?php
class Sms_DispatchController extends Zend_Controller_Action
{
	protected $_WSDL = 'http://bulk.armaghan.net/post/bulk.asmx?WSDL';

	public function indexAction()
	{
		// inex action ...
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


























