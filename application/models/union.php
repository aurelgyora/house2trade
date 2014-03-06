<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Union extends CI_Model{

	function __construct(){
		parent::__construct();
	}
	
	/********************************************* accounts lists ********************************************************/
	
	function ownersList($broker){
		
		$query = "SELECT users.id AS uid,users.email,owners.id AS oid,owners.fname,owners.lname,properties.id,properties.address1,properties.price FROM users INNER JOIN owners ON users.user_id = owners.id INNER JOIN properties ON users.id = properties.owner_id WHERE properties.broker_id = $broker ORDER BY owners.fname,owners.lname,users.id";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if($data) return $data;
		return NULL;
	}
	
	function favoriteList($seller,$count,$from){
		
		if($seller == FALSE):
			return NULL;
		endif;
		
		$query = "SELECT properties.*,property_favorite.id AS fid FROM properties,property_favorite WHERE properties.id = property_favorite.buyer_id AND property_favorite.seller_id = $seller ORDER BY properties.address1,properties.state,properties.zip_code LIMIT $from,$count";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if($data) return $data;
		return NULL;
	}
	
	function potentialByList($seller,$count,$from){
		
		if($seller == FALSE):
			return NULL;
		endif;
		
		$query = "SELECT properties.*,property_potentialby.id AS pbid FROM properties,property_potentialby WHERE properties.id = property_potentialby.buyer_id AND property_potentialby.seller_id = $seller ORDER BY properties.address1,properties.state,properties.zip_code LIMIT $from,$count";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if($data) return $data;
		return NULL;
	}
	
	function selectBrokerProperties($broker){
		
		$query = "select properties.id,properties.type,properties.address1,properties.city,properties.state,properties.zip_code,properties.price,users.email,owners.fname,owners.lname FROM properties,users,owners WHERE properties.broker = $broker AND properties.owner = users.id AND users.account = owners.id ORDER BY properties.zip_code,properties.state,properties.address1";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if($data) return $data;
		return NULL;
	}
	
	function selectOwnerProperties($owner){
		
		$query = "select properties.id,properties.type,properties.address1,properties.city,properties.state,properties.zip_code,properties.price,users.email,owners.fname,owners.lname FROM properties,users,owners WHERE properties.owner = $owner AND properties.owner = users.id AND users.account = owners.id ORDER BY properties.zip_code,properties.state,properties.address1";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if($data) return $data;
		return NULL;
	}
	
	function getOwnersAndPropertiesInformationByIDs($propertiesIDs,$multi = FALSE){
		
		$this->db->select('accounts_owners.id AS account,accounts_owners.email,accounts_owners.fname,accounts_owners.lname,properties.address1,properties.city,properties.state,properties.zip_code');
		$this->db->from('accounts_owners');
		$this->db->join('properties','accounts_owners.id = properties.owner');
		if($multi == TRUE):
			$this->db->where_in('properties.id',$propertiesIDs);
		else:
			$this->db->where('properties.id',$propertiesIDs);
		endif;
		$query = $this->db->get();
		$data = $query->result_array();
		if(!empty($data)):
			if($multi == FALSE):
				return $data[0];
			else:
				return $data;
			endif;
		endif;
		return NULL;
	}
	
	function getBrokersAndPropertiesInformationByIDs($propertiesIDs,$multi = FALSE){
		
		$this->db->select('accounts_brokers.id AS account,accounts_brokers.email,accounts_brokers.fname,accounts_brokers.lname,properties.address1,properties.city,properties.state,properties.zip_code');
		$this->db->from('accounts_brokers');
		$this->db->join('properties','accounts_brokers.id = properties.broker');
		if($multi == TRUE):
			$this->db->where_in('properties.id',$propertiesIDs);
		else:
			$this->db->where('properties.id',$propertiesIDs);
		endif;
		$query = $this->db->get();
		$data = $query->result_array();
		if(!empty($data)):
			if($multi == FALSE):
				return $data[0];
			else:
				return $data;
			endif;
		endif;
		return NULL;
	}
	
	/*****************************************************************************************************************/
	
	function recommendedList($searchData,$count,$from){
		
		$sql = 'SELECT properties.* FROM properties WHERE TRUE';
		$sql .= ' AND properties.state LIKE "%'.$searchData['state'].'%" AND properties.city LIKE "%'.$searchData['city'].'%" AND properties.zip_code LIKE "%'.$searchData['zip_code'].'%"';
		if(!empty($searchData['bedrooms'])):
			$sql .= ' AND properties.bedrooms = '.$searchData['bedrooms'];
		endif;
		if(!empty($searchData['bathrooms'])):
			$sql .= ' AND properties.bathrooms = '.$searchData['bathrooms'];
		endif;
		if(!empty($searchData['max_price'])):
			$sql .= ' AND properties.price <= '.$searchData['max_price'];
		endif;
		if(!empty($searchData['type'])):
			$sql .= ' AND properties.type = '.$searchData['type'];
		endif;
		$sql .= " ORDER BY properties.address1 ASC, properties.state ASC, properties.zip_code ASC LIMIT $from,$count";
		$result = $this->db->query($sql);
		if($data = $result->result_array()):
			return $data;
		endif;
		return NULL;
	}
	
	function recommendedCount($searchData){
		
		$sql = 'SELECT COUNT(*) AS cnt_properties FROM properties WHERE TRUE';
		$sql .= ' AND properties.state LIKE "%'.$searchData['state'].'%" AND properties.city LIKE "%'.$searchData['city'].'%" AND properties.zip_code LIKE "%'.$searchData['zip_code'].'%"';
		if(!empty($searchData['bedrooms'])):
			$sql .= ' AND properties.bedrooms = '.$searchData['bedrooms'];
		endif;
		if(!empty($searchData['bathrooms'])):
			$sql .= ' AND properties.bathrooms = '.$searchData['bathrooms'];
		endif;
		if(!empty($searchData['max_price'])):
			$sql .= ' AND properties.price <= '.$searchData['max_price'];
		endif;
		if(!empty($searchData['type'])):
			$sql .= ' AND properties.type = '.$searchData['type'];
		endif;
		$result = $this->db->query($sql);
		if($data = $result->result_array()):
			return $data[0]['cnt_properties'];
		endif;
		return 0;
	}
	
	/*****************************************************************************************************************/
}