<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Owner_interface extends MY_Controller{
	
	function __construct(){
		
		parent::__construct();
		if(!$this->loginstatus || ($this->user['class'] != 3)):
			redirect('');
		endif;
		$password = $this->users->read_field($this->user['uid'],'users','password');
		if(empty($password) && ($this->uri->segment(2) != 'set-password')):
			redirect('homeowner/set-password');
		endif;
	}
	
	/******************************************** cabinet *******************************************************/
	
	public function setPassword(){
		
		$password = $this->users->read_field($this->user['uid'],'users','password');
		if(!empty($password)):
			redirect('broker/control-panel');
		endif;
		$this->load->view("owner_interface/pages/set-password");
	}
	
	public function control_panel(){
		
		$this->load->view("owner_interface/pages/control-panel");
	}
	
	public function profile(){
		
		$this->load->model('properties');
		$pagevar = array('profile' => $this->users->read_record($this->user['uid'],'users'));
		$pagevar['profile']['info'] = $this->properties->read_record($pagevar['profile']['user_id'],'properties');
		$this->load->view("owner_interface/pages/profile",$pagevar);
	}
	
}