<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Property_potentialby extends MY_Model{

	var $id = 0; var $down_payment = 0;
	var $seller_id = ''; var $buyer_id = '';

	function __construct(){
		parent::__construct();
	}
	
	function insert_record($data){
		
		$this->seller_id = $data['seller_id'];
		$this->buyer_id = $data['buyer_id'];
		if(isset($data['down_payment'])):
			$this->down_payment = $data['down_payment'];
		endif;
		$this->db->insert('property_potentialby',$this);
		return $this->db->insert_id();
	}
	
	function record_exist($seller_id,$buyer_id){
		
		$this->db->where_in('seller_id',$seller_id);
		$this->db->where_in('buyer_id',$buyer_id);
		$query = $this->db->get('property_potentialby',1);
		$data = $query->result_array();
		if(count($data)) return $data[0]['id'];
		return FALSE;
	}
	
	function record_exists($seller_id = NULL,$buyer_id = NULL){
		
		$this->db->select('buyer_id');
		if(!is_null($seller_id)):
			$this->db->where_in('seller_id',$seller_id);
		endif;
		if(!is_null($buyer_id)):
			$this->db->where_in('buyer_id',$buyer_id);
		endif;
		$query = $this->db->get('property_potentialby');
		$result = array();
		foreach($query->result() as $row):
			foreach($row as $value):
				$result[$value] = TRUE;
			endforeach;
		endforeach;
		if($result):
			return $result;
		else:
			return NULL;
		endif;
	}
	
	function instantTradeLeveL2($currentProperty){
		
		$this->db->select('properties.*');
		$this->db->distinct();
		$this->db->from('property_potentialby');
		$this->db->join('properties','properties.id = property_potentialby.seller_id');
		$this->db->where('property_potentialby.buyer_id',$currentProperty);
		$this->db->where('property_potentialby.seller_id !=',$currentProperty);
		$this->db->order_by('properties.address1');
		$query = $this->db->get();
		$data = $query->result_array();
		if($data) return $data;
		return NULL;
	}
	
	function instantTradeLeveLs($currentProperty,$propertiesID){
		
		$this->db->select('properties.*');
		$this->db->distinct();
		$this->db->from('property_potentialby');
		$this->db->join('properties','properties.id = property_potentialby.seller_id');
		$this->db->where_in('property_potentialby.buyer_id',$propertiesID);
		$this->db->where('property_potentialby.seller_id !=',$currentProperty);
		$this->db->order_by('properties.address1');
		$query = $this->db->get();
		$data = $query->result_array();
		if($data) return $data;
		return NULL;
	}

	function getDownPaymentsValues($IDs){
		
		if(!empty($IDs)):
			for($i=0;$i<count($IDs)-1;$i++):
				$this->db->or_where('seller_id = '.$IDs[$i].' AND buyer_id = '.$IDs[$i+1]);
			endfor;
			$this->db->or_where('seller_id = '.$IDs[count($IDs)-1].' AND buyer_id = '.$IDs[0]);
			$query = $this->db->get('property_potentialby');
			$data = $query->result_array();
			if(!empty($data)):
				return $data;
			endif;
		endif;
		return NULL;
	}
	
	function getDownPaymentValue($sellerID,$buyerID){
		
		$this->db->where('seller_id',$sellerID);
		$this->db->where('buyer_id',$buyerID);
		$query = $this->db->get('property_potentialby');
		$data = $query->result_array();
		if(!empty($data)):
			return $data[0]['id'];
		endif;
		return NULL;
	}
	
	function getPropertiesIDs($sellerID,$fields = 'buyer_id'){
		
		$this->db->select($fields);
		$this->db->where('seller_id',$sellerID);
		$query = $this->db->get('property_potentialby');
		$data = $query->result_array();
		if(!empty($data)):
			$ids = array();
			for($i=0;$i<count($data);$i++):
				$ids[] = $data[$i][$fields];
			endfor;
			return $ids;
		endif;
		return NULL;
	}
	
}