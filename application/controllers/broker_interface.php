<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Broker_interface extends MY_Controller{
	
	function __construct(){
		
		parent::__construct();
		if(!$this->loginstatus || ($this->user['class'] != 2)):
			redirect('');
		endif;
		$password = $this->users->read_field($this->user['uid'],'users','password');
		if(empty($password) && ($this->uri->segment(2) != 'set-password')):
			redirect('broker/set-password');
		endif;
	}
	
	/******************************************** cabinet *******************************************************/
	
	public function setPassword(){
		$password = $this->users->read_field($this->user['uid'],'users','password');
		if(!empty($password)):
			redirect(BROKER_START_PAGE);
		endif;
		$this->load->view("broker_interface/pages/set-password");
	}
	
	public function register_properties(){
		
		$this->session->unset_userdata(array('owner_id'=>'','property_id'=>''));
		$this->load->view("broker_interface/pages/properties");
	}
	
	public function profile(){
		
		$this->load->model('brokers');
		$pagevar = array('profile' => $this->users->read_record($this->user['uid'],'users'));
		$pagevar['profile']['info'] = $this->brokers->read_record($pagevar['profile']['user_id'],'brokers');
		$this->load->view("broker_interface/pages/profile",$pagevar);
	}
	
	/********************************************* trading ********************************************************/
	
	
	/********************************************* properties ********************************************************/
	
	public function properties(){
		
		$this->load->model('properties');
		$this->load->model('union');
		$this->load->model('images');
		$from = (int)$this->uri->segment(4);
		$pagevar = array(
			'properties' => $this->union->brokerPropertiesList(3,$this->user['uid'],10,$from),
			'pages' => $this->pagination(BROKER_START_PAGE.'/',5,$this->properties->count_records('properties','owner_id',$this->user['uid']),10)
		);
		for($i=0;$i<count($pagevar['properties']);$i++):
			$pagevar['properties'][$i]['photo'] = $this->images->mainPhoto($pagevar['properties'][$i]['id']);
			if(!$pagevar['properties'][$i]['photo']):
				$pagevar['properties'][$i]['photo'] = 'img/thumb.png';
			endif;
		endfor;
		$this->session->set_userdata('backpath',uri_string());
		$this->load->view("broker_interface/pages/list-properties",$pagevar);
	}
	
	public function edit_property(){
		
		$this->load->model('properties');
		$this->load->model('owners');
		$this->load->model('images');
		$pagevar = array(
			'property' => $this->properties->read_record($this->uri->segment(4),'properties'),
			'images' => $this->images->read_records($this->uri->segment(4),'images')
		);
		if($pagevar['property']['broker_id'] != $this->user['uid']):
			show_error('Access Denied!');
		endif;
		$pagevar['property']['user'] = $this->users->read_record($pagevar['property']['owner_id'],'users');
		$pagevar['property']['owner'] = $this->owners->read_record($pagevar['property']['user']['user_id'],'owners');
		$this->session->set_userdata(array('owner_id'=>$pagevar['property']['owner']['id'],'property_id'=>$pagevar['property']['id']));
		$this->load->view("broker_interface/pages/property-card",$pagevar);
	}
}