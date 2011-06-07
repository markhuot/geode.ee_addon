<?php

class Geode_data
{
	public function __construct()
	{
		$this->EE =& get_instance();
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
}