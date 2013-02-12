<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Users_interface extends MY_Controller{
	
	function __construct(){
		
		parent::__construct();
		$this->load->model('pages');
	}
	
	public function index(){
		
		$pagevar = array('page'=>$this->pages->read_record('home'));
		$this->load->view("users_interface/pages/index",$pagevar);
	}
	
	public function search(){
		
		$pagevar = array('page'=>$this->pages->read_record(uri_string()));
		$this->load->view("users_interface/pages/search",$pagevar);
	}
	
	public function howItWorks(){
		
		$pagevar = array('page'=>$this->pages->read_record(uri_string()));
		$this->load->view("users_interface/pages/how-it-works",$pagevar);
	}
	
	public function tradingConcepts(){
		
		$pagevar = array('page'=>$this->pages->read_record(uri_string()));
		$this->load->view("users_interface/pages/trading-concepts",$pagevar);
	}
	
	public function aboutUs(){
		
		$pagevar = array('page'=>$this->pages->read_record(uri_string()));
		$this->load->view("users_interface/pages/about-us",$pagevar);
	}
	
	public function contacts(){
		
		$pagevar = array('page'=>$this->pages->read_record(uri_string()));
		$this->load->view("users_interface/pages/contacts",$pagevar);
	}
	
	//***************************************************************************************************** footer pages
	
	public function searchForOne(){
		
		$pagevar = array('page'=>$this->pages->read_record(uri_string()));
		$this->load->view("users_interface/pages/search-for-one",$pagevar);
	}
	
	public function advancedSearch(){
		
		$pagevar = array('page'=>$this->pages->read_record(uri_string()));
		$this->load->view("users_interface/pages/advanced-search",$pagevar);
	}
	
	public function lastestOffers(){
		
		$pagevar = array('page'=>$this->pages->read_record(uri_string()));
		$this->load->view("users_interface/pages/lastest-offers",$pagevar);
	}
	
	public function propertiesForSale(){
		
		$pagevar = array('page'=>$this->pages->read_record(uri_string()));
		$this->load->view("users_interface/pages/properties-for-sale",$pagevar);
	}
	
	public function company(){
		
		$pagevar = array('page'=>$this->pages->read_record(uri_string()));
		$this->load->view("users_interface/pages/company",$pagevar);
	}
	
	public function stepByStep(){
		
		$pagevar = array('page'=>$this->pages->read_record(uri_string()));
		$this->load->view("users_interface/pages/step-by-step",$pagevar);
	}
	
	public function virtualTour(){
		
		$pagevar = array('page'=>$this->pages->read_record(uri_string()));
		$this->load->view("users_interface/pages/virtual-tour",$pagevar);
	}

	/******************************************* Авторизация и регистрация ***********************************************/
	
	public function signup(){
		
		$pagevar = array('page'=>$this->pages->read_record(uri_string()));
		$this->load->view("users_interface/pages/signup",$pagevar);
	}
	
	public function login(){
		$pagevar = array('page'=>$this->pages->read_record(uri_string()));
		$this->load->view("users_interface/pages/login",$pagevar);
	}
	
	public function logoff(){
		
		$this->session->unset_userdata(array('logon'=>'','userid'=>'','backpath'=>''));
		if(isset($_SERVER['HTTP_REFERER'])):
			redirect($_SERVER['HTTP_REFERER']);
		else:
			redirect('');
		endif;
	}
	
	public function activation_student(){
		
		$pagevar = array(
			'languages'		=> $this->mdlanguages->visible_languages(),
			'content'		=> 'Аккаунт успешно активирован!<br/>Для авторизации воспользуйтесь логином и паролем указаные при регистрации.',
			'msgs'			=> $this->session->flashdata('msgs'),
			'msgr'			=> $this->session->flashdata('msgr')
		);
		$user_id = $this->mdusers->user_exist('temporary_code',$this->uri->segment(4));
		if($user_id):
			$this->mdusers->update_field($user_id,'temporary_code','','users');
			$this->mdusers->update_field($user_id,'active',1,'users');
		else:
			$pagevar['content'] = 'Указан не верный или устаревший код активации. Активация невозможна.';
		endif;
		$this->load->view("users_interface/registering/student-activation",$pagevar);
	}
	
	public function activation_teacher(){
		
		$pagevar = array(
			'languages'		=> $this->mdlanguages->visible_languages(),
			'content'		=> 'Аккаунт успешно активирован!<br/>Для авторизации воспользуйтесь логином и паролем указаные при регистрации.',
			'msgs'			=> $this->session->flashdata('msgs'),
			'msgr'			=> $this->session->flashdata('msgr')
		);
		$user_id = $this->mdusers->user_exist('temporary_code',$this->uri->segment(4));
		if($user_id):
			$this->mdusers->update_field($user_id,'temporary_code','','users');
			$this->mdusers->update_field($user_id,'active',1,'users');
		else:
			$pagevar['content'] = 'Указан не верный или устаревший код активации. Активация невозможна.';
		endif;
		$this->load->view("users_interface/registering/student-activation",$pagevar);
	}
	
	public function register_successful_student(){
		
		if(!$this->session->flashdata('student_registering_flag')):
			redirect('');
		endif;
		
		$pagevar = array(
			'languages'		=> $this->mdlanguages->visible_languages(),
			'content'		=> 'Вы успешно зарегистрировались на International Ideas Art School в статусе студента.<br/>На Ваш Email выслано письмо. Подтвердите регистрацию!',
			'msgs'			=> $this->session->flashdata('msgs'),
			'msgr'			=> $this->session->flashdata('msgr')
		);
		$this->load->view("users_interface/registering/status-registering",$pagevar);
	}
	
	public function register_successful_teacher(){
		
		if(!$this->session->flashdata('teacher_registering_flag')):
			redirect('');
		endif;
		
		$pagevar = array(
			'languages'		=> $this->mdlanguages->visible_languages(),
			'content'		=> 'Вы успешно зарегистрировались на International Ideas Art School в статусе преподавателя.<br/>На Ваш Email выслано письмо. Подтвердите регистрацию!',
			'msgs'			=> $this->session->flashdata('msgs'),
			'msgr'			=> $this->session->flashdata('msgr')
		);
		
		$this->load->view("users_interface/registering/status-registering",$pagevar);
	}
	
	/********************************************************************************************************************/
}