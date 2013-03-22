<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Owners extends MY_Model{
	
	var $id = 0; 
	var $broker_id = 0;
	var $seller = 0;
	var $fname = '';
	var $lname = '';
	var $cell = '';
	var $phone = '';
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data){
		
		if($this->loginstatus):
			$this->broker_id = $this->user['uid'];
		endif;
		$this->fname = $data['fname'];
		$this->lname = $data['lname'];
		if(isset($data['seller'])):
			$this->seller = $data['seller'];
		endif;
		$this->db->insert('owners',$this);
		return $this->db->insert_id();
	}
	
	function update_record($id,$data){

		$this->db->set('fname',$data['fname']);
		$this->db->set('lname',$data['lname']);
		$this->db->where('id',$id);
		$this->db->update('owners');
		return $this->db->affected_rows();
	}
	
	function read_records($broker){
		
		$query = $this->db->get_where('owners',array('broker_id'=>$broker),1);
		$data = $query->result_array();
		if($data) return $data;
		return NULL;
	}
}