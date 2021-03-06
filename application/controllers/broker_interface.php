<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Broker_interface extends MY_Controller{
	
	var $per_page = PER_PAGE_DEFAULT;
	var $offset = 0;
	
	function __construct(){
		
		parent::__construct();
		if(!$this->loginstatus || ($this->account['group'] != 2)):
			redirect('login');
		endif;
		$password = $this->users->read_field($this->account['id'],'users','password');
		if(empty($password) && ($this->uri->segment(2) != 'set-password')):
			redirect('broker/set-password');
		endif;
		if($this->session->userdata('search_sql')):
			if($this->uri->segment(2) != 'search'):
				$this->session->unset_userdata(array('search_sql'=>'','search_json_data'=>'','zillow_address'=>'','zillow_zip'=>''));
			endif;
		endif;
		if($this->session->userdata('current_property') === FALSE && $this->uri->segment(3) != 'full-list'):
			$this->load->model('properties');
			if($properties = $this->properties->read_records(null,$this->account['id'])):
				$this->session->set_userdata('current_property',$properties[0]['id']);
			endif;
		endif;
	}
	
	/******************************************** cabinet *******************************************************/
	
	public function setPassword(){
	
		$password = $this->users->read_field($this->account['id'],'users','password');
		if(!empty($password)):
			redirect(BROKER_START_PAGE);
		endif;
		$this->load->view("broker_interface/pages/set-password");
	}
	
	public function register_properties(){
		
		$this->load->model('property_type');
		$pagevar = array('property_type'=>$this->property_type->read_records('property_type'));
		$this->session->unset_userdata(array('property_id'=>''));
		$this->load->view("broker_interface/properties/insert-property",$pagevar);
	}
	
	public function profile(){
		
		$this->load->model('brokers');
		$this->load->model('company');
		$pagevar = array(
			'profile' => $this->users->read_record($this->account['id']),
			'companies' => $this->company->companyTitles()
		);
		$pagevar['profile']['info'] = $this->brokers->read_record($pagevar['profile']['account'],'brokers');
		$pagevar['profile']['company'] = $this->company->read_field($pagevar['profile']['info']['company'],'company','title');
		$this->load->view("broker_interface/pages/profile",$pagevar);
	}
	
	/********************************************* trading ********************************************************/
	
	public function searchProperty(){
		
		$this->load->model(array('union','property_type','properties'));
		$pagevar = array(
			'zillow' => array(),
			'zillow_exist_id' => FALSE,
			'property_type'=>$this->property_type->read_records('property_type'),
			'select' => $this->union->selectBrokerProperties($this->account['id']),
			'properties' => array(),
			'pages' => array(),
			'parameters' => json_decode($this->session->userdata('search_json_data'))
		);
		if($this->session->userdata('search_sql')):
			if($this->session->userdata('zillow_address') && ($this->session->userdata('zillow_zip') || $this->session->userdata('zillow_state') || $this->session->userdata('zillow_city'))):
				if($zillow_result = $this->zillowApi($this->session->userdata('zillow_address'),$this->session->userdata('zillow_zip').' '.$this->session->userdata('zillow_state').' '.$this->session->userdata('zillow_city'))):
					if($pagevar['zillow_exist_id'] = $this->properties->properties_exits($zillow_result['property-state'],$zillow_result['property-zipcode'],$zillow_result['property-address1'])):
						$pagevar['zillow'] = $this->getPropertyFromZillow($zillow_result,$pagevar['parameters']);
					else:
						$pagevar['zillow'] = $this->getUnshiftProperty($zillow_result);
					endif;
				endif;
			endif;
			if($pagevar['properties'] = $this->getPropertiesFromSearch(intval($this->uri->segment(5)),7)):
				$count = count($this->properties->query_execute($this->session->userdata('search_sql')));
				$pagevar['pages'] = $this->pagination('broker/search/result',5,$count,7);
			else:
				$pagevar['properties'] = NULL;
				$pagevar['pages'] = NULL;
			endif;
		endif;
		$this->session->set_userdata('backpath',site_url(uri_string()));
		$this->load->view("broker_interface/pages/search-properties",$pagevar);
	}
	
	public function favoriteProperty(){
		
		$this->load->model(array('property_favorite','union'));
		$from = (int)$this->uri->segment(4);
		if($this->session->userdata('current_property') === FALSE):
			$this->session->set_userdata('current_property',0);
		endif;
		$pagevar = array(
			'select' => $this->union->selectBrokerProperties($this->account['id']),
			'properties' => $this->union->favoriteList($this->session->userdata('current_property'),7,$from),
			'pages' => $this->pagination('broker/favorite',4,$this->property_favorite->count_records('property_favorite','seller_id',$this->session->userdata('current_property')),7)
		);
		if($ids = $this->getPropertyIDs($pagevar['properties'])):
			$this->load->model(array('images','property_potentialby','property_type'));
			$mainPhotos = $this->images->mainPhotos($ids);
			$property_type = $this->property_type->read_records('property_type');
			$pagevar['properties'] = $this->propertiesImagesTypes($pagevar['properties'],$mainPhotos,$property_type);
		endif;
		$this->session->set_userdata('backpath',uri_string());
		$this->load->view("broker_interface/properties/favorite",$pagevar);
	}
	
	public function potentialByProperty(){
		
		$this->load->model(array('property_potentialby','union'));
		$from = (int)$this->uri->segment(4);
		if($this->session->userdata('current_property') === FALSE):
			$this->session->set_userdata('current_property',0);
		endif;
		$pagevar = array(
			'select' => $this->union->selectBrokerProperties($this->account['id']),
			'properties' => $this->union->potentialByList($this->session->userdata('current_property'),7,$from),
			'pages' => $this->pagination('broker/potential-by',4,$this->property_potentialby->count_records('property_potentialby','seller_id',$this->session->userdata('current_property')),7)
		);
		if($ids = $this->getPropertyIDs($pagevar['properties'])):
			$this->load->model(array('images','property_type','property_potentialby'));
			$mainPhotos = $this->images->mainPhotos($ids);
			$property_type = $this->property_type->read_records('property_type');
			$pagevar['properties'] = $this->propertiesImagesTypes($pagevar['properties'],$mainPhotos,$property_type);
		endif;
		$this->session->set_userdata('backpath',uri_string());
		$this->load->view("broker_interface/properties/potentialby",$pagevar);
	}
	
	public function instantTrade(){
		
		$this->load->model('union');
		$pagevar = array(
			'select' => $this->union->selectBrokerProperties($this->account['id']),
			'levels' => array('level1'=>array(),'level2'=>array(),'level3'=>array(),'level4'=>array(),'level5'=>array(),'level6'=>array())
		);
		if($this->session->userdata('current_property') == TRUE):
			$sellers = $this->db->query('SELECT `seller_id` AS property_id,COUNT(*) AS cnt FROM `property_potentialby` GROUP BY `seller_id` ORDER BY `seller_id`')->result_array();
			$sellers = $this->allocationCount($sellers);
			$buyers = $this->db->query('SELECT `buyer_id` AS property_id,COUNT(*) AS cnt FROM `property_potentialby` GROUP BY `buyer_id` ORDER BY `buyer_id`')->result_array();
			$buyers = $this->allocationCount($buyers);
			$levels = $this->getInstantTradeAllLevels($this->session->userdata('current_property'));
			foreach($levels as $level_number => $level):
				if($level_number == 'level1'):
					$pagevar['levels'][$level_number] = $this->addSellersBuyersCounts($level,$level['id'],$sellers,$buyers);
					continue;
				endif;
				if(!empty($level)):
					foreach($level as $property):
						$pagevar['levels'][$level_number][] = $this->addSellersBuyersCounts($property,$property['id'],$sellers,$buyers);
					endforeach;
				endif;
			endforeach;
		endif;
		$this->session->set_userdata('backpath',uri_string());
		$this->load->view("broker_interface/pages/instant-trade",$pagevar);
	}
	
	public function match(){
		
		if($this->input->get('action') == 'cancel'):
			if($this->cancelOperationWithMatch($this->input->get('match'),$this->input->get('field')) == TRUE):
				redirect('broker/match');
			endif;
		endif;
		$this->load->model(array('union','match'));
		$pagevar = array(
			'select' => $this->union->selectBrokerProperties($this->account['id']),
			'match' => array(),
			'properties' => array(),
		);
		if($this->session->userdata('current_property')):
			$pagevar['match'] = $this->match->parseMatchPropertyID($this->session->userdata('current_property'));
			$matchesPropertiesIDs = $this->getMatchPropertiesIDs($pagevar['match']);
			$pagevar['properties'] = $this->getMatchPropertiesInformationList($matchesPropertiesIDs);
			$pagevar['properties'] = $this->propertiesImagesTypes($pagevar['properties']);
			if(!empty($pagevar['match'])):
				$pagevar['match']['my_status_field'] = $this->getFieldMatchName($pagevar['match']);
			endif;
		endif;
		$this->session->set_userdata('backpath',uri_string());
		$this->load->view("broker_interface/pages/match",$pagevar);
	}
	
	public function recommendedProperty(){
		
		$this->load->model(array('desired_properties','union','property_type'));
		$from = (int)$this->uri->segment(4);
		
		$pagevar = array(
			'select' => $this->union->selectBrokerProperties($this->account['id']),
			'property_type'=>$this->property_type->read_records('property_type'),
			'desired_property' => array(),
			'properties' => array(),
			'pages' => NULL,
		);
		if($this->session->userdata('current_property') == FALSE):
			$this->session->set_userdata('current_property',0);
		else:
			if(!$pagevar['desired_property'] = $this->desired_properties->getDesiredByPropertyID($this->session->userdata('current_property'))):
				$this->load->model('properties');
				if($mainProperty = $this->properties->read_record($this->session->userdata('current_property'),'properties')):
					$desiredPropertyID = $this->createClearDesiredProperty($mainProperty);
					$pagevar['desired_property'] = $this->desired_properties->read_record($desiredPropertyID,'desired_properties');
				endif;
			endif;
			if(!empty($pagevar['desired_property']['zip_code'])):
				if($pagevar['properties'] = $this->union->recommendedList($pagevar['desired_property'],7,$from)):
					$pagevar['pages'] = $this->pagination('broker/recommended',4,$this->union->recommendedCount($pagevar['desired_property']),7);
					$pagevar['properties'] = $this->propertiesImagesTypes($pagevar['properties'],TRUE);
					$pagevar['properties'] = $this->propertiesPotentiaByAndFavorite($pagevar['properties']);
				endif;
			endif;
			$this->session->set_userdata('property_id',$this->session->userdata('current_property'));
		endif;
		$this->session->set_userdata('backpath',uri_string());
		$this->load->view("broker_interface/properties/recommended",$pagevar);
	}
	
	
	/********************************************* properties ********************************************************/
	
	public function properties(){
		
		$this->load->model(array('union','properties','images'));
		if($this->session->userdata('current_property') == 0):
			redirect(BROKER_START_PAGE.'/full-list');
		endif;
		$pagevar = array(
			'select' => $this->union->selectBrokerProperties($this->account['id']),
			'property' => $this->properties->read_record($this->session->userdata('current_property'),'properties')
		);
		if($pagevar['property']):
			$pagevar['property']['photo'] = $this->images->mainPhoto($pagevar['property']['id']);
			if(!$pagevar['property']['photo']):
				$pagevar['property']['photo'] = 'img/thumb.png';
			endif;
			$this->load->model('property_type');
			$pagevar['property']['type'] = $this->property_type->read_field($pagevar['property']['type'],'property_type','title');
		endif;
		$this->session->set_userdata('backpath',uri_string());
		$this->session->unset_userdata(array('property_id'=>'','search_sql'=>'','search_json_data'=>'','zillow_address'=>'','zillow_zip'=>''));
		$this->load->view("broker_interface/properties/single-property",$pagevar);
	}
	
	public function propertiesFullList(){
		
		$offset = intval($this->uri->segment(5));
		$per_page = 10;
		$this->load->model(array('union','properties'));
		$pagevar = array(
			'select' => $this->union->selectBrokerProperties($this->account['id']),
			'properties' => $this->properties->getLimit($per_page,$offset),
			'pagination' => $this->pagination(BROKER_START_PAGE.'/full-list',5,$this->properties->countRecords(2),$per_page)
		);
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
				$pagevar['properties'][$i]['favorite'] = $pagevar['properties'][$i]['potentialby'] = FALSE;
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
		$this->session->set_userdata('backpath',uri_string());
		$this->session->unset_userdata('property_id');
		$this->load->view("broker_interface/properties/multi-property",$pagevar);
	}
	
	public function propertyDetail(){
		
		$current_property = $this->session->userdata('property_id');
		if($this->uri->total_segments() == 4):
			$this->session->set_userdata('property_id',$this->uri->segment(4));
			redirect('broker/'.$this->uri->segment(2).'/information');
		elseif(!$current_property && $this->uri->total_segments() == 3):
			redirect('broker/'.$this->uri->segment(2));
		endif;
		
		$this->load->model(array('properties','images','union'));
		$pagevar = array(
			'select' => $this->union->selectBrokerProperties($this->account['id']),
			'property' => $this->properties->read_record($current_property,'properties'),
			'images' => $this->images->read_records($current_property)
		);
		if(!$pagevar['property']):
			show_error('Property missing');
		endif;
		$this->load->model('accounts_owners');
		if($pagevar['property']['owner']):
			$owner = $this->accounts_owners->read_record($pagevar['property']['owner'],'accounts_owners');
			if($owner):
				$pagevar['property']['phone'] = $owner['phone'];
				$pagevar['property']['cell'] = $owner['cell'];
				$pagevar['property']['email'] = $owner['email'];
			endif;
		endif;
		$this->load->model('property_potentialby');
		$pagevar['property']['favorite'] = FALSE;
		$pagevar['property']['potentialby'] = FALSE;
		if($this->session->userdata('current_property') && ($pagevar['property']['id'] != $this->session->userdata('current_property'))):
			$pagevar['property']['potentialby'] = $this->property_potentialby->record_exist($this->session->userdata('current_property'),$current_property);
		endif;
		if(!$pagevar['property']['potentialby']):
			$this->load->model('property_favorite');
			if($this->session->userdata('current_property') && ($pagevar['property']['id'] != $this->session->userdata('current_property'))):
				$pagevar['property']['favorite'] = $this->property_favorite->record_exist($this->session->userdata('current_property'),$current_property);
			endif;
		endif;
		$this->load->model('property_type');
		$property_type = $this->property_type->read_records('property_type');
		for($j=0;$j<count($property_type);$j++):
			if($pagevar['property']['type'] == $property_type[$j]['id']):
				$pagevar['property']['type'] = $property_type[$j]['title'];
				break;
			endif;
		endfor;
		$this->load->view("broker_interface/properties/property-detail",$pagevar);
	}
	
	public function editProperty(){

		$current_property = $this->session->userdata('property_id');
		if($this->uri->total_segments() == 4):
			$this->session->set_userdata('property_id',$this->uri->segment(4));
			redirect(BROKER_START_PAGE.'/edit');
		elseif(!$current_property && $this->uri->total_segments() == 3):
			redirect(BROKER_START_PAGE);
		endif;
		$this->load->model(array('properties','images','property_type'));
		$pagevar = array(
			'property' => $this->properties->read_record($current_property,'properties'),
			'desired_property' => array(),
			'images' => $this->images->read_records($current_property),
			'property_type'=>$this->property_type->read_records('property_type')
		);
		if($pagevar['property']['broker'] != $this->account['id']):
			show_error('Access Denied!');
		endif;
		$this->load->model(array('accounts_owners','desired_properties'));
		if(!$pagevar['desired_property'] = $this->desired_properties->getDesiredByPropertyID($pagevar['property']['id'],'desired_properties')):
			$this->createClearDesiredProperty($pagevar['property']);
		endif;
		$pagevar['property']['owner'] = $this->accounts_owners->read_record($pagevar['property']['owner'],'accounts_owners');
		$this->load->view("broker_interface/properties/property-card",$pagevar);
	}
}