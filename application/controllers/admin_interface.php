<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_interface extends MY_Controller{
	
	function __construct(){
		
		parent::__construct();
		if(!$this->loginstatus || ($this->user['class'] != 1)):
			redirect('');
		endif;
	}
	
	/******************************************** pages *******************************************************/
	
	public function control_pages($pageName = FALSE){
		
		if($this->input->post('submit')):
			$update = $this->input->post();
			$this->pages->update_record($update);
			redirect('administrator/control-panel/pages');
		endif;
		
		if($this->uri->segment(4)):
			$pageName = $this->uri->segment(4);
		endif;
		if($pageName):
			$this->load->view('admin_interface/pages/page-editor',array('page'=>$this->pages->read_record($pageName)));
		else:
			$this->load->view('admin_interface/pages/list-site-pages',array('pages'=>$this->pages->read_records('pages','title','ASC')));
		endif;
	}
	
	/******************************************** cabinet *******************************************************/
	
	public function control_panel(){
		
		$this->load->view("admin_interface/pages/control-panel");
	}
	
	public function profile(){
		
		$this->load->view("admin_interface/pages/profile");
	}
	
	/********************************************* users ********************************************************/
	
	public function control_accounts(){
		
		$from = intval($this->uri->segment(5));
		$per_page = 10;
		$this->load->model('usersclass');
		$class = $this->usersclass->getClassID($this->uri->segment(2));
		$pagevar = array(
			'users' => $this->users->classListByPages($class,$per_page,$from),
			'pages' => $this->pagination('administrator/brokers/accounts',5,$this->users->countClassList($class),$per_page),
			'msgs' => $this->session->userdata('msgs'),
			'msgr' => $this->session->userdata('msgr')
		);
		$this->session->unset_userdata(array('msgr'=>'','msgs'=>''));
		$pagevar['users'] = $this->setActiveUsers($pagevar['users']); //добавляет поле online
		$this->session->set_userdata('backpath',base_url().$this->uri->uri_string());
		$this->load->view("admin_interface/pages/accounts-list",$pagevar);
	}
	
	public function account_profile(){
		
		$pagevar = array(
			'profile' => $this->users->read_record($this->uri->segment(3),'users'),
			'msgs' => $this->session->userdata('msgs'),
			'msgr' => $this->session->userdata('msgr')
		);
		$this->session->unset_userdata(array('msgr'=>'','msgs'=>''));
		$pagevar['profile']['info'] = $this->account_information($pagevar['profile']['user_id'],$pagevar['profile']['class']);
		$this->load->view("admin_interface/pages/account-profile",$pagevar);
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