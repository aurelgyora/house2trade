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
		
		$query = "SELECT properties.*,property_favorite.id AS fid FROM properties,property_favorite WHERE properties.id = property_favorite.buyer_id AND property_favorite.seller_id = $seller ORDER BY properties.address1,properties.state,properties.zip_code LIMIT $from,$count";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if($data) return $data;
		return NULL;
	}
	
	function potentialByList($owner,$count,$from){
		
		$query = "SELECT users.id AS uid,users.email,users.status,owners.id AS oid,owners.fname,owners.lname,properties.*,property_potentialby.id AS pbid FROM 	users,owners,properties,property_potentialby WHERE users.user_id = owners.id AND users.id = properties.owner_id AND properties.id = property_potentialby.property AND property_potentialby.owner = $owner ORDER BY users.signdate DESC,users.id LIMIT $from,$count";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if($data) return $data;
		return NULL;
	}
	
	function ownerPropertiesList($count,$from){
		
		$query = "SELECT users.id AS uid,users.email,users.status,owners.id AS oid,owners.fname,owners.lname,properties.* FROM users INNER JOIN owners ON users.user_id = owners.id INNER JOIN properties ON users.id = properties.owner_id WHERE users.class = ".$this->user['class']." AND properties.owner_id = ".$this->user['uid']." ORDER BY users.signdate DESC,users.id LIMIT $from,$count";
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
	
	/*****************************************************************************************************************/
}