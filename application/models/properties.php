<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Properties extends MY_Model{
	
	var $id = 0;var $listing_id = 0;var $owner_id = 0;var $broker_id = 0;
	var $zip_code = 0;var $bathrooms = 0;var $bedrooms = 0;var $tax = 0;var $mls = 0;
	var $address1 = '';var $address2 = '';var $city = '';var $state = '';var $type = '';var $sqf = '';var $description = '';
	var $price = 0.00;
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data){
		
		if($this->loginstatus):
			$this->broker_id = $this->user['uid'];
		endif;
		$this->owner_id = $data['user_id'];
		if(isset($data['state']) && isset($data['zip_code'])):
			$this->zip_code = $data['zip_code'];
			$this->bathrooms = $data['bathrooms'];
			$this->bedrooms = $data['bedrooms'];
			$this->tax = $data['tax'];
			$this->mls = $data['mls'];
			$this->address1 = $data['address1'];
			$this->address2 = $data['address2'];
			$this->city = $data['city'];
			$this->state = $data['state'];
			$this->type = $data['type'];
			$this->sqf = $data['sqf'];
			$this->description = $data['description'];
			$this->price = $data['price'];
		endif;
		$this->db->insert('properties',$this);
		return $this->db->insert_id();
	}
	
	function update_record($id,$data){

		$this->db->set('zip_code',$data['zip_code']);
		$this->db->set('bathrooms',$data['bathrooms']);
		$this->db->set('bedrooms',$data['bedrooms']);
		$this->db->set('tax',$data['tax']);
		$this->db->set('mls',$data['mls']);
		$this->db->set('address1',$data['address1']);
		$this->db->set('address2',$data['address2']);
		$this->db->set('city',$data['city']);
		$this->db->set('state',$data['state']);
		$this->db->set('type',$data['type']);
		$this->db->set('sqf',$data['sqf']);
		$this->db->set('description',$data['description']);
		$this->db->set('price',$data['price']);
		
		$this->db->where('id',$id);
		$this->db->update('properties');
		return $this->db->affected_rows();
	}
	
	function read_records($owner){
		
		$query = $this->db->get_where('properties',array('owner_id'=>$owner));
		$data = $query->result_array();
		if($data) return $data;
		return NULL;
	}

	function properties_exits($state,$zip_code){
		
		$this->db->where('state',$state);
		$this->db->where('zip_code',$zip_code);
		$query = $this->db->get('properties',1);
		$data = $query->result_array();
		if($data) return $data[0]['id'];
		return FALSE;
	}
	
}