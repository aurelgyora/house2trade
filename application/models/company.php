<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Company extends MY_Model{
	
	var $id = 0; var $zip_code = 0;
	var $title = ''; var $phone = ''; var $email = ''; var $website = ''; 
	var $address1 = ''; var $address2 = ''; var $city = ''; var $state = ''; var $logo = '';
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data){
		
		foreach($data as $key => $value):
			$this->$key = $value;
		endforeach;
		$this->db->insert('company',$this);
		return $this->db->insert_id();
	}
	
	function update_record($data){
		
		foreach($data as $key => $value):
			$this->db->set($key,$value);
		endforeach;
		$this->db->where('id',$data['id']);
		$this->db->update('company');
		return $this->db->affected_rows();
	}
	
	function companyTitles(){
		
		$this->db->select('id,title');
		$this->db->order_by('title');
		$query = $this->db->get('company');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
}