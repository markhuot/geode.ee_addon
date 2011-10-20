<?php

require_once PATH_THIRD.'geode/config'.EXT;
require_once PATH_THIRD.'geode/mhbase'.EXT;

class Geode_upd extends MHBase_upd
{
	
	var $module_name = GEODE_NAME;
	var $version = GEODE_VERSION;
	
	public function install()
	{
		$result = parent::install();
		
		if ($result)
		{
			// Custom install methods
		}
		
		return $result;
	}
	
}