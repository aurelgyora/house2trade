<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Property_potentialby extends MY_Model{

	var $id = 0;
	var $owner = '';
	var $property = '';
	var $down_payment = 0;

	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data){
		
		$this->owner = $data['owner'];
		$this->property = $data['property'];
		if(isset($data['down_payment'])):
			$this->down_payment = $data['down_payment'];
		endif;
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
	
	function record_exists($properties,$owner){
		
		$this->db->select('property');
		$this->db->where_in('property',$properties);
		$this->db->where('owner',$owner);
		$query = $this->db->get('property_potentialby');
		$result = array();
		foreach($query->result() as $row):
			foreach($row as $value):
				$result[$value] = TRUE;
			endforeach;
		endforeach;
		if($result):
			return $result;
		else:
			return NULL;
		endif;
	}
	
}