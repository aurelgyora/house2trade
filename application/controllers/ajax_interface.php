<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_interface extends MY_Controller{
	
	function __construct(){
		
		parent::__construct();
	}
	
	function existEmail(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Access denied');
		endif;
		$json_request = array('status'=>FALSE);
		$parametr = trim($this->input->post('parametr'));
		if($parametr):
			if(!$this->users->record_exist('users','email',$parametr)):
				$json_request['status'] = TRUE;
			endif;
		else:
			$json_request['status'] = TRUE;
		endif;
		echo json_encode($json_request);
	}
	
	function getPropertyZillowAPI(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Access denied');
		endif;
		$json_request = array('status'=>FALSE,'result'=>array(),'messages'=>'');
		$json_request['messages'] = '<img src="'.site_url('img/no-check.png').'" alt="" /> nothing found';
		$address = trim($this->input->post('address'));
		$zip = trim($this->input->post('zip'));
		if($address && $zip):
			$json_request['result'] = $this->zillowApi($address,$zip);
			if($json_request['result']):
				$json_request['status'] = TRUE;
			endif;
		endif;
		echo json_encode($json_request);
	}
	
	function getPropertyImages($dataval,$property_id){
		
		$zillow_result = $this->zillowApi($dataval['address1'],$dataval['zip_code']);
		if($zillow_result):
			$this->load->model('images');
			$randomNumber = mt_rand(1,1000);
			$nextPropertyID = $this->images->nextID('images');
			$insert = array('main'=>0,'property_id'=>$property_id,'photo'=>'','owner_id'=>$dataval['user_id']);
			$images = $this->arrayImagesFromPage($zillow_result['page-content']);
			if($images):
				$dirPath = getcwd().'/upload_images/'.$dataval['zip_code'];
				if(!file_exists($dirPath) && !is_dir($dirPath)):
					mkdir($dirPath,0777);
				endif;
				$insert['main'] = 1;
				$newFileName = preg_replace('/.+(.)(\.)+/','property_'.$nextPropertyID.'_'.$randomNumber."\$2",$images[0]);
				file_put_contents($dirPath.'/'.$newFileName,file_get_contents($images[0]));
				$insert['photo'] = 'upload_images/'.$dataval['zip_code'].'/'.$newFileName;
				$this->images->insert_record($insert);
				$insert['main'] = 0;
				for($i=1;$i<count($images);$i++):
					if(isset($images[$i])):
						$nextPropertyID = $this->images->nextID('images');
						$randomNumber = mt_rand(1,1000);
						$newFileName = preg_replace('/.+(.)(\.)+/','property_'.$nextPropertyID.'_'.$randomNumber."\$2",$images[$i]);
						file_put_contents($dirPath.'/'.$newFileName,file_get_contents($images[$i]));
						$insert['photo'] = 'upload_images/'.$dataval['zip_code'].'/'.$newFileName;
						$this->images->insert_record($insert);
					endif;
				endfor;
			endif;
		endif;
	}
	
	/******************************************** company *******************************************************/
	
	function saveCompany(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$json_request = array('status'=>FALSE,'message'=>'Company saved','redirect'=>'');
		$data = trim($this->input->post('postdata'));
		if($data):
			$data = preg_split("/&/",$data);
			for($i=0;$i<count($data);$i++):
				$dataid = preg_split("/=/",$data[$i]);
				$dataval[$dataid[0]] = trim($dataid[1]);
			endfor;
			if($dataval):
				$this->load->model('company');
				if(isset($dataval['id'])):
					$this->company->update_record($dataval);
				else:
					$dataval['id'] = $this->company->insert_record($dataval);
				endif;
				if(isset($_FILES['logo'])):
					if($_FILES['logo']['error'] != 4):
						$photo = file_get_contents($_FILES['logo']['tmp_name']);
						if($photo && $dataval['id']):
							$this->company->update_field($dataval['id'],'logo',$photo,'company');
						endif;
					endif;
				endif;
				$json_request['status'] = TRUE;
				$json_request['redirect'] = site_url('administrator/companies');
			endif;
		endif;
		echo json_encode($json_request);
	}
	
	/******************************************** property *******************************************************/
	
	function signupProperty(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$json_request = array('status'=>FALSE,'message'=>'Signup is impossible');
		$data = trim($this->input->post('postdata'));
		if($data):
			$data = preg_split("/&/",$data);
			for($i=0;$i<count($data);$i++):
				$dataid = preg_split("/=/",$data[$i]);
				if(!isset($dataid[0]) || !isset($dataid[1])):
					$json_request['message'] = '<img src="'.site_url("img/no-check.png").'" alt="" /> An error while retrieving the data. try again';
					echo json_encode($json_request);
					exit();
				else:
					$dataval[trim($dataid[0])] = trim(htmlspecialchars($dataid[1]));
				endif;
			endfor;
			if($dataval):
				$this->load->model('properties');
				if(!$this->users->user_exist('email',$dataval['email'])):
					if(!$this->properties->properties_exits($dataval['state'],$dataval['zip_code'])):
						$this->load->helper('string');
						$dataval['password'] = random_string('alnum',12);
						$dataval['user_id'] = $this->users->insert_record($dataval);
						if($dataval['user_id']):
							$this->load->model('owners');
							$ownerID = $this->owners->insert_record($dataval);
							$property_id = $this->properties->insert_record($dataval);
							if($property_id):
								$this->getPropertyImages($dataval,$property_id);
							endif;
							$this->users->update_field($dataval['user_id'],'account',$ownerID,'users');
							$this->users->update_field($dataval['user_id'],'group',3,'users');
							$this->properties->update_field($property_id,'status',$this->profile['status'],'properties');
							$this->load->library('parser');
							$this->load->model('mails');
							$mail_content = $this->mails->read_record(2,'mails');
							$parser_data = array(
								'user_first_name' => $dataval['fname'],
								'user_last_name' => $dataval['lname'],
								'user_login' => $dataval['email'],
								'user_password' => $dataval['password'],
								'cabinet_link' => site_url('homeowner/profile')
							);
							$mailtext = $this->parser->parse($mail_content['file_path'],$parser_data,TRUE);
							$this->send_mail($dataval['email'],'robot@house2trade.com','House2Trade',$mail_content['subject'],$mailtext);
							$json_request['message'] = '<img src="'.site_url("img/check.png").'" alt="" /> The letter with registration confirmation was sent to homeowner email';
							$json_request['status'] = TRUE;
							$this->session->set_userdata(array('current_property'=>$property_id,'property_id'=>$property_id));
						endif;
					else:
						$json_request['message'] = '<img src="'.site_url("img/no-check.png").'" alt="" /> Property already exist';
					endif;
				else:
					$json_request['message'] = '<img src="'.site_url("img/no-check.png").'" alt="" /> Homeowner already exist';
				endif;
			endif;
		endif;
		echo json_encode($json_request);
	}
	
	function seller_signup_properties(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$json_request = array('status'=>FALSE,'message'=>'Signup is impossible');
		$data = trim($this->input->post('postdata'));
		if($data):
			$data = preg_split("/&/",$data);
			for($i=0;$i<count($data);$i++):
				$dataid = preg_split("/=/",$data[$i]);
				if(!isset($dataid[0]) || !isset($dataid[1])):
					$json_request['message'] = '<img src="'.site_url("img/no-check.png").'" alt="" /> An error while retrieving the data. try again';
					echo json_encode($json_request);
					exit();
				else:
					$dataval[trim($dataid[0])] = trim(htmlspecialchars($dataid[1]));
				endif;
			endfor;
			$this->load->model('owners');
			if($dataval && $this->owners->read_field($this->profile['account'],'owners','seller')):
				$this->load->model('properties');
				if(!$this->properties->properties_exits($dataval['state'],$dataval['zip_code'])):
					$dataval['user_id'] = $this->account['id'];
					$property_id = $this->properties->insert_record($dataval);
					if($property_id):
						$this->getPropertyImages($dataval,$property_id);
					endif;
					$this->properties->update_field($property_id,'status',1,'properties');
					$json_request['status'] = TRUE;
					$json_request['message'] = '<img src="'.site_url("img/check.png").'" alt="" /> Property added successfully';
					$this->session->set_userdata('property_id',$property_id);
				else:
					$json_request['message'] = '<img src="'.site_url("img/no-check.png").'" alt="" /> Property already exist';
				endif;
			endif;
		endif;
		echo json_encode($json_request);
	}
	
	function multiUpload(){
		
		$this->load->model('images');
		$this->load->model('properties');
		$randomNumber = mt_rand(1,1000);
		$nextPropertyID = $this->images->nextID('images');
		$insert = array('main'=>0,'property_id'=>0,'photo'=>'','owner_id'=>0);
		$insert['property_id'] = $this->session->userdata('property_id');
		$zipcode = $this->properties->read_field($insert['property_id'],'properties','zip_code');
		if(!$this->images->image_exist($insert['property_id'])):
			$insert['main'] = 1;
		endif;
		$fn = (isset($_SERVER['HTTP_X_FILENAME'])?$_SERVER['HTTP_X_FILENAME']:false);
		if($fn):
			$dirPath = getcwd().'/upload_images/'.$zipcode;
			if(!file_exists($dirPath) && !is_dir($dirPath)):
				mkdir($dirPath,0777);
			endif;
			$newFileName = preg_replace('/.+(.)(\.)+/','property_'.$nextPropertyID.'_'.$randomNumber."\$2",$fn);
			file_put_contents($dirPath.'/'.$newFileName,file_get_contents('php://input'));
			$insert['photo'] = 'upload_images/'.$zipcode.'/'.$newFileName;
			$this->images->insert_record($insert);
			echo "$fn uploaded";
			return TRUE;
		endif;
		return FALSE;
	}
	
	function setActiveProperty(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Access denied');
		endif;
		$property = $this->input->post('parameter');
		if($property):
			$this->session->set_userdata('current_property',$property);
			echo json_encode(array('redirect'=>site_url(BROKER_START_PAGE)));
		else:
			$this->session->unset_userdata('current_property');
			echo json_encode(array('redirect'=>site_url(BROKER_START_PAGE.'/full-list')));
		endif;
	}
	
	function setCurrentProperty(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Access denied');
		endif;
		$property = $this->input->post('parameter');
		if($property):
			$this->session->set_userdata('current_property',$property);
		endif;
		switch($this->account['group']):
			case 2: echo json_encode(array('redirect'=>site_url(BROKER_START_PAGE.'/information')));
				break;
			case 3: 
				if(!$this->session->userdata('search_sql')):
					$this->session->set_userdata('property_id',$property);
				endif;
				echo json_encode(array('redirect'=>site_url(OWNER_START_PAGE.'/information')));
				break;
			default: echo json_encode(array('redirect'=>site_url()));
		endswitch;
	}
	
	function setCurrentFavorite(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Access denied');
		endif;
		$property = $this->input->post('parameter');
		if($property):
			$this->session->set_userdata('current_property',$property);
		endif;
		echo json_encode(array('redirect'=>site_url($this->session->userdata('backpath'))));
	}
	
	function deletePropertyImages(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$json_request = array('status'=>FALSE,'message'=>'Images deleted');
		$data = trim($this->input->post('postdata'));
		if($data):
			$data = preg_split("/&/",$data);
			for($i=0;$i<count($data);$i++):
				$dataid = preg_split("/=/",$data[$i]);
				$dataval[$i] = trim($dataid[1]);
			endfor;
			if($dataval):
				$this->load->model('properties');
				$broker = $this->properties->read_field($this->session->userdata('property_id'),'properties','broker');
				$this->load->model('images');
				$mainPhotoDeleted = FALSE;
				for($i=0;$i<count($dataval);$i++):
					$image = $this->images->read_record($dataval[$i],'images');
					if($image['main']):
						$mainPhotoDeleted = TRUE;
					endif;
					$this->filedelete($image['photo']);
					$this->images->delete_record($image['id'],'images');
				endfor;
				if($mainPhotoDeleted):
					$images = $this->images->read_records($this->session->userdata('property_id'));
					if(isset($images[0]['id'])):
						$this->images->update_field($images[0]['id'],'main',1,'images');
					endif;
				endif;
				$json_request['status'] = TRUE;
			endif;
		endif;
		echo json_encode($json_request);
	}
	
	function save_property_info(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$json_request = array('status'=>FALSE,'message'=>'Property saved','redirect'=>'');
		$data = trim($this->input->post('postdata'));
		if($data):
			$data = preg_split("/&/",$data);
			for($i=0;$i<count($data);$i++):
				$dataid = preg_split("/=/",$data[$i]);
				$dataval[$dataid[0]] = trim($dataid[1]);
			endfor;
			if($dataval):
				$dataval['password'] = $dataval['confirm'] = '';
				$this->load->model('owners');
				$this->load->model('properties');
				if($this->account['group'] == 2):
					$broker = $this->properties->read_field($this->session->userdata('property_id'),'properties','broker');
					if($broker != $this->account['id']):
						exit;
					endif;
				endif;
				if($dataval['password'] != $dataval['confirm']):
					$json_request['message'] = 'Passwords do not match';
				else:
					$json_request['status'] = TRUE;
					if(!isset($dataval['setpswd'])):
						if($this->account['group'] == 2):
							$owner = $this->properties->read_field($this->session->userdata('property_id'),'properties','owner');
							$this->owners->update_record($owner,$dataval);
						endif;
						$this->properties->update_record($this->session->userdata('property_id'),$dataval);
					endif;
					switch($this->account['group']):
						case 2: $json_request['redirect'] = site_url(BROKER_START_PAGE); break;
						case 3: $json_request['redirect'] = site_url(OWNER_START_PAGE); break;
					endswitch;
					if(($this->account['group'] != 2) && !empty($dataval['password'])):
						$this->users->update_field($this->account['id'],'password',md5($dataval['password']),'users');
					endif;
				endif;
			endif;
		endif;
		echo json_encode($json_request);
	}
	
	function changePropertyStatus(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$json_request = array('status'=>FALSE);
		$propertyID = trim($this->input->post('property'));
		$statusValue = trim($this->input->post('status'));
		if($statusValue >= 0 && !empty($propertyID)):
			$isUpdate = FALSE;
			if($this->profile['group'] == 1):
				$isUpdate = TRUE;
			endif;
			if($this->profile['group'] == 2 && ($statusValue == 9 OR $statusValue == 11 OR $statusValue == 1)):
				$isUpdate = TRUE;
			endif;
			if($this->profile['group'] == 3 && ($statusValue == 9 OR $statusValue == 12 OR $statusValue == 1)):
				$isUpdate = TRUE;
			endif;
			if($isUpdate == TRUE):
				$this->load->model('properties');
				$this->properties->update_field($propertyID,'status',$statusValue,'properties');
				$json_request['status'] = TRUE;
			endif;
		endif;
		echo json_encode($json_request);
	}

	function changeDownPaymentValue(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$json_request = array('status'=>FALSE);
		$matchID = trim($this->input->post('match'));
		$valueDP = trim($this->input->post('value'));
		if($matchID > 0):
			$json_request['status'] = $this->setDownPaymentValue($matchID,$valueDP);
		endif;
		echo json_encode($json_request);
	}
	
	function changeMatchAndPropertyStatuses(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$json_request = array('status'=>FALSE,'message'=>'');
		$matchID = trim($this->input->post('match'));
		$status = trim($this->input->post('status'));
		if($matchID > 0):
			$result = $this->changeMatchStatusValue($matchID,$status);
			if($result['status'] == TRUE):
				$this->load->model('match');
				$match = $this->match->read_record($matchID,'match');
				$propertiesIDs = $this->getMatchPropertiesIDs($match);
				if($status == 2):
					$this->changePropertiesStatus(1,NULL,NULL,$propertiesIDs);
				else:
					$this->load->model('properties');
					if($result['approved_all'] == FALSE):
						$this->changePropertiesStatus(7,NULL,NULL,array($this->session->userdata('current_property')));
					else:
						$this->changePropertiesStatus(8,NULL,NULL,array($this->session->userdata('current_property')));
					endif;
				endif;
			endif;
			$json_request['status'] = $result['status'];
			$json_request['message'] = $result['message'];
		endif;
		echo json_encode($json_request);
	}
	
	/************************************** favorite & potential by **********************************************/
	
	function addToFavorite(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Access denied');
		endif;
		$property = $this->input->post('parameter');
		$json_request['status'] = FALSE;
		$json_request['message'] = '<img src="'.site_url('img/no-check.png').'" alt="" /> Error adding';
		if($property):
			$this->load->model('property_favorite');
			$this->load->model('properties');
			$propertyID = $this->properties->record_exist('properties','id',$property);
			if($propertyID && !$this->property_favorite->record_exist($this->session->userdata('current_property'),$property)):
				$propertyStatus = $this->properties->read_field($propertyID,'properties','status');
				if($propertyStatus != 17):
					$this->load->model('property_potentialby');
					if(!$this->property_potentialby->record_exist($this->session->userdata('current_property'),$property)):
						$insert['seller_id'] = $this->session->userdata('current_property');
						$insert['buyer_id'] = $property;
						$this->property_favorite->insert_record($insert);
						$json_request['status'] = TRUE;
						$json_request['message'] = '<img src="'.site_url('img/check.png').'" alt="" /> Property added';
					endif;
				endif;
			endif;
		endif;
		echo json_encode($json_request);
	}
	
	function removeToFavorite(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Access denied');
		endif;
		$property = $this->input->post('parameter');
		$json_request['status'] = FALSE;
		$json_request['message'] = '<img src="'.site_url('img/no-check.png').'" alt="" /> Error removing';
		if($property):
			$this->load->model('property_favorite');
			$this->load->model('properties');
			$favoriteID = $this->property_favorite->record_exist($this->session->userdata('current_property'),$property);
			if($favoriteID):
				$this->property_favorite->delete_record($favoriteID,'property_favorite');
				$json_request['status'] = TRUE;
				$json_request['message'] = '<img src="'.site_url('img/check.png').'" alt="" /> Property removed from favorite';
			endif;
		endif;
		echo json_encode($json_request);
	}
	
	function addToPotentialBy(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Access denied');
		endif;
		$property = (int)$this->input->post('parameter');
		$down_payment = (int)$this->input->post('down_payment');
		$json_request['message'] = '<img src="'.site_url('img/no-check.png').'" alt="" /> Property not add to potential by';
		if($property):
			$this->load->model('property_potentialby');
			$this->load->model('properties');
			if($this->properties->record_exist('properties','id',$property) && !$this->property_potentialby->record_exist($this->session->userdata('current_property'),$property)):
				$insert['seller_id'] = $this->session->userdata('current_property');
				$insert['buyer_id'] = $property;
				if(!empty($down_payment) && $down_payment > 100):
					$down_payment = 100;
				endif;
				$insert['down_payment'] = (!empty($down_payment))?$down_payment:0;
				$propertyStatus = $this->properties->read_field($insert['buyer_id'],'properties','status');
				if($propertyStatus != 17):
					$result = $this->property_potentialby->insert_record($insert);
					if($result):
						$this->load->model('property_favorite');
						$favoriteID = $this->property_favorite->record_exist($this->session->userdata('current_property'),$property);
						if($favoriteID):
							$this->property_favorite->delete_record($favoriteID,'property_favorite');
						endif;
						$this->changePropertiesStatus(0,$insert['seller_id'],$insert['buyer_id']);
					endif;
					$json_request['message'] = '<img src="'.site_url('img/check.png').'" alt="" /> Property added to potential by<br/><br/>At the moment you have selected the prefered property and you also have potential buyer. So you can wait for a match. As soon as the match will be ready you will get email notification.';
				endif;
			endif;
		endif;
		echo json_encode($json_request);
	}
	
	function removeToPotentialBy(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Access denied');
		endif;
		$property = $this->input->post('parameter');
		$json_request['message'] = '<img src="'.site_url('img/no-check.png').'" alt="" /> Error removing';
		if($property):
			$this->load->model('property_potentialby');
			$this->load->model('properties');
			$potentialByID = $this->property_potentialby->record_exist($this->session->userdata('current_property'),$property);
			if($potentialByID):
				$this->property_potentialby->delete_record($potentialByID,'property_potentialby');
				$json_request['message'] = '<img src="'.site_url('img/check.png').'" alt="" /> Property removed from potential by';
				$changeStatus = TRUE;
				if($this->property_potentialby->record_exist($this->session->userdata('current_property'),NULL)):
					$changeStatus = FALSE;
				endif;
				if($this->property_potentialby->record_exist(NULL,$this->session->userdata('current_property'))):
					$changeStatus = FALSE;
				endif;
				if($changeStatus):
					$this->properties->update_field($this->session->userdata('current_property'),'status',1,'properties');
				endif;
				$changeStatus = TRUE;
				if($this->property_potentialby->record_exist($property,NULL)):
					$changeStatus = FALSE;
				endif;
				if($this->property_potentialby->record_exist(NULL,$property)):
					$changeStatus = FALSE;
				endif;
				if($changeStatus):
					$this->properties->update_field($property,'status',1,'properties');
				endif;
			endif;
		endif;
		echo json_encode($json_request);
	}
	
	/******************************************** accounts *******************************************************/
	
	function login(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$json_request = array('status'=>FALSE,'message'=>'Login is impossible','redirect'=>base_url());
		$data = trim($this->input->post('postdata'));
		if($data):
			$data = preg_split("/&/",$data);
			for($i=0;$i<count($data);$i++):
				$dataid = preg_split("/=/",$data[$i]);
				$dataval[$i] = trim($dataid[1]);
			endfor;
			if($dataval):
				$user = $this->users->signIN($dataval[0],$dataval[1]);
				if($user):
					$json_request['status'] = TRUE;
					$json_request['message'] = '';
					$account = json_encode(array('id'=>$user['id'],'group'=>$user['group']));
					$this->session->set_userdata(array('logon'=>md5($dataval[0]),'account'=>$account));
					switch($user['group']):
						case 1: $json_request['redirect'] .= ADM_START_PAGE; break;
						case 2: $json_request['redirect'] .= BROKER_START_PAGE; break;
						case 3: $json_request['redirect'] .= OWNER_START_PAGE; break;
					endswitch;
				endif;
			endif;
		endif;
		echo json_encode($json_request);
	}

	function signup_account(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$json_request = array('status'=>FALSE,'error'=>FALSE,'email'=>FALSE,'message'=>'');
		$data = trim($this->input->post('postdata'));
		if($data):
			$data = preg_split("/&/",$data);
			for($i=0;$i<count($data);$i++):
				$dataid = preg_split("/=/",$data[$i]);
				$dataval[$dataid[0]] = trim($dataid[1]);
			endfor;
			if($dataval):
				if(!$this->users->user_exist('email',$dataval['email'])):
					$dataval['user_id'] = $this->users->insert_record($dataval);
					$this->load->helper('string');
					$activate_code = random_string('alpha',25);
					if($dataval['user_id']):
						switch($dataval['class']):
							case 2:
								$this->load->model('brokers');
								$brokerID = $this->brokers->insert_record($dataval);
								$this->users->update_field($dataval['user_id'],'account',$brokerID,'users');
								$this->users->update_field($dataval['user_id'],'temporary_code',$activate_code,'users');
								$user_class = 'broker';
								break;
							case 3:
								$this->load->model('owners');
								$this->load->model('properties');
								$ownerID = $this->owners->insert_record($dataval);
								$this->users->update_field($dataval['user_id'],'account',$ownerID,'users');
								$this->users->update_field($dataval['user_id'],'group',3,'users');
								$this->users->update_field($dataval['user_id'],'temporary_code',$activate_code,'users');
								$user_class = 'homeowner';
								break;
						endswitch;
						$this->load->library('parser');
						$this->load->model('mails');
						$mail_content = $this->mails->read_record(1,'mails');
						$parser_data = array(
							'user_first_name' => $dataval['fname'],
							'user_last_name' => $dataval['lname'],
							'confirm_link' => site_url('confirm-registering/'.$user_class.'/activation-code/'.$activate_code)
						);
						$mailtext = $this->parser->parse($mail_content['file_path'],$parser_data,TRUE);
						$this->send_mail($dataval['email'],'robot@house2trade.com','House2Trade',$mail_content['subject'],$mailtext);
						$json_request['status'] = TRUE;
						$json_request['message'] = '<img src="'.site_url("img/check.png").'" alt="" /> The letter with registration confirmation was sent to your email';
					endif;
				else:
					$json_request['email'] = TRUE;
				endif;
			endif;
		endif;
		echo json_encode($json_request);
	}

	function changeUserStatus(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		if(!$this->loginstatus || $this->account['group'] > 1):
			show_error('Аccess denied');
		endif;
		$json_request = array('status'=>FALSE);
		$accountID = trim($this->input->post('postdata'));
		if($accountID > 0):
			$status = $this->users->read_field($accountID,'users','status');
			if($status == 0):
				$status = 1;
				$this->users->update_field($accountID,'status',$status,'users');
				$this->users->update_field($accountID,'temporary_code','','users');
				$json_request['status'] = TRUE;
			else:
				$status = 0;
				$this->users->update_field($accountID,'status',$status,'users');
				$json_request['status'] = FALSE;
			endif;
			$this->load->model('properties');
			$this->properties->changeStatusOfManyProperties($accountID,$status);
		endif;
		echo json_encode($json_request);
	}
	
	function saveProfile(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$json_request = array('status'=>FALSE,'message'=>'Profile saved','new_data'=>array(),'redirect'=>'');
		$data = trim($this->input->post('postdata'));
		if($data):
			$data = preg_split("/&/",$data);
			for($i=0;$i<count($data);$i++):
				$dataid = preg_split("/=/",$data[$i]);
				$dataval[$dataid[0]] = trim($dataid[1]);
			endfor;
			if($dataval):
				if($dataval['password'] != $dataval['confirm']):
					$json_request['message'] = 'Passwords do not match';
				else:
					$json_request['status'] = TRUE;
					if(!isset($dataval['setpswd'])):
						$dataval['id'] = $this->users->read_field($this->account['id'],'users','account');
						switch($this->account['group']):
							case 2: $this->load->model('brokers');$this->brokers->update_record($dataval);break;
							case 3: $this->load->model('owners');$this->owners->update_record($dataval);break;
						endswitch;
					endif;
					switch($this->account['group']):
						case 2: $json_request['redirect'] = site_url(BROKER_START_PAGE);
								break;
						case 3: $json_request['redirect'] = site_url(OWNER_START_PAGE);
								break;
					endswitch;
					if(!empty($dataval['password'])):
						$this->users->update_field($this->account['id'],'password',md5($dataval['password']),'users');
					endif;
					unset($dataval['password']);unset($dataval['confirm']);unset($dataval['subcribe']);unset($dataval['id']);
					if(isset($dataval['company'])):
						$this->load->model('company');
						$dataval['company'] = $this->company->read_field($dataval['company'],'company','title');
						if(empty($dataval['compant'])):
							$dataval['company'] = 'The company is not listed';
						endif;
					endif;
					$json_request['new_data'] = $dataval;
				endif;
			endif;
		endif;
		echo json_encode($json_request);
	}
	
	function deleteProperty(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Access denied');
		endif;
		$property = $this->input->post('parameter');
		$json_request = array('status'=>FALSE,'redirect'=>'','messages'=>'');
		if($property):
			$this->load->model('images');
			$this->load->model('properties');
			$this->load->model('owners');
			if($this->account['group'] == 2):
				$json_request['redirect'] = site_url(BROKER_START_PAGE);
			else:
				$json_request['redirect'] = site_url(OWNER_START_PAGE);
			endif;
			$images = $this->images->read_records($property);
			for($i=0;$i<count($images);$i++):
				$this->filedelete($images[$i]['photo']);
			endfor;
			$this->images->delete_records($property);
			$owner = $this->properties->read_field($property,'properties','owner');
			$ownerID = $this->users->read_field($owner,'users','account');
			$this->properties->delete_record($property,'properties');
			$this->users->delete_record($owner,'users');
			$this->owners->delete_record($ownerID,'owners');
			$json_request['status'] = TRUE;
			$this->session->unset_userdata(array('current_property'=>'','property_id'=>''));
			$this->session->set_userdata('msgs','<img src="'.site_url('img/check.png').'" alt="" /> Property deleted');
		else:
			$json_request['message'] = '<img src="'.site_url('img/no-check.png').'" alt="" /> Error deleting<hr/>';
		endif;
		echo json_encode($json_request);
	}
	
	function deletePropertySeller(){

		if(!$this->input->is_ajax_request()):
			show_error('Access denied');
		endif;
		$property = $this->input->post('parameter');
		$json_request = array('status'=>FALSE,'redirect'=>site_url(OWNER_START_PAGE),'messages'=>'');
		if($property):
			$this->load->model('images');
			$this->load->model('properties');
			$images = $this->images->read_records($property,$this->account['id']);
			for($i=0;$i<count($images);$i++):
				$this->filedelete($images[$i]['photo']);
			endfor;
			$this->images->delete_records($property,$this->account['id']);
			$this->properties->delete_record($property,'properties');
			$json_request['status'] = TRUE;
			$this->session->unset_userdata('property_id');
			$this->session->set_userdata('msgs','<img src="'.site_url('img/check.png').'" alt="" /> Property deleted');
		else:
			$json_request['message'] = '<img src="'.site_url('img/no-check.png').'" alt="" /> Error deleting<hr/>';
		endif;
		echo json_encode($json_request);
	}
	
	function send_forgot_password(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$json_request = array('status'=>FALSE,'error'=>FALSE,'email'=>FALSE,'message'=>'');
		$data = trim($this->input->post('postdata'));
		if($data):
			$data = preg_split("/&/",$data);
			for($i=0;$i<count($data);$i++):
				$dataid = preg_split("/=/",$data[$i]);
				$dataval[$dataid[0]] = trim($dataid[1]);
			endfor;
			if($dataval):
				$uid = $this->users->user_exist('email',$dataval['email']);
				if($uid):
					$user_id = $this->users->read_field($uid,'users','account');
					$user_class = $this->users->read_field($uid,'users','group');
					$this->load->helper('string');
					$activate_code = random_string('alpha',25);
					$this->users->update_field($uid,'temporary_code',$activate_code,'users');
					if($user_id):
						switch($user_class):
							case 2:
								$this->load->model('brokers');
								$user_name = $this->brokers->read_name($user_id,'brokers');
								$user_class = 'broker';
								break;
							case 3:
								$this->load->model('owners');
								$user_name = $this->owners->read_name($user_id,'owners');
								$user_class = 'homeowner';
								break;
						endswitch;
						$this->load->library('parser');
						$this->load->model('mails');
						$mail_content = $this->mails->read_record(4,'mails');
						$parser_data = array(
							'user_name' => $user_name,
							'recovery_link' => site_url('password-recovery/'.$user_class.'/temporary-code/'.$activate_code)
						);
						$mailtext = $this->parser->parse($mail_content['file_path'],$parser_data,TRUE);
						$this->send_mail($dataval['email'],'robot@house2trade.com','House2Trade',$mail_content['subject'],$mailtext);
						$json_request['status'] = TRUE;
						$json_request['message'] = '<img src="'.site_url("img/check.png").'" alt="" /> Letter from further action was sent to your email';
					endif;
				else:
					$json_request['email'] = TRUE;
				endif;
			endif;
		endif;
		echo json_encode($json_request);
	}
	
	function searchProperty(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Access denied');
		endif;
		$data = $this->input->post('postdata');
		$json_request = array('status'=>FALSE,'redirect'=>site_url('broker/search/result'),'messages'=>'');
		if($data):
			$data = preg_split("/&/",$data);
			for($i=0;$i<count($data);$i++):
				$dataid = preg_split("/=/",$data[$i]);
				$dataval[$dataid[0]] = trim($dataid[1]);
			endfor;
			if($dataval):
				if($this->account['group'] == 3):
					$json_request['redirect'] = site_url('homeowner/search/result');
				endif;
				$sql = 'SELECT properties.* FROM properties WHERE TRUE';
				if(!empty($dataval['property_address'])):
					$sql .= ' AND properties.address1 LIKE "%'.$dataval['property_address'].'%"';
				endif;
				if(!empty($dataval['property_zip'])):
					$sql .= ' AND (properties.state LIKE "%'.$dataval['property_zip'].'%" OR properties.city LIKE "%'.$dataval['property_zip'].'%" OR properties.zip_code LIKE "%'.$dataval['property_zip'].'%")';
				endif;
				if(!empty($dataval['beds_num'])):
					$sql .= ' AND properties.bedrooms = '.$dataval['beds_num'];
				endif;
				if(!empty($dataval['baths_num'])):
					$sql .= ' AND properties.bathrooms = '.$dataval['baths_num'];
				endif;
				if(!empty($dataval['property_min_price'])):
					$sql .= ' AND properties.price >= '.$dataval['property_min_price'];
				endif;
				if(!empty($dataval['property_max_price'])):
					$sql .= ' AND properties.price <= '.$dataval['property_max_price'];
				endif;
				if(!empty($dataval['square_feet'])):
					$sql .= ' AND properties.sqf >= '.$dataval['square_feet'];
				endif;
				if(!empty($dataval['type'])):
					$sql .= ' AND properties.type = '.$dataval['type'];
				endif;
				$sql .= ' ORDER BY properties.address1 ASC, properties.state ASC, properties.zip_code ASC';
				$this->load->model('properties');
				$properties = $this->properties->query_execute($sql);
				$zillow_result = FALSE;
				if(!empty($dataval['property_address']) && !empty($dataval['property_zip'])):
					$this->session->set_userdata(array('zillow_address'=>$dataval['property_address'],'zillow_zip'=>$dataval['property_zip']));
					$zillow_result = $this->zillowApi($dataval['property_address'],$dataval['property_zip']);
				else:
					$this->session->unset_userdata(array('zillow_address'=>'','zillow_zip'=>''));
				endif;
				if($properties || $zillow_result):
					$this->session->set_userdata('search_sql',$sql);
					$this->session->set_userdata('search_json_data',json_encode($dataval));
					$json_request['status'] = TRUE;
				else:
					$json_request['message'] = '<img src="'.site_url('img/no-check.png').'" alt="" /> nothing found';
				endif;
			endif;
		endif;
		echo json_encode($json_request);
	}

}