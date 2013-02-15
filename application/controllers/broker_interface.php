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
		
		$this->load->model('properties');
		$pagevar = array(
			'properties' => $this->properties->read_records($this->user['uid'])
		);
		$this->load->view("broker_interface/pages/control-panel",$pagevar);
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
		
		$from = intval($this->uri->segment(5));
		$per_page = 10;
		$this->load->helper('smiley');
		$this->load->library('table');
		$image_array = get_clickable_smileys(base_url('img/smileys/'),'text-send-message');
		$col_array = $this->table->make_columns($image_array,8);
		$pagevar = array(
			'smiley_table' => $this->table->generate($col_array),
			'users' => $this->mdusers->classListByPages(1,$per_page,$from),
			'pages' => $this->pagination('admin-panel/actions/users-list',5,$this->mdusers->countClassList(1),$per_page),
			'msgs' => $this->session->userdata('msgs'),
			'msgr' => $this->session->userdata('msgr')
		);
		$this->session->unset_userdata(array('msgr'=>'','msgs'=>''));
		$pagevar['users'] = $this->setActiveUsers($pagevar['users']); //добавляет поле online
		$this->session->set_userdata('backpath',base_url().$this->uri->uri_string());
		$this->load->view("admin_interface/lists/users/administrators",$pagevar);
	}
	
	public function account_profile(){
		
		
		$pagevar = array('profile' => $this->users->read_record($this->uri->segment(3),'users'));
		$pagevar['profile']['info'] = $this->account_information($pagevar['profile']['user_id'],$pagevar['profile']['class']);
		$this->load->view("admin_interface/lists/users/account-profile",$pagevar);
	}
	
	public function user_delete(){
		
		$id = $this->uri->segment(6);
		if($id):
			$result = $this->mdusers->delete_record($id,'users');
			$this->session->set_userdata('msgs','User deleted successfully.');
			redirect($this->session->userdata('backpath'));
		else:
			show_404();
		endif;
	}
}