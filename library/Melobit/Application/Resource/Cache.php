<?php
class Melobit_Application_Resource_Cache extends Zend_Application_Resource_ResourceAbstract
{
	public function init()
	{
		$options = $this->getOptions();
		// get a Zend_Cache_Core object
		$cache = Zend_Cache::factory(
			$options['frontEnd'],
			$options['backEnd'],
			$options['frontEndOptions'],
			$options['backEndOptions']);
		// store it in registry
		Zend_Registry::set('cache', $cache);
		return $cache;
	}
}
