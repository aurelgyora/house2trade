<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Model{

	var $id				= 0;
	var $class			= 2;
	var $user_id		= 0;
	var $email			= '';
	var $password		= '';
	var $signdate		= '';
	var $temporary_code	= '';

	function __construct(){
		parent::__construct();
		$this->signdate = date("Y-m-d");
	}
	
	function read_record($record_id,$table){
		
		$this->db->select('id,class,user_id,email,status,signdate');
		$query = $this->db->get_where('users',array('id'=>$record_id),1,0);
		$data = $query->result_array();
		if($data) return $data[0];
		return FALSE;
	}
	
	function insert_record($data){

		$this->email 	= $data['email'];
		if(isset($data['password']) && !empty($data['password'])):
			$this->password	= md5($data['password']);
		endif;
		$this->db->insert('users',$this);
		return $this->db->insert_id();
	}
	
	function auth_user($login,$password){
		
		$this->db->select('id,class,user_id,status');
		$this->db->where('email',$login);
		$this->db->where('password',md5($password));
		$this->db->where('temporary_code','');
		$query = $this->db->get('users',1);
		$data = $query->result_array();
		if($data) return $data[0];
		return FALSE;
	}

	function user_exist($field,$parameter){
			
		$this->db->where($field,$parameter);
		$query = $this->db->get('users',1);
		$data = $query->result_array();
		if(count($data)) return $data[0]['id'];
		return FALSE;
	}

	function valid_password($id,$field,$parameter){
			
		$this->db->where('id',$id);
		$this->db->where($field,$parameter);
		$query = $this->db->get('users',1);
		$data = $query->result_array();
		if(count($data)) return $data[0]['id'];
		return FALSE;
	}
	
	function classListByPages($class,$count,$from){
		
		if($class == 2):
			$query = "SELECT users.id AS uid,users.user_id,users.email,users.signdate,users.status,brokers.* FROM users INNER JOIN brokers ON users.user_id = brokers.id WHERE users.class = $class ORDER BY users.signdate DESC,users.id LIMIT $from,$count";
		else:
			$query = "SELECT users.id AS uid,users.user_id,users.email,users.signdate,users.status,owners.* FROM users INNER JOIN owners ON users.user_id = owners.id WHERE users.class = $class ORDER BY users.signdate DESC,users.id LIMIT $from,$count";
		endif;
		$query = $this->db->query($query);
		$data = $query->result_array();
		if(count($data)) return $data;
		return FALSE;
	}

	function countClassList($class){
		
		$this->db->where('class',$class);
		$count = $this->db->count_all_results('users');
		if($count) return $count;
		return 0;
	}
}