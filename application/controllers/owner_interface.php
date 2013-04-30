<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Owner_interface extends MY_Controller{
	
	var $owner = array('seller'=>FALSE);
	
	function __construct(){
		
		parent::__construct();
		if(!$this->loginstatus || ($this->account['group'] != 3)):
			redirect('login');
		else:
			$this->load->model('owners');
			$this->owner['seller'] = $this->owners->read_field($this->profile['account'],'owners','seller');
		endif;
		$password = $this->users->read_field($this->account['id'],'users','password');
		if(empty($password) && ($this->uri->segment(2) != 'set-password')):
			redirect('homeowner/set-password');
		endif;
		if($this->session->userdata('search_sql')):
			if($this->uri->segment(2) != 'search'):
				$this->session->unset_userdata(array('search_sql'=>'','search_json_data'=>'','zillow_address'=>'','zillow_zip'=>''));
			endif;
		endif;
	}
	
	/******************************************** cabinet *******************************************************/
	
	public function setPassword(){
		
		$password = $this->users->read_field($this->account['id'],'users','password');
		if(!empty($password)):
			redirect(OWNER_START_PAGE);
		endif;
		$this->load->view("owner_interface/pages/set-password");
	}
	
	public function register_properties(){
		
		if(!$this->owner['seller']):
			redirect(OWNER_START_PAGE);
		endif;
		$this->load->model('property_type');
		$pagevar = array('property_type'=>$this->property_type->read_records('property_type'));
		$this->session->unset_userdata(array('property_id'=>''));
		$this->load->view("owner_interface/properties/insert-property",$pagevar);
	}
	
	public function profile(){
		
		$this->load->model('owners');
		$pagevar = array('profile' => $this->users->read_record($this->account['id'],'users'));
		$pagevar['profile']['info'] = $this->owners->read_record($pagevar['profile']['account'],'owners');
		$this->load->view("owner_interface/pages/profile",$pagevar);
	}
	
	/********************************************* trading ********************************************************/
	
	public function searchProperty(){
		
		$this->load->model('union');
		$this->load->model('property_type');
		$from = (int)$this->uri->segment(5);
		$potentialby = $favorite = FALSE;
		$pagevar = array(
			'zillow' => array(),
			'zillow_exist_id' => FALSE,
			'property_type'=>$this->property_type->read_records('property_type'),
			'select' => $this->union->selectOwnerProperties($this->account['id']),
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
				if($this->session->userdata('current_property')):
					$favorite = $this->property_favorite->record_exists($this->session->userdata('current_property'),$ids);
					$potentialby = $this->property_potentialby->record_exists($this->session->userdata('current_property'),$ids);
				endif;
				for($i=0;$i<count($pagevar['properties']);$i++):
					$pagevar['properties'][$i]['photo'] = 'img/thumb.png';
					if($mainPhotos && array_key_exists($pagevar['properties'][$i]['id'],$mainPhotos)):
						$pagevar['properties'][$i]['photo'] = $mainPhotos[$pagevar['properties'][$i]['id']];
					endif;
					$pagevar['properties'][$i]['favorite'] = FALSE;
					$pagevar['properties'][$i]['potentialby'] = FALSE;
					if($this->session->userdata('current_property')):
						if($favorite && array_key_exists($pagevar['properties'][$i]['id'],$favorite)):
							$pagevar['properties'][$i]['favorite'] = TRUE;
						endif;
						if($potentialby && array_key_exists($pagevar['properties'][$i]['id'],$potentialby)):
							$pagevar['properties'][$i]['potentialby'] = TRUE;
						endif;
					endif;
					for($j=0;$j<count($pagevar['property_type']);$j++):
						if($pagevar['properties'][$i]['type'] == $pagevar['property_type'][$j]['id']):
							$pagevar['properties'][$i]['type'] = $pagevar['property_type'][$j]['title'];
							break;
						endif;
					endfor;
				endfor;
				$count = 0;
				if($pagevar['properties']):
					$count = count($this->properties->query_execute($this->session->userdata('search_sql')));
				endif;
				$pagevar['pages'] = $this->pagination('homeowner/search/result',5,$count,7);
			else:
				$pagevar['properties'] = NULL;
				$pagevar['pages'] = NULL;
			endif;
			if($this->session->userdata('zillow_address') && $this->session->userdata('zillow_zip')):
				$zillow_result = $this->zillowApi($this->session->userdata('zillow_address'),$this->session->userdata('zillow_zip'));
				if($zillow_result):
					$zillow_exist = $this->properties->properties_exits($zillow_result['property-state'],$zillow_result['property-zipcode']);
					if($zillow_exist):
						$sql = 'SELECT properties.* FROM properties WHERE properties.state = "'.$zillow_result['property-state'].'" AND properties.zip_code = "'.$zillow_result['property-zipcode'] .'"';
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
							$pagevar['zillow']['potentialby'] = FALSE;
							if($potentialby && array_key_exists($pagevar['zillow']['id'],$potentialby)):
								$pagevar['zillow']['potentialby'] = TRUE;
							endif;
							if(!$pagevar['zillow']['potentialby']):
								$pagevar['zillow']['favorite'] = FALSE;
								if($favorite && array_key_exists($pagevar['zillow']['id'],$favorite)):
									$pagevar['zillow']['favorite'] = TRUE;
								endif;
							endif;
							for($j=0;$j<count($pagevar['property_type']);$j++):
								if($pagevar['zillow']['type'] == $pagevar['property_type'][$j]['id']):
									$pagevar['zillow']['type'] = $pagevar['property_type'][$j]['title'];
									break;
								endif;
							endfor;
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
							'year'=> $zillow_result['property-year'],
							'last-sold-date'=> $zillow_result['property-last-sold-date'],
							'last-sold-price'=> $zillow_result['property-last-sold-price'],
						);
						$pagevar['zillow'] = $unshift;
						if($pagevar['zillow']):
							$pagevar['zillow']['favorite'] = FALSE;
							$pagevar['zillow']['potentialby'] = FALSE;
							$pagevar['zillow']['photo'] = site_url('img/thumb.png');
							$images = $this->arrayImagesFromPage($zillow_result['page-content']);
							if($images):
								$random = array_rand($images);
								if(isset($random) && $random):
									$pagevar['zillow']['photo'] = $images[$random];
								endif;
							endif;
						endif;
					endif;
				endif;
			endif;
		endif;
		$this->session->set_userdata('backpath',uri_string());
		$this->load->view("owner_interface/pages/search-properties",$pagevar);
	}
	
	public function favoriteProperty(){
		
		$this->load->model('property_favorite');
		$this->load->model('union');
		$from = (int)$this->uri->segment(4);
		if(!$this->session->userdata('current_property')):
			$this->session->set_userdata('current_property',0);
		endif;
		$pagevar = array(
			'select' => $this->union->selectOwnerProperties($this->account['id']),
			'properties' => $this->union->favoriteList($this->session->userdata('current_property'),7,$from),
			'pages' => $this->pagination('homeowner/favorite',4,$this->property_favorite->count_records('property_favorite','seller_id',$this->session->userdata('current_property')),7)
		);
		$ids = array();
		for($i=0;$i<count($pagevar['properties']);$i++):
			$ids[] = $pagevar['properties'][$i]['id'];
		endfor;
		if($ids):
			$this->load->model('images');
			$this->load->model('property_potentialby');
			$mainPhotos = $this->images->mainPhotos($ids);
			$potentialby = $this->property_potentialby->record_exists($ids,$this->session->userdata('current_property'));
			$this->load->model('property_type');
			$property_type = $this->property_type->read_records('property_type');
			for($i=0;$i<count($pagevar['properties']);$i++):
				$pagevar['properties'][$i]['photo'] = 'img/thumb.png';
				if($mainPhotos && array_key_exists($pagevar['properties'][$i]['id'],$mainPhotos)):
					$pagevar['properties'][$i]['photo'] = $mainPhotos[$pagevar['properties'][$i]['id']];
				endif;
				$pagevar['properties'][$i]['potentialby'] = FALSE;
				if($potentialby && array_key_exists($pagevar['properties'][$i]['id'],$potentialby)):
					$pagevar['properties'][$i]['potentialby'] = TRUE;
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
		$this->load->view("owner_interface/properties/favorite",$pagevar);
	}
	
	public function potentialByProperty(){
		
		$this->load->model('property_potentialby');
		$this->load->model('union');
		$from = (int)$this->uri->segment(4);
		if(!$this->session->userdata('current_property')):
			$this->session->set_userdata('current_property',0);
		endif;
		$pagevar = array(
			'select' => $this->union->selectOwnerProperties($this->account['id']),
			'properties' => $this->union->potentialByList($this->session->userdata('current_property'),7,$from),
			'pages' => $this->pagination('homeowner/potential-by',4,$this->property_potentialby->count_records('property_potentialby','seller_id',$this->session->userdata('current_property')),7)
		);
		$ids = array();
		for($i=0;$i<count($pagevar['properties']);$i++):
			$ids[] = $pagevar['properties'][$i]['id'];
		endfor;
		if($ids):
			$this->load->model('images');
			$this->load->model('property_potentialby');
			$mainPhotos = $this->images->mainPhotos($ids);
			$potentialby = $this->property_potentialby->record_exists($ids,$this->session->userdata('current_owner'));
			$this->load->model('property_type');
			$property_type = $this->property_type->read_records('property_type');
			for($i=0;$i<count($pagevar['properties']);$i++):
				$pagevar['properties'][$i]['photo'] = 'img/thumb.png';
				if($mainPhotos && array_key_exists($pagevar['properties'][$i]['id'],$mainPhotos)):
					$pagevar['properties'][$i]['photo'] = $mainPhotos[$pagevar['properties'][$i]['id']];
				endif;
				$pagevar['properties'][$i]['potentialby'] = FALSE;
				if($potentialby && array_key_exists($pagevar['properties'][$i]['id'],$potentialby)):
					$pagevar['properties'][$i]['potentialby'] = TRUE;
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
		$this->load->view("owner_interface/properties/potentialby",$pagevar);
	}
	
	/********************************************* properties ********************************************************/
	
	public function properties(){
		
		$offset = intval($this->uri->segment(5));
		$per_page = 10;
		$this->load->model('union');
		$this->load->model('properties');
		$this->load->model('images');
		$pagevar = array(
			'properties' => $this->properties->read_limit_records($per_page,$offset),
			'pagination' => $this->pagination(OWNER_START_PAGE,5,$this->properties->countRecords(3),$per_page)
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
		$this->session->unset_userdata(array('property_id'=>'','search_sql'=>'','search_json_data'=>'','zillow_address'=>'','zillow_zip'=>''));
		$this->load->view("owner_interface/properties/multi-property",$pagevar);
	}
	
	public function propertyDetail(){
		
		$current_property = $this->session->userdata('property_id');
		if($this->uri->total_segments() == 4):
			$this->session->set_userdata('property_id',$this->uri->segment(4));
			redirect('homeowner/'.$this->uri->segment(2).'/information');
		elseif(!$current_property && $this->uri->total_segments() == 3):
			redirect('homeowner/'.$this->uri->segment(2));
		endif;
		$this->load->model('properties');
		$this->load->model('images');
		$this->load->model('union');
		$pagevar = array(
			'select' => $this->union->selectOwnerProperties($this->account['id']),
			'property' => $this->properties->read_record($current_property,'properties'),
			'images' => $this->images->read_records($current_property)
		);
		if(!$pagevar['property']):
			show_error('Property missing');
		endif;
		$pagevar['property']['phone'] = $this->profile['phone'];
		$pagevar['property']['cell'] = $this->profile['cell'];
		$pagevar['property']['email'] = $this->profile['email'];
		
		if($pagevar['property']['owner'] == $this->account['id']):
			$this->session->set_userdata('current_property',$current_property);
		endif;
		$pagevar['property']['favorite'] = FALSE;
		$pagevar['property']['potentialby'] = FALSE;
		if($this->session->userdata('current_property')):
			$this->load->model('property_potentialby');
			$pagevar['property']['potentialby'] = $this->property_potentialby->record_exist($this->session->userdata('current_property'),$current_property);
			if(!$pagevar['property']['potentialby']):
				$this->load->model('property_favorite');
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
		$this->load->view("owner_interface/properties/property-detail",$pagevar);
	}
	
	public function edit_property(){

		$current_property = $this->session->userdata('property_id');
		if($this->uri->total_segments() == 4):
			$this->session->set_userdata('property_id',$this->uri->segment(4));
			redirect(OWNER_START_PAGE.'/edit');
		elseif(!$current_property && $this->uri->total_segments() == 3):
			redirect(OWNER_START_PAGE);
		endif;
		$this->load->model('properties');
		$this->load->model('images');
		$this->load->model('property_type');
		$pagevar = array(
			'property' => $this->properties->read_record($current_property,'properties'),
			'images' => $this->images->read_records($current_property,$this->account['id']),
			'property_type'=>$this->property_type->read_records('property_type')
		);
		if($pagevar['property']['owner'] != $this->account['id']):
			show_error('Access Denied!');
		endif;
		$this->load->view("owner_interface/properties/property-card",$pagevar);
	}

}