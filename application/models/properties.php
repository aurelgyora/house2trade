<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Properties extends MY_Model{
	
	var $id = 0;var $listing_id = 0;var $broker_id = 0;var $zip_code = 0;var $bathrooms = 0;var $bedrooms = 0;var $tax = 0;var $mls = 0;
	var $fname = ''; var $lname = ''; var $address1 = '';var $address2 = '';var $city = '';var $state = '';var $type = '';var $sqf = '';var $description = '';
	var $price = 0.00;
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data){

		$this->broker_id = $this->user['uid'];
		$this->fname = $data['fname'];
		$this->lname = $data['lname'];
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
		
		$this->db->insert('properties',$this);
		return $this->db->insert_id();
	}
	
	function update_record($data){

		$this->db->set('fname',$data['fname']);
		$this->db->set('lname',$data['lname']);
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
		
		$this->db->where('id',$data['id']);
		$this->db->update('properties');
		return $this->db->affected_rows();
	}
	
	function read_records($broker){
		
		$query = $this->db->get_where('properties',array('broker_id'=>$broker),1);
		$data = $query->result_array();
		if($data) return $data[0];
		return NULL;
	}
}