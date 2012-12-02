<?php
class InstallerController extends Zend_Controller_Action
{
	protected $_dbAdapter;
	protected $_dbName;
	protected $_dbList;
	protected $_error;
	
	public function init()
	{
		// get db adapter
		$this->_dbAdapter = Zend_Db_Table::getDefaultAdapter();
		
	}
	
	public function indexAction()
	{
		// disable layout
		$this->_helper->layout->disableLayout();
	}
		
	public function databaseAction()
	{
		// try to list table
		// to find if db is connected or not
		try 
		{
			$this->_dbList = $this->_dbAdapter->listTables();
		}
		catch (Exception $e)
		{
			$this->_error = $e->getMessage();
		}
		
		
		// if db is connected go to next step
		if ($this->_error == null)
		{
			$dbConfig = $this->_dbAdapter->getConfig();
			$this->_dbName = $dbConfig['dbname'];
			$this->view->dbName = $this->_dbName;
			
		}
		// if not, inform user
		else
		{
			$this->view->error = $this->_error;
		}
		
		// disable layout
		$this->_helper->layout->disableLayout();
	}
	
	public function tablesAction()
	{
		// this block executes the actual statements that were loaded from
		// the schema file.
		try 
		{
			$schemaSql = file_get_contents(APPLICATION_PATH . '/../docs/database/melobit_0.4.0.sql');
			// use the connection directly to load sql in batches
			$this->_dbAdapter->getConnection()->exec($schemaSql);
		}
		catch (Exception $e) 
		{
			$this->_error = $e->getMessage();
		}

		// if tables was created go to next step
		if ($this->_error == null)
		{
			$this->view->listTables = $this->_dbAdapter->listTables();
		}
		// if not, inform user
		else
		{
			$this->view->error = $this->_error;
		}

		// hidden InstallerController (this file)
		// because of security reasons
		$old = APPLICATION_PATH . '/controllers/InstallerController.php';
		$new = APPLICATION_PATH . '/controllers/.InstallerController.php';
		rename ($old, $new) or die("Unable to rename $old to $new");
		
		// disable layout
		$this->_helper->layout->disableLayout();
	}
}





















