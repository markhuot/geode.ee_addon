<?php

class Geode
{
	
	function __construct( $str = '' )
	{
		$this->EE =& get_instance();
		
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