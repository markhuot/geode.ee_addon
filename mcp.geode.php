<?php

require_once PATH_THIRD.'geode/mhbase'.EXT;

class Geode_mcp extends MHBase
{
	public function index()
	{
		$this->EE->cp->set_variable('cp_page_title', $this->EE->lang->line('geode'));
		
		$this->EE->cp->set_breadcrumb(
			BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=geode',
			$this->EE->lang->line('geode_module_name')
		);
		
		if (!@$this->EE->session->cache['com.markhuot.geode.gmapsloaded'])
		{
			$src = $this->EE->javascript->external('http://maps.google.com/maps/api/js?sensor=true');
			$this->EE->cp->add_to_head($src);
			
			$this->EE->session->cache['com.markhuot.geode.gmapsloaded'] = TRUE;
		}
		
		$this->EE->load->library('geode_data');
		
		return $this->EE->load->view('controlpanel', array(
			'id' => uniqid(),
			'data' => $this->EE->geode_data->get_data(),
		), TRUE);
	}
}