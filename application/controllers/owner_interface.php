<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Owner_interface extends MY_Controller{
	
	function __construct(){
		
		parent::__construct();
		if(!$this->loginstatus || ($this->user['class'] != 3)):
			redirect('');
		endif;
	}
	
	/******************************************** cabinet *******************************************************/
	
	public function control_panel(){
		
		$pagevar = array(
			
		);
		
		$this->load->view("owner_interface/pages/control-panel",$pagevar);
	}
	
	public function profile(){
		
		$this->load->model('properties');
		$pagevar = array('profile' => $this->users->read_record($this->user['uid'],'users'));
		$pagevar['profile']['info'] = $this->properties->read_record($pagevar['profile']['user_id'],'properties');
		$this->load->view("owner_interface/pages/profile",$pagevar);
	}
	
}