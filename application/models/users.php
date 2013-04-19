<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Model{
	
	var $id = 0; var $group = 2; var $account = 0; var $code_life = 0;
	var $email = ''; var $password = ''; var $signdate = ''; var $temporary_code = '';

	function __construct(){
		
		parent::__construct();
	}
	
	function read_record($id){
		
		$this->db->select('id,group,account,email,status,signdate');
		$query = $this->db->get_where('users',array('id'=>$id),1);
		$data = $query->result_array();
		if($data) return $data[0];
		return FALSE;
	}
	
	function insert_record($data){

		$this->email = $data['email'];
		if(isset($data['password']) && !empty($data['password'])):
			$this->password = md5($data['password']);
		endif;
		$this->db->insert('users',$this);
		return $this->db->insert_id();
	}
	
	function signIN($login,$password){
		
		$this->db->select('id,group,account,status');
		$query = $this->db->get_where('users',array('email'=>$login,'password'=>md5($password)),1);
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
	
	function valid_code($code){
		
		$this->db->where('temporary_code',$code);
		$this->db->where('code_life >=',now());
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