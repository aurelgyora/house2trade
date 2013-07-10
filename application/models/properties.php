<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Properties extends MY_Model{
	
	var $id = 0; var $broker = 0; var $owner = 0; var $zip_code = 0; var $bathrooms = 0; var $bedrooms = 0; var $tax = 0; var $mls = 0;
	var $address1 = ''; var $address2 = ''; var $city = ''; var $state = ''; var $type = ''; var $sqf = ''; var $description = ''; var $lotsize = '';
	var $price = 0.00; var $bank_price = 0.00;
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data){
		
		if($this->loginstatus && ($this->account['group'] == 2)):
			$this->broker = $this->account['id'];
		endif;
		$this->owner = $data['user_id'];
		if(isset($data['state']) && isset($data['zip_code'])):
			$this->zip_code = trim($data['zip_code']);
			$this->bathrooms = trim($data['bathrooms']);
			$this->bedrooms = trim($data['bedrooms']);
			$this->tax = trim($data['tax']);
			$this->mls = trim($data['mls']);
			$this->address1 = trim($data['address1']);
			$this->address2 = trim($data['address2']);
			$this->city = trim($data['city']);
			$this->state = trim($data['state']);
			$this->type = trim($data['type']);
			$this->sqf = trim($data['sqf']);
			$this->description = $data['description'];
			$this->price = $data['price'];
			$this->lotsize = $data['lotsize'];
			$this->bank_price = $data['bank_price'];
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
		$this->db->set('lotsize',$data['lotsize']);
		$this->db->set('bank_price',$data['bank_price']);
		
		$this->db->where('id',$id);
		$this->db->update('properties');
		return $this->db->affected_rows();
	}
	
	function read_records($owner = NULL,$broker = NULL,$orderBy = 'properties.zip_code,properties.state,properties.address1'){
		
		if(!is_null($owner)):
			$this->db->where('owner',$owner);
		endif;
		if(!is_null($broker)):
			$this->db->where('broker',$broker);
		endif;
		if(!is_null($orderBy)):
			$this->db->order_by($orderBy);
		endif;
		$this->db->where('status <',17);
		$query = $this->db->get('properties');
		$data = $query->result_array();
		if(!empty($data)):
			return $data;
		endif;
		return NULL;
	}

	function properties_exits($state,$zip_code,$address = NULL){
		
		$this->db->where('state',$state);
		$this->db->where('zip_code',$zip_code);
		if(!is_null($address)):
			$this->db->where('md5(address1)',md5($address));
		endif;
		$query = $this->db->get('properties',1);
		$data = $query->result_array();
		if($data) return $data[0]['id'];
		return FALSE;
	}
	
	function csvPropertiesExits($address,$state,$zip_code){
		
		$this->db->where('address1',trim($address));
		$this->db->where('state',trim($state));
		$this->db->where('zip_code',trim($zip_code));
		$query = $this->db->get('properties',1);
		$data = $query->result_array();
		if($data) return $data[0]['id'];
		return FALSE;
	}
	
	function read_limit_records($count,$from){
		
		if($this->account['group'] == 2):
			$this->db->where('broker',$this->account['id']);
		elseif($this->account['group'] == 3):
			$this->db->where('owner',$this->account['id']);
		endif;
		$this->db->order_by('address1,state,zip_code');
		$this->db->limit($count,$from);
		$query = $this->db->get('properties');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}
	
	function countRecords($group = NULL){
		
		if(!is_null($group)):
			switch($group):
				case 2: $this->db->where('broker',$this->account['id']); break;
				case 3: $this->db->where('owner',$this->account['id']); break;
			endswitch;
		endif;
		$this->db->from('properties');
		return $this->db->count_all_results();
	}

	function getPropertiesWhereIN($IDs){
		
		$this->db->select('properties.*,property_type.title AS type,images.photo',FALSE);
		$this->db->from('properties');
		$this->db->join('property_type','properties.type = property_type.id','left');
		$this->db->join('images','properties.id = images.property','left');
		$this->db->where_in('properties.id',$IDs);
//		$this->db->where('images.main',1);
		$this->db->where('properties.status <',17);
		$this->db->group_by('properties.id');
		$query = $this->db->get();
		$data = $query->result_array();
		if(!empty($data)):
			$propertiesInfoList = array();
			for($i=0;$i<count($IDs);$i++):
				for($j=0;$j<count($data);$j++):
					if($IDs[$i] == $data[$j]['id']):
						$propertiesInfoList[] = $data[$j];
					endif;
				endfor;
			endfor;
			return $propertiesInfoList;
		else:
			return NULL;
		endif;
	}
	
	function changeStatusOfManyProperties($owner = NULL,$status = 0){
		
		if(!is_null($owner)):
			$this->db->where('owner',$owner);
			$this->db->set('status',$status);
			$this->db->update('properties');
			return $this->db->affected_rows();
		else:
			FALSE;
		endif;
	}

	function getAllTitles(){
		
		$this->db->select('id,address1,city,state',FALSE);
		$this->db->order_by('address1,city,state');
		$query = $this->db->get('properties');
		$data = $query->result_array();
		if(!empty($data)):
			return $data;
		else:
			return NULL;
		endif;
	}
}