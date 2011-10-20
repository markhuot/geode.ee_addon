<?php

require_once PATH_THIRD.'geode/config'.EXT;
require_once PATH_THIRD.'geode/mhbase'.EXT;

class Geode_ext extends MHBase
{

	public $name = GEODE_NAME;
	public $version = GEODE_VERSION;
	public $description = GEODE_DESCRIPTION;
	public $docs_url = GEODE_URL;
	public $settings_exist = 'n';
	public $settings = array();
	public $required_by = array('module');

	public function __construct($settings='')
	{
		$this->EE =& get_instance();
		$this->settings = $settings;
	}

	public function sessions_start()
	{

	}

	public function activate_extension()
	{
		$this->settings = array(
			/*'max_link_length'	=> 18,
			'truncate_cp_links'	=> 'no',
			'use_in_forum'		=> 'no'*/
		);


		foreach (array(
			'sessions_start'
		) as $hook)
		{
			$this->EE->db->insert('extensions', array(
				'class'		=> __CLASS__,
				'method'	=> $hook,
				'hook'		=> $hook,
				'settings'	=> serialize($this->settings),
				'priority'	=> 10,
				'version'	=> $this->version,
				'enabled'	=> 'y'
			));
		}
	}

	public function update_extension($current = '')
	{
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}

		if ($current < '2.0')
		{
			// Update to version 2.0
		}

		$this->EE->db->where('class', __CLASS__);
		$this->EE->db->update('extensions', array('version' => $this->version));
	}

	public function disable_extension()
	{
		$this->EE->db->where('class', __CLASS__);
		$this->EE->db->delete('extensions');
	}

}