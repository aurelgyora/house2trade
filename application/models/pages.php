<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends MY_Model{
	
	var $id   		= 0;
	var $title 		= '';
	var $content	= '';
	var $url		= '';
	
	function __construct(){
		parent::__construct();
	}
	
	function update_record($data){

		$this->db->set('content',$data['content']);
		$this->db->where('id',$data['id']);
		$this->db->update('pages');
		return $this->db->affected_rows();
	}
	
	function read_fields_url($url,$fields,$language){
			
		$this->db->select($fields);
		$this->db->where('url',$url);
		$this->db->where('language',$language);
		$query = $this->db->get('pages',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}

	function read_record($pageUrl){
		
		$query = $this->db->get_where('pages',array('url'=>$pageUrl),1);
		$data = $query->result_array();
		if($data) return $data[0];
		return NULL;
	}
}