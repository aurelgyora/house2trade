<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_interface extends MY_Controller{
	
	function __construct(){
		
		parent::__construct();
		if(!$this->loginstatus || ($this->account['group'] != 1)):
			redirect('');
		endif;
	}
	
	/******************************************** pages *******************************************************/
	
	public function control_pages($pageName = FALSE){
		
		if($this->input->post('submit')):
			$update = $this->input->post();
			$this->pages->update_record($update);
			redirect(ADM_START_PAGE.'/pages');
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
	
	public function mailsText(){
		
		$this->load->model('mails');
		$pagevar = array(
			'mails'=>$this->mails->read_records('mails'),
			'msgs' => $this->session->userdata('msgs'),
			'msgr' => $this->session->userdata('msgr')
		);
		$this->session->unset_userdata(array('msgr'=>'','msgs'=>''));
		$this->session->set_userdata('backpath',site_url(uri_string()));
		$this->load->view('admin_interface/pages/mails',$pagevar);
	}
	
	public function mailsTextEdit(){
		
		$this->load->model('mails');
		$this->load->helper('file');
		if($this->input->post('submit')):
			$update = $this->input->post();
			$update['id'] = $this->uri->segment(5);
			$this->mails->update_record($update);
			$content = 'application/views/'.$this->mails->read_field($update['id'],'mails','file_path').'.php';
			write_file($content,$update['content']);
			$this->session->set_userdata('msgs','Text mail saved');
			redirect(ADM_START_PAGE.'/mails');
		endif;
		$pagevar = array('mail'=>$this->mails->read_record($this->uri->segment(5),'mails'));
		$pagevar['mail']['content'] = read_file('application/views/'.$pagevar['mail']['file_path'].'.php');
		$this->load->view('admin_interface/pages/edit-mail',$pagevar);
	}
	
	/******************************************** cabinet *******************************************************/
	
	public function control_panel(){
		
		$this->load->view("admin_interface/pages/control-panel");
	}
	
	public function profile(){
		
		$this->load->view("admin_interface/pages/profile");
	}
	
	/********************************************* company ******************************************************/
	
	public function companies(){
		
		$from = intval($this->uri->segment(4));
		$per_page = 10;
		$this->load->model('company');
		$pagevar = array(
			'company' => $this->company->read_limit_records($per_page,$from,'company','title','ASC'),
			'pages' => $this->pagination('administrator/compnies',4,$this->company->count_records('company'),$per_page),
		);
		$this->session->set_userdata('backpath',site_url(uri_string()));
		$this->load->view("admin_interface/company/list",$pagevar);
	}
	
	public function insertCompany(){
		
		if($this->input->post('submit')):
			$this->load->library('form_validation');
			$this->form_validation->set_rules('title','','required|trim|xss_clean');
			$this->form_validation->set_rules('phone','','required|trim|xss_clean');
			$this->form_validation->set_rules('email','','required|trim|valid_email|xss_clean');
			$this->form_validation->set_rules('website','','required|trim|xss_clean');
			$this->form_validation->set_rules('address1','','required|trim|xss_clean');
			$this->form_validation->set_rules('address2','','trim|xss_clean');
			$this->form_validation->set_rules('city','','required|trim|xss_clean');
			$this->form_validation->set_rules('state','','required|trim|xss_clean');
			$this->form_validation->set_rules('zip_code','','required|trim|xss_clean');
			if($this->form_validation->run()):
				unset($_POST['submit']);
				$this->load->model('company');
				if(isset($_POST['id'])):
					$this->company->update_record($_POST);
					$id = $_POST['id'];
				else:
					$id = $this->company->insert_record($_POST);
				endif;
				if(isset($_FILES['logo'])):
					if($_FILES['logo']['error'] != 4):
						$photo = file_get_contents($_FILES['logo']['tmp_name']);
						if($photo && isset($id)):
							$this->company->update_field($id,'logo',$photo,'company');
						endif;
					endif;
				endif;
			else:
				show_error(validation_errors());
			endif;
			redirect('administrator/companies');
		endif;
		
		$this->load->view("admin_interface/company/manage");
	}
	
	public function editCompany(){
		
		$this->load->model('company');
		$pagevar = array('company'=>$this->company->read_record($this->uri->segment(4),'company'));
		$this->load->view("admin_interface/company/manage",$pagevar);
	}
	
	public function deleteCompany(){
		
		if($this->uri->segment(4)):
			$this->load->model('company');
			$this->company->delete_record($this->uri->segment(4),'company');
		endif;
		redirect('administrator/companies');
	}
	
	/********************************************* users ********************************************************/
	
	public function control_accounts(){
		
		$from = intval($this->uri->segment(5));
		$per_page = 10;
		$this->load->model('users_group');
		$group = $this->users_group->getClassID($this->uri->segment(2));
		$pagevar = array(
			'users' => $this->users->classListByPages($group,$per_page,$from),
			'pages' => $this->pagination('administrator/'.$this->uri->segment(2).'/accounts',5,$this->users->countClassList($group),$per_page),
			'msgs' => $this->session->userdata('msgs'),
			'msgr' => $this->session->userdata('msgr')
		);
		$this->session->unset_userdata(array('msgr'=>'','msgs'=>''));
		$pagevar['users'] = $this->setActiveUsers($pagevar['users']); //добавляет поле online
		$this->session->set_userdata('backpath',site_url(uri_string()));
		$this->load->view("admin_interface/pages/accounts-list",$pagevar);
	}
	
	public function account_profile(){
		
		$pagevar = array(
			'profile' => $this->users->read_record($this->uri->segment(3),'users'),
			'msgs' => $this->session->userdata('msgs'),
			'msgr' => $this->session->userdata('msgr')
		);
		$this->session->unset_userdata(array('msgr'=>'','msgs'=>''));
		$pagevar['profile']['info'] = $this->account_information($pagevar['profile']['account'],$pagevar['profile']['group']);
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