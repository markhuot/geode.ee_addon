<?php

require_once PATH_THIRD.'geode/mhbase'.EXT;

class Geode extends MHBase
{
	
	function __construct( $str = '' )
	{
		parent::__construct();
		
		// Load the library
		$this->EE->load->library('geode_data');
		
		// Load the view
		$this->EE->load->_ci_view_path = APPPATH.'/third_party/geode/views/';
		$this->return_data = $this->EE->load->view('tag', array(
			'id' => uniqid(),
			'data' => $this->EE->geode_data->get_data()
		), TRUE);
	}
	
	
	
}