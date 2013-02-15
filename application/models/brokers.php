<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Brokers extends MY_Model{

	var $id		= 0;
	var $fname	= '';
	var $lname	= '';
	var $phone	= '';
	var $company= '';
	var $address= '';
	var $cphone	= '';
	var $cmail	= '';
	var $website= '';
	var $cell	= '';
	var $license= 0;
	var $subcribe= 1;

	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data){

		$this->fname 	= $data['fname'];
		$this->lname 	= $data['lname'];
		$this->phone 	= $data['phone'];
		$this->company 	= $data['company'];
		$this->address 	= $data['address'];
		$this->cphone 	= $data['cphone'];
		$this->cmail 	= $data['cmail'];
		$this->website 	= $data['website'];
		$this->license 	= $data['license'];
		$this->subcribe = $data['subcribe'];
		$this->db->insert('brokers',$this);
		return $this->db->insert_id();
	}
	
	function update_record($data){
		
		$this->db->set('fname',$data['fname']);
		$this->db->set('lname',$data['lname']);
		$this->db->set('phone',$data['phone']);
		$this->db->set('cell',$data['cell']);
		$this->db->set('company',$data['company']);
		$this->db->set('address',$data['address']);
		$this->db->set('cphone',$data['cphone']);
		$this->db->set('cmail',$data['cmail']);
		$this->db->set('website',$data['website']);
		$this->db->set('license',$data['license']);
		$this->db->set('subcribe',$data['subcribe']);
		$this->db->where('id',$data['id']);
		$this->db->update('brokers');
		return $this->db->affected_rows();
	}
}