<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_interface extends MY_Controller{
	
	var $countMessages;
	
	function __construct(){
		
		parent::__construct();
		if(!$this->loginstatus || ($this->user['class'] != 1)):
			redirect('');
		endif;
	}
	
	function validation_parameter(){
		
		$statusval = array('status'=>FALSE);
		$type = trim($this->input->post('type'));
		$parametr = trim($this->input->post('parametr'));
		if(!$type || !$parametr):
			show_404();
		endif;
		switch($type):
			case 'email':
				if(!$this->mdusers->record_exist('users',$type,$parametr)):
					$statusval['status'] = TRUE;
				endif;
				break;
			default: show_404();break;
		endswitch;
		echo json_encode($statusval);
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
		
		if($this->input->post('submit')):
			unset($_POST['submit']);
			$this->form_validation->set_rules('language',' ','required|trim');
			$this->form_validation->set_rules('password',' ','trim');
			$this->form_validation->set_rules('confirm',' ','matches[password]|trim');
			if($this->form_validation->run()):
				$update = $this->input->post();
				if($_FILES['photo']['error'] != 4):
					$this->image_manupulation($_FILES['photo']['tmp_name'],'width',TRUE,200,200);
					$update['photo'] = file_get_contents($_FILES['photo']['tmp_name']);
					$this->image_manupulation($_FILES['photo']['tmp_name'],'width',TRUE,64,64);
					$update['thumbnail'] = file_get_contents($_FILES['photo']['tmp_name']);
				endif;
				$update['id'] = $this->user['uid'];
				$resurl = $this->mdusers->update_record($update);
				if($resurl):
					$this->session->set_userdata('msgs','Профиль сохранен');
				endif;
				redirect($this->uri->uri_string());
			else:
				$this->session->set_userdata('msgr','Ошибка при заполнении полей');
			endif;
		endif;
		$pagevar = array(
			'languages' => $this->mdlanguages->visible_languages(),
			'profile' => $this->mdusers->read_record($this->user['uid'],'users'),
			'msgs' => $this->session->userdata('msgs'),
			'msgr' => $this->session->userdata('msgr')
		);
		$this->session->unset_userdata(array('msgr'=>'','msgs'=>''));
		$this->load->view("admin_interface/cabinet/profile",$pagevar);
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
		
		if($this->input->post('submit')):
			unset($_POST['submit']);
			if($_POST['class'] > 1):
				$this->form_validation->set_rules('name',' ','required|trim|xss_clean');
				$this->form_validation->set_rules('address',' ','trim|xss_clean');
				$this->form_validation->set_rules('contacts',' ','trim|xss_clean');
			endif;
			if($_POST['class'] == 2):
				$this->form_validation->set_rules('fullname',' ','required|trim|xss_clean');
				$this->form_validation->set_rules('note',' ','required|trim|xss_clean');
			endif;
			$this->form_validation->set_rules('language',' ','required|trim');
			$this->form_validation->set_rules('password',' ','trim');
			$this->form_validation->set_rules('confirm',' ','matches[password]|trim');
			if($this->form_validation->run()):
				$update = $this->input->post();
				if($_FILES['photo']['error'] != 4):
					$this->image_manupulation($_FILES['photo']['tmp_name'],'width',TRUE,200,200);
					$update['photo'] = file_get_contents($_FILES['photo']['tmp_name']);
					$this->image_manupulation($_FILES['photo']['tmp_name'],'width',TRUE,64,64);
					$update['thumbnail'] = file_get_contents($_FILES['photo']['tmp_name']);
				endif;
				$update['id'] = $this->uri->segment(3);
				$this->mdusers->update_record($update);
				$update['user_id'] = $this->mdusers->read_field($update['id'],'users','user_id');
				switch($update['class']):
					case 2:$this->mdinstitutions->update_record($update); break;
					case 3:$this->mdteachers->update_record($update); break;
					case 4:$this->mdstudents->update_record($update); break;
				endswitch;
				if(!empty($update['password'])):
					$this->mdusers->update_field($update['id'],'password',md5($update['password']),'users');
				endif;
			/************************ Settings *************************/
			
			if(isset($update['settings'])):
				if(isset($update['settings']['active'])):
					$this->mdusers->update_field($update['id'],'active',1,'users');
					$this->send_notification(2,$update['id']);
				endif;
			endif;
			
			/********************** End settings ***********************/
				
				$this->session->set_userdata('msgs','Профиль сохраненен!');
				redirect(current_url());
			else:
				$this->session->set_userdata('msgr','Ошибка при заполнении полей');
			endif;
		endif;
		$pagevar = array(
			'languages' => $this->mdlanguages->visible_languages(),
			'profile' => $this->mdusers->read_record($this->uri->segment(3),'users'),
			'msgs' => $this->session->userdata('msgs'),
			'msgr' => $this->session->userdata('msgr')
		);
		$this->session->unset_userdata(array('msgr'=>'','msgs'=>''));
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