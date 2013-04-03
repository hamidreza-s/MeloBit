<?php

class BugController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function createAction()
    {
        $bugReportForm = new Form_BugReportForm();
        $bugReportForm->setMethod('post');
        
        if ($this->getRequest()->isPost())
        {     	
        	// if the form is valid; 
        	// create the Bug Model and create new bug
        	$bugModel = new Model_BugModel();
        	if ($bugReportForm->isValid($_POST))
        	{
        		$result = $bugModel->createBug(
        			$bugReportForm->getValue('author'),
        			$bugReportForm->getValue('email'),
        			$bugReportForm->getValue('date'),
        			$bugReportForm->getValue('url'),
        			$bugReportForm->getValue('description'),
        			$bugReportForm->getValue('priority'),
        			$bugReportForm->getValue('status')
        		);
        		
        		// if the createBug method returns a result
        		// then the bug was successfully created
        		if ($result)
        		{
        			$this->_forward('success');
        		}
        	}
        }
        
        $this->view->form = $bugReportForm;
    }
    
    public function listAction()
    {
    	// get the filter form
    	$listToolsForm = new Form_BugReportListToolsForm();
    	$listToolsForm->setMethod('post');
    	$this->view->listToolsForm = $listToolsForm;
    	
		// set the sort and filter criteria
		// these values can come in from the form post or url params
		// manually set these controls value
		$sort = $this->_request->getParam('sort', null);
		$filterField = $this->_request->getParam('filter_field', null);
		$filterValue = $this->_request->getParam('filter_text');
		
		if (!empty($filterField))
		{
			$filter[$filterField] = $filterValue;
		}
		else { $filter = null; }
		
		$listToolsForm->getElement('sort')->setValue($sort);
		$listToolsForm->getElement('filter_field')->setValue($filterField);
		$listToolsForm->getElement('filter_text')->setValue($filterValue);
		
		
		// fetch the bug paginator adapter
		$bugModel = new Model_BugModel();
		$adapter = $bugModel->fetchPaginatorAdapter($filter, $sort);
		$paginator = new Zend_Paginator($adapter);

		// show 10 bugs per page
		$paginator->setItemCountPerPage(5);
		
		// get the page number that is passed in the request
		// if none is set then default to page 1
		$page = $this->_request->getParam('page', 1);
		$paginator->setCurrentPageNumber($page);
		
		// pass the paginator to the view
		$this->view->paginator = $paginator;
    }
    
    public function editAction()
    {
		// instanciate bug form
    	$bugReportForm = new Form_BugReportForm();
    	$bugReportForm->setMethod('post');
    	
    	if ($this->getRequest()->isPost())
    	{
    		if ($bugReportForm->isValid($_POST))
    		{
		    	// if the form is valid; 
		    	// create the Bug Model and create new bug
		    	$bugModel = new Model_BugModel();
		    	if ($bugReportForm->isValid($_POST))
		    	{
		    		$result = $bugModel->updateBug(
		    			$bugReportForm->getValue('id'),
		    			$bugReportForm->getValue('author'),
		    			$bugReportForm->getValue('email'),
		    			$bugReportForm->getValue('date'),
		    			$bugReportForm->getValue('url'),
		    			$bugReportForm->getValue('description'),
		    			$bugReportForm->getValue('priority'),
		    			$bugReportForm->getValue('status')
		    		);
		    		
		    		// if the createBug method returns a result
		    		// then the bug was successfully created
		    		if ($result)
		    		{
		    			$this->_forward('success');
		    		}
        		}    			
    		}    	
		}
		else
		{	
			// instanciate bug model
			$bugModel = new Model_BugModel();
			
			// populate the form
			$id = $this->_request->getParam('id');
			$bug = $bugModel->find($id)->current();
			$bugReportForm->populate($bug->toArray());
			
			// format the date field
			$bugReportForm->getElement('date')->setValue(date('m-d-Y', $bug->date));
			
    		// render
    		$this->view->form = $bugReportForm;
    	}
    }
    
    public function deleteAction()
    {
    	$bugModel = new Model_BugModel();
    	$id = $this->_request->getParam('id');
    	$bugModel->deleteBug($id);
    	$this->_forward('list');
    }
    
    public function confirmAction()
    {
    	
    }
    
    public function successAction()
    {
    	
    }
}














