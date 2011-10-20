<?php

class MHBase
{
	public function __construct() 
	{
		$this->EE =& get_instance();
	}
}

class MHBase_upd extends MHBase
{
	public function install()
	{
		$data = array(
			'module_name' => $this->module_name,
			'module_version' => $this->version,
			'has_cp_backend' => 'y',
			'has_publish_fields' => 'n'
		);
		
		$this->EE->db->insert('modules', $data);
		
		return TRUE;
	}
	
	public function update($current = '')
	{
		if ($current == $this->version)
		{
			return FALSE;
		}
			
		if ($current < 2.0) 
		{
			// Do your update code here
		} 
		
		return TRUE; 
	}
	
	public function uninstall()
	{
		// remove module
		$this->EE->db->where('module_name', $this->module_name);
		$this->EE->db->delete('modules');
		
		// remove actions
		$this->EE->db->where('class', $this->module_name);
		$this->EE->db->delete('actions');
		
		return TRUE;
	}
	
}