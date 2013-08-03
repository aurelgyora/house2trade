<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Match extends MY_Model{

	function __construct(){
		parent::__construct();
	}
	
	function parseMatchPropertyID($property){
		
		$querySting = "SELECT * FROM `match` WHERE (`status` < 2) AND (`property_id1` = $property OR `property_id2` = $property OR `property_id3` = $property OR `property_id4` = $property OR`property_id5` = $property OR`property_id6` = $property) LIMIT 1";
		$query = $this->db->query($querySting);
		$data = $query->result_array();
		if(!empty($data)) return $data[0];
		return NULL;
	}
	function getWaitingMatches($status = 0){
		
		$querySting = "SELECT * FROM `match` WHERE (`status` = $status) AND (`mailing_date` IS NULL OR `mailing_date` < NOW())";
		$query = $this->db->query($querySting);
		if($data = $query->result_array()):
			return $data;
		endif;
		return NULL;
	}
}