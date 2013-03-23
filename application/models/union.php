<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Union extends CI_Model{

	function __construct(){
		parent::__construct();
	}
	
	/********************************************* accounts lists ********************************************************/
	
	function brokerPropertiesList($class,$broker,$count,$from){
		
		$query = "SELECT users.id AS uid,users.email,users.status,owners.id AS oid,owners.fname,owners.lname,properties.* FROM users INNER JOIN owners ON users.user_id = owners.id INNER JOIN properties ON users.id = properties.owner_id WHERE users.class = $class AND properties.broker_id = $broker ORDER BY users.signdate DESC,users.id LIMIT $from,$count";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if($data) return $data;
		return NULL;
	}
	
	function brokerFavoriteList($class,$owner,$count,$from){
		
		$query = "SELECT users.id AS uid,users.email,users.status,owners.id AS oid,owners.fname,owners.lname,properties.*,property_favorite.id AS fid FROM 	users,owners,properties,property_favorite WHERE users.class = $class AND users.user_id = owners.id AND users.id = properties.owner_id AND properties.id = property_favorite.property AND property_favorite.owner = $owner ORDER BY users.signdate DESC,users.id LIMIT $from,$count";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if($data) return $data;
		return NULL;
	}
	function brokerPotentialList($class,$owner,$count,$from){
		
		$query = "SELECT users.id AS uid,users.email,users.status,owners.id AS oid,owners.fname,owners.lname,properties.*,property_potentialby.id AS pbid FROM 	users,owners,properties,property_potentialby WHERE users.class = $class AND users.user_id = owners.id AND users.id = properties.owner_id AND properties.id = property_potentialby.property AND property_potentialby.owner = $owner ORDER BY users.signdate DESC,users.id LIMIT $from,$count";
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
	
	function brokerProperties($class,$broker){
		
		$query = "SELECT users.id AS uid,users.email,users.status,owners.id AS oid,owners.fname,owners.lname,owners.phone,owners.cell,properties.* FROM users INNER JOIN owners ON users.user_id = owners.id INNER JOIN properties ON users.id = properties.owner_id WHERE users.class = $class AND properties.broker_id = $broker ORDER BY users.signdate DESC,users.id";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if($data) return $data;
		return NULL;
	}
	
	/********************************************* single account ********************************************************/
	
	function propertyInformation($property){
		
		$query = "SELECT users.id AS uid,users.email,users.status,owners.id AS oid,owners.fname,owners.lname,owners.phone,owners.cell,properties.* FROM users INNER JOIN owners ON users.user_id = owners.id INNER JOIN properties ON users.id = properties.owner_id WHERE properties.id = $property ORDER BY properties.id DESC LIMIT 1";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if($data) return $data[0];
		return NULL;
	}
	
	/*****************************************************************************************************************/
}