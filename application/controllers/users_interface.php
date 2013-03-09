<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Users_interface extends MY_Controller{
	
	function __construct(){
		
		parent::__construct();
		$this->load->model('pages');
	}
	
	
	function setDbData(){
		//заполняем брокеров
		$this->load->helper('string');
		$broker_data = array(
			'class' => 2,
			'user_id' => 0,
			'fname' => 'Broker',
			'lname' => '',
			'company' => 'Grapheme',
			'email' => '',
			'phone' => '89198919721',
			'termsofservice' => 1,
			'subcribe' => 1,
			'temporary_code' => '',
			'password' => '123456',
			'address' => 'Rostov-on-Don, Suvorova Street 52a',
			'cphone' => '89198919721',
			'cell' => '89198919721',
			'cmail' => '',
			'website' => 'http://grapheme.ru/',
			'license' => 0
		);
		$this->load->model('brokers');
		$this->db->truncate('brokers');
		$sql = "DELETE FROM house2trade.users WHERE users.id >= 2";
		$this->users->query_execute($sql);
		$sql = "ALTER TABLE `users` AUTO_INCREMENT =2";
		$this->users->query_execute($sql);
		for($i=0;$i<4;$i++):
			$broker_data['lname'] = 'Name '.($i+1);
			$broker_data['email'] = 'broker'.($i+1).'@house2trade.com';
			$broker_data['user_id'] = $this->users->insert_record($broker_data);
			$broker_data['id'] = $this->brokers->insert_record($broker_data);
			$this->users->update_field($broker_data['user_id'],'user_id',$broker_data['id'],'users');
			$this->users->update_field($broker_data['user_id'],'status',1,'users');
			$this->users->update_field($broker_data['user_id'],'signdate',date("Y-m-d H:i:s"),'users');
			$broker_data['cmail'] = 'company'.($i+1).'@house2trade.com';
			$broker_data['license'] = random_string('numeric',8);
			$this->brokers->update_record($broker_data);
		endfor;
		echo 'Брокеры созданы<br/>';
		$property_data = array(
			'class' => 3,
			'broker_id' => 0,
			'user_id' => 0,
			'fname' => 'Homeowner',
			'lname' => '',
			'email' => '',
			'city' => 'Rostov-on-Don',
			'state' => "Lenin's",
			'address1' => "Rostov-on-Don",
			'address2' => "Rostov-on-Don",
			'type' => "Living",
			'zip_code' => 0,
			'bathrooms' => 0,
			'bedrooms' => 0,
			'sqf' => 0,
			'price' => 0,
			'tax' => 0,
			'mls' => 0,
			'description' => 'angel in disguise linkin park',
			'subcribe' => 0,
			'temporary_code' => '',
			'password' => '123456',
		);
		$this->load->model('properties');
		$this->load->model('owners');
		$this->db->truncate('owners');
		$this->db->truncate('properties');
		$sql = "DELETE FROM house2trade.users WHERE users.id > 5";
		$this->owners->query_execute($sql);
		$sql = "ALTER TABLE `users` AUTO_INCREMENT = 6";
		$this->owners->query_execute($sql);
		for($i=0;$i<4;$i++):
			for($j=0;$j<250;$j++):
				$index = ($i*250)+($j+1);
				$property_data['broker_id'] = $i+2;
				$property_data['lname'] = 'Name '.$index;
				$property_data['email'] = 'owner'.$index.'@house2trade.com';
				$property_data['user_id'] = $this->users->insert_record($property_data);
				$property_data['zip_code'] = random_string('numeric',5);
				$property_data['bathrooms'] = random_string('numeric',1);
				$property_data['bedrooms'] = random_string('numeric',1);
				$property_data['sqf'] = random_string('numeric',2);
				$property_data['price'] = random_string('numeric',5);
				$property_data['tax'] = random_string('numeric',2);
				$property_data['mls'] = random_string('numeric',5);
				$property_data['id'] = $this->owners->insert_record($property_data);
				$this->owners->update_field($property_data['id'],'broker_id',$property_data['broker_id'],'owners');
				$this->users->update_field($property_data['user_id'],'user_id',$property_data['id'],'users');
				$this->users->update_field($property_data['user_id'],'status',1,'users');
				$this->users->update_field($property_data['user_id'],'class',3,'users');
				$this->users->update_field($property_data['user_id'],'signdate',date("Y-m-d H:i:s"),'users');
				$property_id = $this->properties->insert_record($property_data);
				$this->properties->update_field($property_id,'status',1,'properties');
				$this->properties->update_field($property_id,'broker_id',$property_data['broker_id'],'properties');
			endfor;
		endfor;
		echo 'Владельцы созданы<br/>';
		echo 'Недвижимость создана<br/>';
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
	
	public function logout(){
		
		$this->session->unset_userdata(array('logon'=>'','userid'=>'','backpath'=>''));
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
			$user = $this->users->read_record($user_id,'users');
			switch($user['class']):
				case 2: $this->load->model('brokers');$user['name'] = $this->brokers->read_name($user['user_id'],'brokers'); break;
				case 3: $this->load->model('owners');$user['name'] = $this->owners->read_name($user['user_id'],'owners'); break;
			endswitch;
			ob_start();?>
<p>Hello <em><?=$user['name'];?></em>,</p>
<p>Your account has activated successfully!<br/>
To log in to your personal account, use the email specified during registration.<br/>
<br/>Please click on the link below to go to your account:<br/>
<?=anchor($cabinetLink,base_url().$cabinetLink,array('target'=>'_blank'));?></p><?
			$mailtext = ob_get_clean();
			$this->send_mail($user['email'],'robot@house2trade.com','House2Trade','Activated successfully',$mailtext);
			$this->session->set_userdata(array('logon'=>md5($this->users->read_field($user_id,'users','email')),'userid'=>$user_id));
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
		$user_id = $this->users->user_exist('temporary_code',$this->uri->segment(4));
		if($user_id):
			$this->users->update_field($user_id,'temporary_code','','users');
			$user = $this->users->read_record($user_id,'users');
			$this->session->set_userdata(array('logon'=>md5($this->users->read_field($user_id,'users','email')),'userid'=>$user_id));
			redirect($cabinetLink);
		else:
			redirect('');
		endif;
	}
	
	/********************************************************************************************************************/
}