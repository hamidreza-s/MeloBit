<?php
class Sms_OrderController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$form = new Sms_Form_OrderForm;
		$this->view->form = $form;
	}
}


























