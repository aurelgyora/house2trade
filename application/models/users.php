<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Model{

	var $id				= 0;
	var $class			= 4;
	var $user_id		= 0;
	var $email			= '';
	var $photo			= '';
	var $thumbnail		= '';
	var $password		= '';
	var $signdate		= '';
	var $active			= 0;
	var $temporary_code	= '';
	var $language		= 1;

	function __construct(){
		parent::__construct();
	}
	
	function read_record($record_id,$table){
		
		$this->db->select('id,class,user_id,email,active,language');
		$query = $this->db->get_where('users',array('id'=>$record_id),1,0);
		$data = $query->result_array();
		if($data) return $data[0];
		return FALSE;
	}
	
	function insert_record($data){

		$this->email 	= $data['email'];
		$this->password	= md5($data['password']);
		$this->signdate = date("Y-m-d");
		
		$this->db->insert('users',$this);
		return $this->db->insert_id();
	}
	
	function update_record($data){
	
		if(isset($data['photo'])):
			$this->db->set('photo',$data['photo']);
			$this->db->set('thumbnail',$data['thumbnail']);
		endif;
		$this->db->set('language',$data['language']);
		$this->db->where('id',$data['id']);
		$this->db->update('users');
		return $this->db->affected_rows();
	}
	
	function set_base_lang($language,$base_lang){

		$this->db->set('language',$base_lang);
		$this->db->where('language',$language);
		$this->db->update('users');
		return $this->db->affected_rows();
	}
	
	function auth_user($login,$password){
		
		$this->db->select('id,class,user_id,active');
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
	
		$this->db->where('class',$class);
		$this->db->order_by('signdate','DESC');
		$this->db->order_by('id','DESC');
		$this->db->limit($count,$from);
		$query = $this->db->get('users');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
	}

	function countClassList($class){
		
		$this->db->where('class',$class);
		$count = $this->db->count_all_results('users');
		if($count) return $count;
		return 0;
	}
}