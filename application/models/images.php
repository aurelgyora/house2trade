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
	
	function read_records($property,$broker = FALSE){
		
		$this->db->select('id,main,photo');
		$this->db->order_by('main','DESC');
		$this->db->order_by('id');
		$this->db->where('property_id',$property);
		if($broker):
			$this->db->where('broker_id',$broker);
		endif;
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
	
	function mainPhotos($propertiesID){
		
		$this->db->select('property_id,photo');
		$this->db->where('main',1);
		$this->db->where_in('property_id',$propertiesID);
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
		
		$query = $this->db->get_where('images',array('property_id'=>$property),1);
		$data = $query->result_array();
		if($data) return TRUE;
		return FALSE;
	}
	
	function delete_records($property,$broker = FALSE){
	
		$this->db->where('property_id',$property);
		if($broker):
			$this->db->where('broker_id',$broker);
		endif;
		$this->db->delete('images');
		return $this->db->affected_rows();
	}
}