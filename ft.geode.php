<?php

require_once PATH_THIRD.'geode/config'.EXT;

class Geode_ft extends EE_Fieldtype {

	public $info = array(
		'name'		=> GEODE_NAME,
		'version'	=> GEODE_VERSION
	);
	
	public function display_field($data)
	{
		if (!@$this->EE->session->cache['com.markhuot.geode.gmapsloaded'])
		{
			$src = $this->EE->javascript->external('http://maps.google.com/maps/api/js?sensor=true');
			$this->EE->cp->add_to_head($src);
			
			$this->EE->session->cache['com.markhuot.geode.gmapsloaded'] = TRUE;
		}
		
		$this->EE->cp->load_package_js('fieldtype');
		
		return $this->EE->load->view('fieldtype', array(
			'field_id' => $this->field_id,
			'data' => json_decode(htmlspecialchars_decode($data))
		), TRUE);
	}
	
	public function save($data)
	{
		return json_encode($data);
	}
	
	public function replace_tag($data, $params = array(), $tagdata = FALSE)
	{
		$id = isset($data['entry_id']) ? $data['entry_id'] : uniqid();
		$data = json_decode(htmlspecialchars_decode($data));
		
		if (!is_array($data))
		{
			return '';
		}
		
		foreach ($data as &$row)
		{
			$row = explode(',', $row);
		}
		
		return $this->EE->load->view('tag', array(
			'id' => uniqid(),
			'data' => $data,
			'class_name' => @$params['class_name']
		), TRUE);
	}
	
}