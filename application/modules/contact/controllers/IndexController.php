<?php
class Contact_IndexController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$formContact = new Contact_Form_ContactForm();
		// if form is send backed, proccess it
		if ($this->_request->isPost() && $formContact->isValid($_POST))
		{
			// get the posted data
			$sender = $formContact->getValue('name');
			$email = $formContact->getValue('email');
			$subject = $formContact->getValue('subject');
			$message = $formContact->getValue('message');
			$file = $formContact->getValue('attachment');

			// load "toContactMail" from adminConfig.ini
			$configResource = $this->getInvokeArg('bootstrap')->getOption('configs');
			$adminConfig = new Zend_Config_Ini($configResource['adminConfig']);
			$toContactMail = $adminConfig->contact->contactEmailAddress;
			$fromContactMail = $adminConfig->contact->fromEmailAddress;
			$appSpecificPassword = $adminConfig->contact->appSpecificPassword;

			// create SMTP connection Object
			$configInfo = array(
					'auth'     => 'login',
						'ssl'      => 'tls',
						'username' => $fromContactMail,
						'password' => $appSpecificPassword,
						'port'     => '587');

			// instantiate new Zend Mail Transport Smtp Object
			$smtpHost = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $configInfo);

			// load the template
			$htmlMessage = $this->view->partial(
				'template/default.phtml', $formContact->getValues());
				
			// load "toContactMail" from adminConfig.ini
			$configResource = $this->getInvokeArg('bootstrap')->getOption('configs');
			$adminConfig = new Zend_Config_Ini($configResource['adminConfig']);
			$toContactMail = $adminConfig->contact->contactEmailAddress;
				
			// create mail object
			$mail = new Zend_Mail();
			$mail->setSubject($subject);
			$mail->setFrom($email, $sender);
			$mail->addTo($toContactMail, 'webmaster');

			// add the file attachment if exists
			$fileControl = $formContact->getElement('attachment');
			if ($fileControl->isUploaded())
			{
				// load uploaded file
				$attachmentName = $fileControl->getFileName();
				$fileStream = file_get_contents($attachmentName);
				
				// create the attachment
				$attachment = $mail->createAttachment($fileStream);
				$attachment->filename = basename($attachmentName);
				
				// delete uploaded file
				unlink(APPLICATION_PATH . '/../temp/' . $file);
			}
			
			// it is important to provide a text-only version
			// in addition to the html message
			$mail->setBodyHtml($htmlMessage);
			$mail->setBodyText($message);
			
			// send the mail
			$result = $mail->send($smtpHost);
			
			// inform the view with the status
			$this->view->messageProcessed = true;
			if ($result)
			{
				$this->view->sendError = false;
			}
			else
			{
				$this->view->sendError = true;
			}
		}
		$formContact->setAction('/contact');
		$this->view->form = $formContact;
	}
}


























