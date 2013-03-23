<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Property_potentialby extends MY_Model{

	var $id = 0;
	var $owner = '';
	var $property = '';

	function __construct(){
		parent::__construct();
	}
	
	function insert_record($property){
		
		$this->owner = $this->user['uid'];
		$this->property = $property;
		$this->db->insert('property_potentialby',$this);
		return $this->db->insert_id();
	}
	
	function record_exist($property,$owner){
		
		$this->db->where('property',$property);
		$this->db->where('owner',$owner);
		$query = $this->db->get('property_potentialby',1);
		$data = $query->result_array();
		if(count($data)) return $data[0]['id'];
		return FALSE;
	}
}