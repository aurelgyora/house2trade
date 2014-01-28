<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Excluded_properties extends MY_Model{
	
	function __construct(){
		parent::__construct();
	}
	
	function insert_record($propertyID){
		
		$this->db->insert('excluded_properties',array('account'=>$this->account['id'],'property'=>$propertyID));
		return $this->db->insert_id();
	}
}