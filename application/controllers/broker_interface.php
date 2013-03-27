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
		
		$this->load->model('property_type');
		$pagevar = array('property_type'=>$this->property_type->read_records('property_type'));
		$this->session->unset_userdata(array('owner_id'=>'','property_id'=>''));
		$this->load->view("broker_interface/pages/properties",$pagevar);
	}
	
	public function profile(){
		
		$this->load->model('brokers');
		$pagevar = array('profile' => $this->users->read_record($this->user['uid'],'users'));
		$pagevar['profile']['info'] = $this->brokers->read_record($pagevar['profile']['user_id'],'brokers');
		$this->load->view("broker_interface/pages/profile",$pagevar);
	}
	
	/********************************************* trading ********************************************************/
	public function searchProperty(){
		
		if($this->uri->total_segments() < 3):
			$this->session->unset_userdata(array('search_sql'=>'','search_json_data'=>''));
		endif;
		$this->load->model('union');
		$this->load->model('property_type');
		$from = (int)$this->uri->segment(5);
		$pagevar = array(
			'zillow' => array(),
			'zillow_exist_id' => FALSE,
			'owners' => $this->union->ownersList($this->user['uid']),
			'property_type'=>$this->property_type->read_records('property_type'),
			'properties' => array(),
			'pages' => array(),
			'parameters' => json_decode($this->session->userdata('search_json_data'))
		);
		if($this->session->userdata('search_sql')):
			$sql = $this->session->userdata('search_sql')." LIMIT $from,7";
			$this->load->model('properties');
			$pagevar['properties'] = $this->properties->query_execute($sql);
			$ids = array();
			for($i=0;$i<count($pagevar['properties']);$i++):
				$ids[] = $pagevar['properties'][$i]['id'];
			endfor;
			$this->load->model('images');
			$this->load->model('property_favorite');
			$this->load->model('property_potentialby');
			if($ids):
				$mainPhotos = $this->images->mainPhotos($ids);
				$favorite = $this->property_favorite->record_exists($ids,$this->session->userdata('current_owner'));
				$potentialby = $this->property_potentialby->record_exists($ids,$this->session->userdata('current_owner'));
				for($i=0;$i<count($pagevar['properties']);$i++):
					$pagevar['properties'][$i]['photo'] = 'img/thumb.png';
					if($mainPhotos && array_key_exists($pagevar['properties'][$i]['id'],$mainPhotos)):
						$pagevar['properties'][$i]['photo'] = $mainPhotos[$pagevar['properties'][$i]['id']];
					endif;
					$pagevar['properties'][$i]['favorite'] = FALSE;
					if($favorite && array_key_exists($pagevar['properties'][$i]['id'],$favorite)):
						$pagevar['properties'][$i]['favorite'] = TRUE;
					endif;
					$pagevar['properties'][$i]['potentialby'] = FALSE;
					if($potentialby && array_key_exists($pagevar['properties'][$i]['id'],$potentialby)):
						$pagevar['properties'][$i]['potentialby'] = TRUE;
					endif;
				endfor;
				$count = 0;
				if($pagevar['properties']):
					$count = count($this->properties->query_execute($this->session->userdata('search_sql')));
				endif;
				$pagevar['pages'] = $this->pagination('broker/search/result',5,$count,7);
			else:
				$pagevar['properties'] = NULL;
				$pagevar['pages'] = NULL;
			endif;
			if($this->session->userdata('zillow_address') && $this->session->userdata('zillow_zip')):
				$zillow_result = $this->zillowApi($this->session->userdata('zillow_address'),$this->session->userdata('zillow_zip'));
				if($zillow_result):
					$zillow_exist = $this->properties->properties_exits($zillow_result['property-state'],$zillow_result['property-zipcode']);
					if($zillow_exist):
						$sql = 'SELECT users.id AS uid,users.email,users.status,owners.id AS oid,owners.fname,owners.lname,properties.*';
						$sql .= ' FROM users INNER JOIN owners ON users.user_id = owners.id INNER JOIN properties ON users.id = properties.owner_id';
						$sql .= ' WHERE properties.state = "'.$zillow_result['property-state'].'" AND properties.zip_code = "'.$zillow_result['property-zipcode'] .'"';
						if($pagevar['parameters']):
							if(!empty($pagevar['parameters']->beds_num)):
								$sql .= ' AND properties.bedrooms = '.$pagevar['parameters']->beds_num;
							endif;
							if(!empty($pagevar['parameters']->baths_num)):
								$sql .= ' AND properties.bathrooms = '.$pagevar['parameters']->baths_num;
							endif;
							if(!empty($pagevar['parameters']->property_min_price)):
								$sql .= ' AND properties.price >= '.$pagevar['parameters']->property_min_price;
							endif;
							if(!empty($pagevar['parameters']->property_max_price)):
								$sql .= ' AND properties.price <= '.$pagevar['parameters']->property_max_price;
							endif;
							if(!empty($pagevar['parameters']->square_feet)):
								$sql .= ' AND properties.sqf >= '.$pagevar['parameters']->square_feet;
							endif;
							if(!empty($pagevar['parameters']->type)):
								$sql .= ' AND properties.type = '.$pagevar['parameters']->type;
							endif;
						endif;
						$sql .= ' LIMIT 1';
						$pagevar['zillow'] = $this->properties->query_execute($sql);
						$pagevar['zillow'] = $pagevar['zillow'][0];
						if($pagevar['zillow']):
							$pagevar['zillow']['photo'] = $this->images->mainPhoto($pagevar['zillow']['id']);
						endif;
						$pagevar['zillow_exist_id'] = $zillow_exist;
					else:
						$unshift = array(
							'uid'=>0,'email'=>'','status'=>0,'oid'=>0,'fname'=>'','lname'=>'',
							'address1'=> $zillow_result['property-address1'],
							'description'=> $zillow_result['property-discription'],
							'city'=> $zillow_result['property-city'],
							'state'=> $zillow_result['property-state'],
							'type'=> $zillow_result['property-type'],
							'bathrooms'=> $zillow_result['property-bathrooms'],
							'bedrooms'=> $zillow_result['property-bedrooms'],
							'sqf'=> $zillow_result['property-sqf'],
							'tax'=> $zillow_result['property-tax'],
							'price'=> $zillow_result['property-price'],
							'zillow' => TRUE,
							'db_exist' => FALSE
						);
						$pagevar['zillow'] = $unshift;
						if($pagevar['zillow']):
							$pagevar['zillow']['photo'] = 'img/thumb.png';
						endif;
					endif;
				endif;
			endif;
		endif;
//		print_r($pagevar['zillow']);exit;
		
		$this->session->set_userdata('backpath',uri_string());
		$this->load->view("broker_interface/pages/search-properties",$pagevar);
	}
	
	public function favoriteProperty(){
		
		$this->load->model('property_favorite');
		$this->load->model('union');
		$this->load->model('images');
		$from = (int)$this->uri->segment(4);
		if(!$this->session->userdata('current_owner')):
			$this->session->set_userdata('current_owner',0);
		endif;
		$pagevar = array(
			'owners' => $this->union->ownersList($this->user['uid']),
			'properties' => $this->union->favoriteList($this->session->userdata('current_owner'),7,$from),
			'pages' => $this->pagination('broker/favorite',4,$this->property_favorite->count_records('property_favorite','owner',$this->session->userdata('current_owner')),7)
		);
		$ids = array();
		for($i=0;$i<count($pagevar['properties']);$i++):
			$ids[] = $pagevar['properties'][$i]['id'];
		endfor;
		if($ids):
			$this->load->model('images');
			$this->load->model('property_favorite');
			$this->load->model('property_potentialby');
			$mainPhotos = $this->images->mainPhotos($ids);
			$favorite = $this->property_favorite->record_exists($ids,$this->session->userdata('current_owner'));
			$potentialby = $this->property_potentialby->record_exists($ids,$this->session->userdata('current_owner'));
			for($i=0;$i<count($pagevar['properties']);$i++):
				$pagevar['properties'][$i]['photo'] = 'img/thumb.png';
				if($mainPhotos && array_key_exists($pagevar['properties'][$i]['id'],$mainPhotos)):
					$pagevar['properties'][$i]['photo'] = $mainPhotos[$pagevar['properties'][$i]['id']];
				endif;
				$pagevar['properties'][$i]['favorite'] = FALSE;
				if($favorite && array_key_exists($pagevar['properties'][$i]['id'],$favorite)):
					$pagevar['properties'][$i]['favorite'] = TRUE;
				endif;
				$pagevar['properties'][$i]['potentialby'] = FALSE;
				if($potentialby && array_key_exists($pagevar['properties'][$i]['id'],$potentialby)):
					$pagevar['properties'][$i]['potentialby'] = TRUE;
				endif;
			endfor;
		endif;
		$this->session->set_userdata('backpath',uri_string());
		$this->load->view("broker_interface/pages/list-properties",$pagevar);
	}
	
	public function potentialByProperty(){
		
		$this->load->model('property_potentialby');
		$this->load->model('union');
		$this->load->model('images');
		$from = (int)$this->uri->segment(4);
		if(!$this->session->userdata('current_owner')):
			$this->session->set_userdata('current_owner',0);
		endif;
		$pagevar = array(
			'owners' => $this->union->ownersList($this->user['uid']),
			'properties' => $this->union->potentialByList($this->session->userdata('current_owner'),7,$from),
			'pages' => $this->pagination('broker/potential-by',4,$this->property_potentialby->count_records('property_potentialby','owner',$this->session->userdata('current_owner')),7)
		);
		$ids = array();
		for($i=0;$i<count($pagevar['properties']);$i++):
			$ids[] = $pagevar['properties'][$i]['id'];
		endfor;
		if($ids):
			$this->load->model('images');
			$this->load->model('property_favorite');
			$this->load->model('property_potentialby');
			$mainPhotos = $this->images->mainPhotos($ids);
			$favorite = $this->property_favorite->record_exists($ids,$this->session->userdata('current_owner'));
			$potentialby = $this->property_potentialby->record_exists($ids,$this->session->userdata('current_owner'));
			for($i=0;$i<count($pagevar['properties']);$i++):
				$pagevar['properties'][$i]['photo'] = 'img/thumb.png';
				if($mainPhotos && array_key_exists($pagevar['properties'][$i]['id'],$mainPhotos)):
					$pagevar['properties'][$i]['photo'] = $mainPhotos[$pagevar['properties'][$i]['id']];
				endif;
				$pagevar['properties'][$i]['favorite'] = FALSE;
				if($favorite && array_key_exists($pagevar['properties'][$i]['id'],$favorite)):
					$pagevar['properties'][$i]['favorite'] = TRUE;
				endif;
				$pagevar['properties'][$i]['potentialby'] = FALSE;
				if($potentialby && array_key_exists($pagevar['properties'][$i]['id'],$potentialby)):
					$pagevar['properties'][$i]['potentialby'] = TRUE;
				endif;
			endfor;
		endif;
		$this->session->set_userdata('backpath',uri_string());
		$this->load->view("broker_interface/pages/list-properties",$pagevar);
	}
	
	/********************************************* properties ********************************************************/
	
	public function properties(){
		
		$this->load->model('properties');
		$this->load->model('union');
		$this->load->model('images');
		if(!$this->session->userdata('current_owner')):
			$this->session->set_userdata('current_owner',0);
		endif;
		$pagevar = array(
			'owners' => $this->union->ownersList($this->user['uid']),
			'properties' => $this->properties->read_records($this->session->userdata('current_owner'))
		);
		if($pagevar['properties']):
			$ids = array();
			for($i=0;$i<count($pagevar['properties']);$i++):
				$ids[] = $pagevar['properties'][$i]['id'];
			endfor;
			$mainPhotos = $this->images->mainPhotos($ids);
			for($i=0;$i<count($pagevar['properties']);$i++):
				$pagevar['properties'][$i]['photo'] = 'img/thumb.png';
				$pagevar['properties'][$i]['favorite'] = $pagevar['properties'][$i]['potentialby'] = FALSE;
				if($mainPhotos && array_key_exists($pagevar['properties'][$i]['id'],$mainPhotos)):
					$pagevar['properties'][$i]['photo'] = $mainPhotos[$pagevar['properties'][$i]['id']];
				endif;
			endfor;
		endif;
		$this->session->set_userdata('backpath',uri_string());
		$this->load->view("broker_interface/pages/list-properties",$pagevar);
	}
	
	public function property(){
		
		$this->load->model('union');
		$property = (int)$this->uri->segment(4);
		$pagevar = array(
			'property' => $this->union->propertyInformation($property),
			'images' => array()
		);
		if(!$pagevar['property']):
			show_error('Property missing');
		endif;
		$this->load->model('images');
		$pagevar['property']['photo'] = $this->images->mainPhoto($pagevar['property']['id']);
		$this->load->model('property_favorite');
		$pagevar['property']['favorite'] = FALSE;
		if($pagevar['property']['broker_id'] != $this->user['uid']):
			$pagevar['property']['favorite'] = $this->property_favorite->record_exist($pagevar['property']['id'],$this->session->userdata('current_owner'));
		endif;
		$this->load->model('property_potentialby');
		$pagevar['property']['potentialby'] = FALSE;
		if($pagevar['property']['broker_id'] != $this->user['uid']):
			$pagevar['property']['potentialby'] = $this->property_potentialby->record_exist($pagevar['property']['id'],$this->session->userdata('current_owner'));
		endif;
		if(!$pagevar['property']['photo']):
			$pagevar['property']['photo'] = 'img/thumb.png';
		endif;
		$pagevar['images'] = $this->images->read_records($pagevar['property']['id'],$this->session->userdata('current_owner'));
		$this->load->view("broker_interface/pages/property-information",$pagevar);
	}
	
	public function edit_property(){
		
		$this->load->model('properties');
		$this->load->model('owners');
		$this->load->model('images');
		$this->load->model('property_type');
		$pagevar = array(
			'property' => $this->properties->read_record($this->uri->segment(4),'properties'),
			'images' => $this->images->read_records($this->uri->segment(4),'images'),
			'property_type'=>$this->property_type->read_records('property_type')
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