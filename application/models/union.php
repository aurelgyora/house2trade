<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Union extends CI_Model{

	function __construct(){
		parent::__construct();
	}
	
	/********************************************* users lists ********************************************************/
	
	function propertiesListByPages($class,$broker,$count,$from){
		
		$query = "SELECT users.id AS uid,users.email,users.status,properties.* FROM users INNER JOIN properties ON users.user_id = properties.id WHERE users.class = $class AND properties.broker_id = $broker ORDER BY users.signdate DESC,users.id LIMIT $from,$count";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if($data) return $data;
		return FALSE;
	}
	
	/*****************************************************************************************************************/
}