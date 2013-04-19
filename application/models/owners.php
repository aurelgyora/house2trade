<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Owners extends MY_Model{
	
	var $id = 0; var $seller = 0;
	var $fname = ''; var $lname = ''; var $cell = ''; var $phone = '';
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data){
		
		$this->fname = $data['fname'];
		$this->lname = $data['lname'];
		if(isset($data['seller'])):
			$this->seller = $data['seller'];
		endif;
		$this->db->insert('owners',$this);
		return $this->db->insert_id();
	}
	
	function update_record($data){
		
		if(isset($data['fname'])):
			$this->db->set('fname',$data['fname']);
		endif;
		if(isset($data['lname'])):
			$this->db->set('lname',$data['lname']);
		endif;
		if(isset($data['cell'])):
			$this->db->set('cell',$data['cell']);
		endif;
		if(isset($data['phone'])):
			$this->db->set('phone',$data['phone']);
		endif;
		$this->db->where('id',$data['id']);
		$this->db->update('owners');
		return $this->db->affected_rows();
	}
	
}