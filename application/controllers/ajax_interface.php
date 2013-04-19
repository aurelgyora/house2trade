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
				$dataval[$dataid[0]] = trim($dataid[1]);
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
							endif;
							$this->users->update_field($dataval['user_id'],'account',$ownerID,'users');
							$this->users->update_field($dataval['user_id'],'group',3,'users');
							$status = $this->users->read_field($this->account['id'],'users','status');
							$this->properties->update_field($property_id,'status',$status,'properties');
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
			$insert['photo'] = 'upload_images/'.$newFileName;
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
		echo json_encode(array('redirect'=>site_url(BROKER_START_PAGE.'/information')));
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
	
	/************************************** favorite & potential by **********************************************/
	
	function addToFavorite(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Access denied');
		endif;
		$property = $this->input->post('parameter');
		$json_request['message'] = '<img src="'.site_url('img/no-check.png').'" alt="" /> Error adding';
		if($property):
			$this->load->model('property_favorite');
			$this->load->model('properties');
			if($this->properties->record_exist('properties','id',$property) && !$this->property_favorite->record_exist($this->session->userdata('current_property'),$property)):
				$insert['seller_id'] = $this->session->userdata('current_property');
				$insert['buyer_id'] = $property;
				$this->property_favorite->insert_record($insert);
				$json_request['message'] = '<img src="'.site_url('img/check.png').'" alt="" /> Property added';
			endif;
		endif;
		echo json_encode($json_request);
	}
	
	function removeToFavorite(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Access denied');
		endif;
		$property = $this->input->post('parameter');
		$json_request['message'] = '<img src="'.site_url('img/no-check.png').'" alt="" /> Error removing';
		if($property):
			$this->load->model('property_favorite');
			$this->load->model('properties');
			$favoriteID = $this->property_favorite->record_exist($this->session->userdata('current_property'),$property);
			if($favoriteID):
				$this->property_favorite->delete_record($favoriteID,'property_favorite');
				$json_request['message'] = '<img src="'.site_url('img/check.png').'" alt="" /> Property removed from favorite';
			endif;
		endif;
		echo json_encode($json_request);
	}
	
	function addToPotentialBy(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Access denied');
		endif;
		$property = $this->input->post('parameter');
		$json_request['message'] = '<img src="'.site_url('img/no-check.png').'" alt="" /> Error adding';
		if($property):
			$this->load->model('property_potentialby');
			$this->load->model('properties');
			if($this->properties->record_exist('properties','id',$property) && !$this->property_potentialby->record_exist($this->session->userdata('current_property'),$property)):
				$insert['seller_id'] = $this->session->userdata('current_property');
				$insert['buyer_id'] = $property;
				$result = $this->property_potentialby->insert_record($insert);
				if($result):
					$this->load->model('property_favorite');
					$favoriteID = $this->property_favorite->record_exist($this->session->userdata('current_property'),$property);
					if($favoriteID):
						$this->property_favorite->delete_record($favoriteID,'property_favorite');
					endif;
				endif;
				$json_request['message'] = '<img src="'.site_url('img/check.png').'" alt="" /> Property added';
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
			$favoriteID = $this->property_potentialby->record_exist($this->session->userdata('current_property'),$property);
			if($favoriteID):
				$this->property_potentialby->delete_record($favoriteID,'property_potentialby');
				$json_request['message'] = '<img src="'.site_url('img/check.png').'" alt="" /> Property removed from potential by';
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
								$this->users->update_field($dataval['user_id'],'user_id',$brokerID,'users');
								$this->users->update_field($dataval['user_id'],'temporary_code',$activate_code,'users');
								$user_class = 'broker';
								break;
							case 3:
								$this->load->model('owners');
								$this->load->model('properties');
								$ownerID = $this->owners->insert_record($dataval);
								$this->users->update_field($dataval['user_id'],'user_id',$ownerID,'users');
								$this->users->update_field($dataval['user_id'],'class',3,'users');
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
				$dataval[$dataid[0]] = trim($dataid[1]);
			endfor;
			$this->load->model('owners');
			if($dataval && $this->owners->read_field($this->user['user_id'],'owners','seller')):
				$this->load->model('properties');
				if(!$this->properties->properties_exits($dataval['state'],$dataval['zip_code'])):
					$dataval['user_id'] = $this->user['uid'];
					$property_id = $this->properties->insert_record($dataval);
					$status = $this->users->read_field($this->user['uid'],'users','status');
					$this->properties->update_field($property_id,'status',$status,'properties');
					$json_request['status'] = TRUE;
					$this->session->set_userdata('property_id',$property_id);
				else:
					$json_request['message'] = '<img src="'.site_url("img/no-check.png").'" alt="" /> Property already exist';
				endif;
			endif;
		endif;
		echo json_encode($json_request);
	}
	
	function change_user_status(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$json_request = array('status'=>FALSE);
		$data = trim($this->input->post('postdata'));
		if($data):
			$currentStatus = $this->users->read_field($data,'users','status');
			if(!$currentStatus):
				$this->users->update_field($data,'status',1,'users');
				$this->users->update_field($data,'temporary_code','','users');
				$json_request['status'] = TRUE;
			else:
				$this->users->update_field($data,'status',0,'users');
				$json_request['status'] = FALSE;
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
				$dataval['password'] = $dataval['confirm'] = ''; //это пока не решат нужно ли управлять брокер паролем владельца
				$this->load->model('owners');
				$this->load->model('properties');
				if($this->user['class'] == 2):
					$broker = $this->properties->read_field($this->session->userdata('property_id'),'properties','broker_id');
					if($broker != $this->user['uid']):
						exit;
					endif;
				endif;
				if($dataval['password'] != $dataval['confirm']):
					$json_request['message'] = 'Passwords do not match';
				else:
					$json_request['status'] = TRUE;
					if(!isset($dataval['setpswd'])):
						if($this->user['class'] == 2):
							$this->owners->update_record($this->session->userdata('current_owner'),$dataval);
						endif;
						$this->properties->update_record($this->session->userdata('property_id'),$dataval);
					endif;
					switch($this->user['class']):
						case 2:	$json_request['redirect'] = site_url(BROKER_START_PAGE);
								break;
						case 3:	$json_request['redirect'] = site_url(OWNER_START_PAGE);
								break;
					endswitch;
					if(($this->user['class'] != 2) && !empty($dataval['password'])):
						$this->users->update_field($this->user['uid'],'password',md5($dataval['password']),'users');
					endif;
				endif;
			endif;
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
						switch($this->user['class']):
							case 2: $this->load->model('brokers');
									$dataval['id'] = $this->users->read_field($this->user['uid'],'users','user_id');
									$this->brokers->update_record($dataval);
									break;
							case 3: $this->load->model('owners');
									$owner = $this->users->read_field($this->user['uid'],'users','user_id');
									$this->owners->update_record($owner,$dataval);
									break;
						endswitch;
					endif;
					switch($this->user['class']):
						case 2: $json_request['redirect'] = site_url(BROKER_START_PAGE);
								break;
						case 3: $json_request['redirect'] = site_url(OWNER_START_PAGE);
								break;
					endswitch;
					if(!empty($dataval['password'])):
						$this->users->update_field($this->user['uid'],'password',md5($dataval['password']),'users');
					endif;
					unset($dataval['password']);unset($dataval['confirm']);unset($dataval['subcribe']);unset($dataval['id']);
					if(isset($dataval['company'])):
						$this->load->model('company');
						$dataval['company'] = $this->company->read_field($dataval['company'],'company','title');
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
			if($this->user['class'] == 2):
				$json_request['redirect'] = site_url(BROKER_START_PAGE);
				$current_owner = $this->session->userdata('current_owner');
			else:
				$json_request['redirect'] = site_url(OWNER_START_PAGE);
				$current_owner = $this->user['uid'];
			endif;
			$images = $this->images->read_records($property,$current_owner);
			for($i=0;$i<count($images);$i++):
				$this->filedelete($images[$i]['photo']);
			endfor;
			$this->images->delete_records($property,$this->user['uid']);
			$owner = $this->properties->read_field($property,'properties','owner_id');
			$ownerID = $this->users->read_field($owner,'users','user_id');
			$this->properties->delete_record($property,'properties');
			$this->users->delete_record($owner,'users');
			$this->owners->delete_record($ownerID,'owners');
			$json_request['status'] = TRUE;
			$this->session->unset_userdata(array('current_owner'=>'','property_id'=>''));
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
			$images = $this->images->read_records($property,$this->user['uid']);
			for($i=0;$i<count($images);$i++):
				$this->filedelete($images[$i]['photo']);
			endfor;
			$this->images->delete_records($property,$this->user['uid']);
			$this->properties->delete_record($property,'properties');
			$json_request['status'] = TRUE;
			$this->session->unset_userdata('property_id');
			$this->session->set_userdata('msgs','<img src="'.site_url('img/check.png').'" alt="" /> Property deleted');
		else:
			$json_request['message'] = '<img src="'.site_url('img/no-check.png').'" alt="" /> Error deleting<hr/>';
		endif;
		echo json_encode($json_request);
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
				$current_owner = $this->session->userdata('current_owner');
				if($this->user['class'] == 3):
					$current_owner = $this->user['uid'];
				endif;
				if($this->user['class'] == 2):
					$this->load->model('properties');
					$broker = $this->properties->read_field($this->session->userdata('property_id'),'properties','broker_id');
					if($broker != $this->user['uid']):
						exit;
					endif;
				endif;
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
					$images = $this->images->read_records($this->session->userdata('property_id'),$current_owner);
					if(isset($images[0]['id'])):
						$this->images->update_field($images[0]['id'],'main',1,'images');
					endif;
				endif;
				$json_request['status'] = TRUE;
			endif;
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
					$user_id = $this->users->read_field($uid,'users','user_id');
					$user_class = $this->users->read_field($uid,'users','class');
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
				if($this->user['class'] == 3):
					$json_request['redirect'] = site_url('homeowner/search/result');
				endif;
				$sql = 'SELECT users.id AS uid,users.email,users.status,owners.id AS oid,owners.fname,owners.lname,properties.*';
				$sql .= ' FROM users INNER JOIN owners ON users.user_id = owners.id INNER JOIN properties ON users.id = properties.owner_id';
				$sql .= ' WHERE TRUE';
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