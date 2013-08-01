<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Desired_properties extends MY_Model{
	
	var $id = 0; var $broker = 0; var $owner = 0; var $zip_code = 0; var $bathrooms = 0; var $bedrooms = 0; var $property_id = 0;
	var $city = ''; var $state = ''; var $type = '';var $max_price = 0.00;
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data){
		
		if($this->loginstatus && ($this->account['group'] == 2)):
			$this->broker = $this->account['id'];
		endif;
		$this->owner = $data['user_id'];
		if(isset($data['desired_state']) && isset($data['desired_zip_code'])):
			$this->property_id = trim($data['desired_property_id']);
			$this->zip_code = trim($data['desired_zip_code']);
			$this->bathrooms = trim($data['desired_bathrooms']);
			$this->bedrooms = trim($data['desired_bedrooms']);
			$this->city = trim($data['desired_city']);
			$this->state = trim($data['desired_state']);
			$this->type = trim($data['desired_type']);
			$this->max_price = $data['desired_max_price'];
		endif;
		$this->db->insert('desired_properties',$this);
		return $this->db->insert_id();
	}
	
	function insertClearRecord($mainProperty){
		
		if($this->account['group'] == 2):
			$this->broker = $this->account['id'];
			$this->owner = $mainProperty['owner'];
		elseif($this->account['group'] == 3):
			$this->owner = $this->account['id'];
		endif;
		$this->property_id = $mainProperty['id'];
		$this->db->insert('desired_properties',$this);
		return $this->db->insert_id();
	}
	
	function update_record($id,$data){

		$this->db->set('zip_code',$data['desired_zip_code']);
		$this->db->set('bathrooms',$data['desired_bathrooms']);
		$this->db->set('bedrooms',$data['desired_bedrooms']);
		$this->db->set('city',$data['desired_city']);
		$this->db->set('state',$data['desired_state']);
		$this->db->set('type',$data['desired_type']);
		$this->db->set('max_price',$data['desired_max_price']);
		
		$this->db->where('id',$id);
		$this->db->update('desired_properties');
		return $this->db->affected_rows();
	}
	
	function getDesiredByPropertyID($propertyID){
		
		$this->db->where('property_id',$propertyID);
		$query = $this->db->get('desired_properties',1);
		$data = $query->result_array();
		if($data) return $data[0];
		return FALSE;
	}
	
}