<?php
class SearchController extends Zend_Controller_Action
{
	public function indexAction()
	{
		if ($this->_request->getParam('query'))
		{
			$keywords = $this->_request->getParam('query');
			$query = Zend_Search_Lucene_Search_QueryParser::parse($keywords);
			$index = Zend_Search_Lucene::open(APPLICATION_PATH . '/indexes');
			$hits = $index->find($query);
			$this->view->results = $hits;
			$this->view->keywords = $keywords;
		}
		else
		{
			$this->view->results = null;
		}
	}
	
	public function buildAction()
	{
		// create the index
		$index = Zend_Search_Lucene::create(APPLICATION_PATH . '/indexes');
		
		// fetch all of the current pages
		$modelPage = new Model_PageModel();
		$currentPages = $modelPage->fetchAll();
		if ($currentPages->count() > 0)
		{
			// create a new search document for each page
			foreach ($currentPages as $p)
			{
				$page = new Melobit_Content_Item_Page($p->id);
				$doc = new Zend_Search_Lucene_Document();
				
				// you use an "unindexed" field for the "id" because you want the id
				// to be included in the search result but not searchable
				$doc->addField(Zend_Search_Lucene_Field::unIndexed('page_id', $page->id));
				
				// you use a "text" field for content fields beacuse you want the them
				// to be included in the search result and searchable
				$doc->addField(Zend_Search_Lucene_Field::text('page_name', $page->name, 'UTF-8'));
				$doc->addField(Zend_Search_Lucene_Field::text('page_headline', $page->headline, 'UTF-8'));
				$doc->addField(Zend_Search_Lucene_Field::text('page_description', $page->description, 'UTF-8'));
				$doc->addField(Zend_Search_Lucene_Field::text('page_content', $page->content, 'UTF-8'));
				
				// add the document to the index
				$index->addDocument($doc);
			}
		}
		// optimize the index
		$index->optimize();
		
		// pass the view data for reporting
		$this->view->indexSize = $index->numDocs();
	}
}















