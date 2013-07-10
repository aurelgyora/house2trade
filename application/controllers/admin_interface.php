<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_interface extends MY_Controller{
	
	function __construct(){
		
		parent::__construct();
		if(!$this->loginstatus || ($this->account['group'] != 1)):
			redirect('');
		endif;
	}
	
	/******************************************** pages *******************************************************/
	
	public function control_pages(){
		
		if($this->input->post('submit')):
			$update = $this->input->post();
			$this->pages->update_record($update);
			redirect(ADM_START_PAGE.'/pages');
		endif;
		if($this->uri->total_segments() == 3):
			$this->load->view('admin_interface/pages/page-editor',array('page'=>$this->pages->read_record($this->uri->segment(3))));
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
	
	/******************************************* properties ******************************************************/
	
	public function properties(){
		
		$offset = intval($this->uri->segment(4));
		$per_page = 10;
		$this->load->model('properties');
		$pagevar = array(
			'properties_titles' => $this->properties->getAllTitles(),
			'properties' => array(),
			'pagination' => array()
		);
		if($this->input->get('property') === FALSE || !is_numeric($this->input->get('property'))):
			$pagevar['properties'] = $this->properties->read_limit_records($per_page,$offset);
			$pagevar['pagination'] = $this->pagination(ADM_START_PAGE.'/properties',4,$this->properties->countRecords(),$per_page);
		else:
			$pagevar['properties'][0] = $this->properties->read_record($this->input->get('property'),'properties');
			$pagevar['pagination'] = NULL;
		endif;
		if($pagevar['properties']):
			$ids = array();
			for($i=0;$i<count($pagevar['properties']);$i++):
				$ids[] = $pagevar['properties'][$i]['id'];
			endfor;
			$this->load->model('images');
			$mainPhotos = $this->images->mainPhotos($ids);
			$this->load->model('property_type');
			$property_type = $this->property_type->read_records('property_type');
			for($i=0;$i<count($pagevar['properties']);$i++):
				$pagevar['properties'][$i]['photo'] = 'img/thumb.png';
				if($mainPhotos && array_key_exists($pagevar['properties'][$i]['id'],$mainPhotos)):
					$pagevar['properties'][$i]['photo'] = $mainPhotos[$pagevar['properties'][$i]['id']];
				endif;
				for($j=0;$j<count($property_type);$j++):
					if($pagevar['properties'][$i]['type'] == $property_type[$j]['id']):
						$pagevar['properties'][$i]['type'] = $property_type[$j]['title'];
						break;
					endif;
				endfor;
			endfor;
		endif;
		$this->session->set_userdata('backpath',site_url(uri_string()));
		$this->load->view("admin_interface/pages/properties-list",$pagevar);
	}
	
	public function propertyDetail(){
		
		$this->load->model(array('properties','images','union','accounts_owners'));
		$pagevar = array(
			'property' => $this->properties->read_record($this->uri->segment(4),'properties'),
			'images' => $this->images->read_records($this->uri->segment(4))
		);
		if($pagevar['property']['owner']):
			$owner = $this->accounts_owners->read_record($pagevar['property']['owner'],'accounts_owners');
			if($owner):
				$pagevar['property']['phone'] = $owner['phone'];
				$pagevar['property']['cell'] = $owner['cell'];
				$pagevar['property']['email'] = $owner['email'];
			endif;
		endif;
		$this->load->view("admin_interface/pages/property-detail",$pagevar);
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