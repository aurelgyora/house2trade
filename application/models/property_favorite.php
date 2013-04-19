<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Property_favorite extends MY_Model{

	var $id = 0;
	var $seller_id = ''; var $buyer_id = '';

	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data){
		
		$this->seller_id = $data['seller_id'];
		$this->buyer_id = $data['buyer_id'];
		$this->db->insert('property_favorite',$this);
		return $this->db->insert_id();
	}
	
	function record_exist($seller_id,$buyer_id){
		
		$this->db->where('seller_id',$seller_id);
		$this->db->where('buyer_id',$buyer_id);
		$query = $this->db->get('property_favorite',1);
		$data = $query->result_array();
		if(count($data)) return $data[0]['id'];
		return FALSE;
	}
	
	function record_exists($seller_id,$buyer_id){
		
		$this->db->select('id');
		$this->db->where_in('seller_id',$seller_id);
		$this->db->where_in('buyer_id',$buyer_id);
		$query = $this->db->get('property_favorite');
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