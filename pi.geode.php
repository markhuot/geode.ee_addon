<?php

require_once PATH_THIRD.'geode/config'.EXT;

$plugin_info = array(
	'pi_name'			=> GEODE_NAME,
	'pi_version'		=> GEODE_VERSION,
	'pi_author'			=> GEODE_AUTHOR,
	'pi_author_url'		=> GEODE_URL,
	'pi_description'	=> GEODE_DESCRIPTION,
	'pi_usage'			=> Geode::usage()
);


class Geode
{
    var $return_data;
	
	function __construct( $str = '' )
	{
		$this->EE =& get_instance();
		
		// Load the view
		$this->EE->load->_ci_view_path = APPPATH.'/third_party/geode/views/';
		$this->return_data = $this->EE->load->view('tag', array(
			'id' => uniqid(),
			'data' => $this->get_data()
		), TRUE);
	}
	
	public function get_data()
	{
		// Get the geode fields
		$this->EE->db->where('field_type', 'geode');
		$fields = $this->EE->db->get('exp_channel_fields f');
		
		// Build our query
		$this->EE->db->join('exp_channel_data', 'exp_channel_data.entry_id=exp_channel_titles.entry_id', 'LEFT');
		$this->EE->db->from('exp_channel_titles');
		
		// Limit to entries with geode data
		foreach ($fields->result() as $field)
		{
			$this->EE->db->where("field_id_{$field->field_id} IS NOT NULL");
			$this->EE->db->where("field_id_{$field->field_id} != ''");
		}
		
		// Hit the database
		$entries = $this->EE->db->get();
		
		// Parse the result
		$data = array();
		
		foreach ($entries->result_array() as $row)
		{
			foreach ($fields->result() as $field)
			{
				if (!$row["field_id_{$field->field_id}"])
				{
					continue;
				}
				
				$points = json_decode($row["field_id_{$field->field_id}"]);
				
				foreach ($points as $point)
				{
					$latLng = explode(',', $point);
					$data[] = array(
						"channel_id" => $row['channel_id'],
						"entry_id" => $row['entry_id'],
						"title" => $row['title'],
						"0" => $latLng[0],
						"1" => $latLng[1]
					);
				}
			}
		}
		
		return $data;
	}
	
	function usage()
	{
		return "{exp:geode near=\"19106\"}";
	}
	
}