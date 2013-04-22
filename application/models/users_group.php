<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Users_group extends MY_Model{

	var $id		 = 0;
	var $title	 = '';
	var $comment = '';

	function __construct(){
		parent::__construct();
	}
	
	function getClassID($translit){
			
		$query = $this->db->get_where('users_group',array('translit'=>$translit),1);
		$data = $query->result_array();
		if($data) return $data[0]['id'];
		return FALSE;
	}
	
}