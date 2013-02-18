<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Broker_interface extends MY_Controller{
	
	function __construct(){
		
		parent::__construct();
		if(!$this->loginstatus || ($this->user['class'] != 2)):
			redirect('');
		endif;
	}
	
	/******************************************** cabinet *******************************************************/
	
	public function control_panel(){
		
		$this->load->view("broker_interface/pages/control-panel");
	}
	
	public function register_properties(){
		
		$this->load->view("broker_interface/pages/properties");
	}
	
	public function profile(){
		
		$this->load->model('brokers');
		$pagevar = array('profile' => $this->users->read_record($this->user['uid'],'users'));
		$pagevar['profile']['info'] = $this->brokers->read_record($pagevar['profile']['user_id'],'brokers');
		$this->load->view("broker_interface/pages/profile",$pagevar);
	}
	
	/********************************************* users ********************************************************/
	
	public function control_accounts(){
		
		$this->load->model('properties');
		$this->load->model('union');
		$from = (int)$this->uri->segment(4);
		$pagevar = array(
			'properties' => $this->union->propertiesListByPages(3,$this->user['uid'],10,$from),
			'pages' => $this->pagination('broker/control-panel/',5,$this->properties->count_records('properties','broker_id',$this->user['uid']),10)
		);
		$this->load->view("broker_interface/pages/accounts",$pagevar);
	}
	
	public function account_profile(){
		
		$pagevar = array(
			'profile' => $this->users->read_record($this->uri->segment(4),'users'),
			'msgs' => $this->session->userdata('msgs'),
			'msgr' => $this->session->userdata('msgr')
		);
		$this->session->unset_userdata(array('msgr'=>'','msgs'=>''));
		$pagevar['profile']['info'] = $this->account_information($pagevar['profile']['user_id'],$pagevar['profile']['class']);
		$this->load->view("broker_interface/pages/account-profile",$pagevar);
	}
}