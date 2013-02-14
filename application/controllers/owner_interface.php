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
			'profile' => $this->users->read_record($this->user['uid'],'users'),
			'msgs' => $this->session->userdata('msgs'),
			'msgr' => $this->session->userdata('msgr')
		);
		$this->session->unset_userdata(array('msgr'=>'','msgs'=>''));
		$this->load->view("owner_interface/pages/profile",$pagevar);
	}
	
}