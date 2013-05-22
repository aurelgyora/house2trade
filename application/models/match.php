<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Match extends MY_Model{

	function __construct(){
		parent::__construct();
	}
	
	function parseMatchPropertyID($property){
		
		$this->db->where('status <',2);
		$this->db->where('(property_id1',$property);
		$this->db->or_where('property_id2',$property);
		$this->db->or_where('property_id3',$property);
		$this->db->or_where('property_id4',$property);
		$this->db->or_where('property_id5',$property);
		$this->db->or_where("property_id6 = $property)");
		$query = $this->db->get('match',1);
		$data = $query->result_array();
		if(count($data) > 0) return $data[0];
		return NULL;
	}
	
}