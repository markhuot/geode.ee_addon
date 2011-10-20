<?php

require_once PATH_THIRD.'geode/config'.EXT;
require_once PATH_THIRD.'geode/mhbase'.EXT;

class Geode_acc extends MHBase {

	var $name			= GEODE_NAME;
	var $id				= GEODE_SHORT_NAME;
	var $version		= GEODE_VERSION;
	var $description	= GEODE_DESCRIPTION;
	var $sections		= array();
	
	function set_sections()
	{
		if (!@$this->EE->session->cache['com.markhuot.geode.gmapsloaded'])
		{
			$src = $this->EE->javascript->external('http://maps.google.com/maps/api/js?sensor=true');
			$this->EE->cp->add_to_head($src);
			
			$this->EE->session->cache['com.markhuot.geode.gmapsloaded'] = TRUE;
		}
		
		$this->EE->load->library('geode_data');
		
		$this->sections['Gecoded Entries'] = $this->EE->load->view('controlpanel', array(
			'id' => uniqid(),
			'data' => $this->EE->geode_data->get_data(),
		), TRUE);
	}
}