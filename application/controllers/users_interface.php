<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Users_interface extends MY_Controller {
	
	function __construct(){
		
		parent::__construct();
		$this->load->model('pages');
	}
	
	public function index(){
		
		$pagevar = array('page'=>$this->pages->read_record('home'));
		$this->load->view("users_interface/pages/index",$pagevar);
	}
	
	public function search(){
		
		$this->load->model('property_type');
		$pagevar = array(
			'page'=>$this->pages->read_record(uri_string()),
			'property_type'=>$this->property_type->read_records('property_type')
		);
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
	
	public function clearSession(){
		
		$this->session->unset_userdata(array('current_property'=>'','property_id'=>'','search_sql'=>'','search_json_data'=>'','zillow_address'=>'','zillow_zip'=>''));
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
		
		$this->load->model('company');
		$pagevar = array(
			'page'=>$this->pages->read_record(uri_string()),
			'companies' => $this->company->companyTitles()
		);
		$this->load->view("users_interface/pages/signup",$pagevar);
	}
	
	public function login(){
		
		if($this->loginstatus):
			switch($this->account['group']):
				case 1: redirect(ADM_START_PAGE); break;
				case 2: redirect(BROKER_START_PAGE); break;
				case 3: redirect(OWNER_START_PAGE); break;
			endswitch;
		endif;
		$pagevar = array('page'=>$this->pages->read_record(uri_string()));
		$this->load->view("users_interface/pages/login",$pagevar);
	}
	
	public function logout(){
		
		$this->session->unset_userdata(array('logon'=>'','account'=>'','backpath'=>'','profile'=>'','current_property'=>'','property_id'=>'','search_sql'=>'','search_json_data'=>'','zillow_address'=>'','zillow_zip'=>''));
		if(isset($_SERVER['HTTP_REFERER'])):
			redirect($_SERVER['HTTP_REFERER']);
		else:
			redirect('');
		endif;
	}
	
	public function pswdRecovery(){
		
		$pagevar = array('page'=>$this->pages->read_record(uri_string()));
		$this->load->view("users_interface/pages/password-recovery",$pagevar);
	}
	
	public function confirm_registering(){
		
		switch($this->uri->segment(2)):
			case 'broker': $cabinetLink = BROKER_START_PAGE; break;
			case 'homeowner': $cabinetLink = OWNER_START_PAGE; break;
			default: show_404(); break;
		endswitch;
		$user_id = $this->users->user_exist('temporary_code',$this->uri->segment(4));
		if($user_id):
			$this->users->update_field($user_id,'temporary_code','','users');
			$this->users->update_field($user_id,'active',1,'users');
			$user = $this->users->read_record($user_id,'users');
			switch($user['group']):
				case 2: $this->load->model('brokers');$user['name'] = $this->brokers->read_name($user['account'],'brokers'); break;
				case 3: $this->load->model('owners');$user['name'] = $this->owners->read_name($user['account'],'owners'); break;
			endswitch;
			$this->parseAndSendMail(3,array('email'=>$user['email'],'user_name'=>$user['name'],'cabinet_link'=>site_url($cabinetLink)));
			$account = json_encode(array('id'=>$user['id'],'group'=>$user['group']));
			$this->session->set_userdata(array('logon'=>md5($user['email']),'account'=>$account));
			redirect($cabinetLink);
		else:
			redirect('signup');
		endif;
	}
	
	public function confirm_temporary_code(){
		
		switch($this->uri->segment(2)):
			case 'broker': $cabinetLink = BROKER_START_PAGE; break;
			case 'homeowner': $cabinetLink = OWNER_START_PAGE; break;
			default: show_404(); break;
		endswitch;
		$userID = $this->users->user_exist('temporary_code',$this->uri->segment(4));
		if($userID):
			$this->users->update_field($userID,'password','','users');
			$this->users->update_field($userID,'active',1,'users');
			$this->users->update_field($userID,'temporary_code','','users');
			$user = $this->users->read_record($userID,'users');
			$account = json_encode(array('id'=>$user['id'],'group'=>$user['group']));
			$this->session->set_userdata(array('logon'=>md5($user['email']),'account'=>$account));
			redirect($cabinetLink);
		else:
			redirect('');
		endif;
	}
	
	/********************************************************************************************************************/
}