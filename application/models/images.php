<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Images extends MY_Model{
	
	var $id = 0; 
	var $main = 0;
	var $photo = '';
	var $property_id = 0;
	var $owner_id = 0;
	var $broker_id = 0;
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data){
		
		$this->main = $data['main'];
		$this->photo = $data['photo'];
		$this->property_id = $data['property_id'];
		$this->owner_id = $data['owner_id'];
		if($this->user['class'] == 2):
			$this->broker_id = $this->user['uid'];
		else:
			$this->broker_id = $data['broker_id'];
		endif;
		$this->db->insert('images',$this);
		return $this->db->insert_id();
	}
	
	function read_records($property){
		
		$this->db->select('id,main,photo');
		$this->db->order_by('main','DESC');
		$this->db->order_by('id');
		$this->db->where('property_id',$property);
		$query = $this->db->get('images');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function mainPhoto($property){
		
		$this->db->select('photo');
		$this->db->where('main',1);
		$this->db->where('property_id',$property);
		$query = $this->db->get('images');
		$data = $query->result_array();
		if($data) return $data[0]['photo'];
		return '';
	}
	
	function image_exist($property){
		
		$query = $this->db->get_where('images',array('property_id'=>$property),1);
		$data = $query->result_array();
		if($data) return TRUE;
		return FALSE;
	}
}