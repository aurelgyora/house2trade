<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mails extends MY_Model{
	
	var $id = 0;
	var $subject = '';
	var $file_path = '';
	
	function __construct(){
		parent::__construct();
	}
	
	function update_record($data){

		$this->db->set('subject',$data['subject']);
		$this->db->where('id',$data['id']);
		$this->db->update('mails');
		return $this->db->affected_rows();
	}
	
}