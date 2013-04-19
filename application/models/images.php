<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Images extends MY_Model{
	
	var $id = 0; var $main = 0; var $property = 0;
	var $photo = '';
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data){
		
		$this->main = $data['main'];
		$this->photo = $data['photo'];
		$this->property = $data['property_id'];
		$this->db->insert('images',$this);
		return $this->db->insert_id();
	}
	
	function read_records($property){
		
		$this->db->select('id,main,photo');
		$this->db->order_by('main','DESC');
		$this->db->order_by('id');
		$this->db->where('property',$property);
		$query = $this->db->get('images');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function mainPhoto($property){
		
		$this->db->select('photo');
		$this->db->where('main',1);
		$this->db->where('property',$property);
		$query = $this->db->get('images');
		$data = $query->result_array();
		if($data) return $data[0]['photo'];
		return '';
	}
	
	function mainPhotos($propertiesID){
		
		$this->db->select('property,photo');
		$this->db->where('main',1);
		$this->db->where_in('property',$propertiesID);
		$query = $this->db->get('images');
		$result = array();
		foreach($query->result() as $row):
			$i = 0; $index = 0;
			foreach($row as $value):
				if(!$i):
					$index = $value;
					$result[$index] = '';
				else:
					$result[$index] = $value;
				endif;
				$i++;
			endforeach;
		endforeach;
		if($result):
			return $result;
		else:
			return NULL;
		endif;
	}
	
	function image_exist($property){
		
		$query = $this->db->get_where('images',array('property'=>$property),1);
		$data = $query->result_array();
		if($data) return TRUE;
		return FALSE;
	}
}