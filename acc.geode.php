<?php

class Geode_acc {

	var $name		= 'Geode';
	var $id			= 'geode';
	var $version		= '1.0.0';
	var $description	= 'Gecoding';
	var $sections		= array();

	function __construct()
	{
		$this->EE =& get_instance();
	}
	
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