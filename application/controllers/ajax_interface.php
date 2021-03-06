<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_interface extends MY_Controller {
	
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
		$json_request = array('status'=>FALSE,'result'=>array(),'messages'=>'','question'=>FALSE);
		$json_request['messages'] = '<img src="'.site_url('img/no-check.png').'" alt="" /> nothing found';
		if($json_request['result'] = $this->zillowApi($this->input->post('address'),$this->input->post('city').' '.$this->input->post('state').' '.$this->input->post('zip'))):
			if($json_request['result']['property-address1'] != $this->input->post('address')):
				$json_request['question'] = TRUE;
				$json_request['messages'] = 'The requested address is different from '.$json_request['result']['property-address1']."\nIs it your property?";
			endif;
			$json_request['status'] = TRUE;
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
	/********************************************** OWNER *******************************************************/
	function showDetailProperty(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Access denied');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>site_url());
		if($this->input->post('parameter') !== FALSE):
			$this->session->set_userdata('current_property',$this->input->post('parameter'));
			switch($this->account['group']):
				case 2: $json_request['redirect'] = site_url(BROKER_START_PAGE.'/information'); break;
				case 3: 
					if(!$this->session->userdata('search_sql')):
						$this->session->set_userdata('property_id',$this->input->post('parameter'));
					endif;
					$json_request['redirect'] = site_url(OWNER_START_PAGE.'/information');
					break;
			endswitch;
			$json_request['status'] = TRUE;
		endif;
		echo json_encode($json_request);
	}
	
	function setActiveProperty(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Access denied');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>site_url());
		if($this->input->post('parameter')  !== FALSE):
			$this->session->set_userdata('current_property',$this->input->post('parameter'));
			if($this->session->userdata('backpath') !== FALSE):
				$json_request['redirect'] = $this->session->userdata('backpath');
			elseif(isset($_SERVER['HTTP_REFERER'])):
				$json_request['redirect'] = $_SERVER['HTTP_REFERER'];
			else:
				$json_request['redirect'] = ($this->account['group'] == 2)?BROKER_START_PAGE:OWNER_START_PAGE;
			endif;
			$json_request['status'] = TRUE;
		endif;
		echo json_encode($json_request);
	}
	
	function showPropertiesList(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Access denied');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'','redirect'=>site_url());
		if($this->input->post('parameter') !== FALSE):
			$this->session->set_userdata('current_property',$this->input->post('parameter'));
			$json_request['redirect'] = site_url(BROKER_START_PAGE);
			$json_request['status'] = TRUE;
		endif;
		echo json_encode($json_request);
	}
	
	function setCurrentProperty(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Access denied');
		endif;
		$json_request = array('status'=>FALSE,'responseText'=>'');
		if($this->input->post('parameter') !== FALSE):
			$this->session->set_userdata('current_property',$this->input->post('parameter'));
			$json_request['status'] = TRUE;
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
	function propertyExist(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$json_request = array('status'=>TRUE,'message'=>'');
		if($propertyData = $this->getPropertySingUpData($this->input->post('postdata'))):
			$this->load->model('properties');
			if($propertyID = $this->properties->properties_exits($propertyData['state'],$propertyData['zip_code'])):
				if($this->account['group'] == 2):
					$json_request['message'] = 'Property already exists. You can check it '.anchor(BROKER_START_PAGE.'/information/'.$propertyID,'here',array('target'=>'_blank')).'.';
				elseif($this->account['group'] == 3):
					$json_request['message'] = 'Property already exists. You can check it '.anchor(OWNER_START_PAGE.'/information/'.$propertyID,'here',array('target'=>'_blank')).'.';
				else:
					$json_request['message'] = 'Property already exists.';
				endif;
				$json_request['status'] = FALSE;
			endif;
		endif;
		echo json_encode($json_request);
	}
	
	function signupProperty(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$json_request = array('status'=>FALSE,'message'=>'Signup is impossible');
		if($propertyData = $this->getPropertySingUpData($this->input->post('postdata'))):
			$this->load->model(array('properties','desired_properties','owners'));
			if(!$this->properties->properties_exits($propertyData['state'],$propertyData['zip_code'])):
				$registerNewUser = FALSE;
				if(!$accountID = $this->users->user_exist('email',$propertyData['email'])):
					$this->load->helper('string');
					$propertyData['password'] = random_string('alnum',12);
					$accountID = $this->users->insert_record($propertyData);
					$ownerID = $this->owners->insert_record($propertyData);
					$this->users->update_field($accountID,'account',$ownerID,'users');
					$this->users->update_field($accountID,'group',3,'users');
					$this->parseAndSendMail(2,array(
						'email'=>$propertyData['email'],'user_first_name'=>$propertyData['fname'],'user_last_name'=>$propertyData['lname'],
						'user_login'=>$propertyData['email'],'user_password'=>$propertyData['password'],'cabinet_link'=>site_url(OWNER_START_PAGE)
					));
					$registerNewUser = TRUE;
					$json_request['message'] = 'Your property successfully added to our database. Now you can add photos of your property or you can do it later.<br/>The letter with registration confirmation was sent to homeowner email';
				endif;
				if($accountID):
					$propertyData['user_id'] = $accountID;
					if($propertyID = $this->properties->insert_record($propertyData)):
						$this->getPropertyImages($propertyData,$propertyID);
						$propertyData['desired_property_id'] = $propertyID;
						$this->desired_properties->insert_record($propertyData);
					endif;
					$this->properties->update_field($propertyID,'status',$this->profile['status'],'properties');
					$json_request['status'] = TRUE;
					$this->session->set_userdata(array('current_property'=>$propertyID,'property_id'=>$propertyID));
					if($registerNewUser === FALSE):
						$json_request['message'] = 'Your property successfully added to our database. Now you can add photos of your property or you can do it later.';
					endif;
				endif;
			else:
				$json_request['message'] = 'Property already exist';
			endif;
		endif;
		echo json_encode($json_request);
	}
	
	function sellerSignupProperties(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$json_request = array('status'=>FALSE,'message'=>'Signup is impossible');
		if($propertyData = $this->getPropertySingUpData($this->input->post('postdata'))):
			$this->load->model(array('properties','desired_properties'));
			if(!$this->properties->properties_exits($propertyData['state'],$propertyData['zip_code'])):
				$propertyData['user_id'] = $this->account['id'];
				if($propertyID = $this->properties->insert_record($propertyData)):
					$this->getPropertyImages($propertyData,$propertyID);
					$propertyData['desired_property_id'] = $propertyID;
					$this->desired_properties->insert_record($propertyData);
				endif;
				$this->properties->update_field($propertyID,'status',$this->profile['status'],'properties');
				$json_request['status'] = TRUE;
				$this->session->set_userdata(array('current_property'=>$propertyID,'property_id'=>$propertyID));
				$json_request['message'] = 'Property added';
			else:
				$json_request['message'] = 'Property already exist';
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
	
	function saveMainProperty(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$json_request = array('status'=>FALSE,'message'=>'Property not saved','redirect'=>'');
		if($data = trim($this->input->post('postdata'))):
			$propertyData = array();
			$data = preg_split("/&/",$data);
			for($i=0;$i<count($data);$i++):
				$dataid = preg_split("/=/",$data[$i]);
				$propertyData[$dataid[0]] = trim($dataid[1]);
			endfor;
			if($propertyData):
				$this->load->model(array('owners','properties'));
				if($this->account['group'] == 2):
					$broker = $this->properties->read_field($this->session->userdata('property_id'),'properties','broker');
					if($broker != $this->account['id']):
						$json_request['message'] = 'Аccess denied';
						echo json_encode($json_request);
						exit;
					endif;
				endif;
				if($this->account['group'] == 2):
					if($accountID = $this->properties->read_field($this->session->userdata('property_id'),'properties','owner')):
						$ownerID = $this->users->read_field($accountID,'users','account');
						$this->owners->update_field($ownerID,'fname',$propertyData['fname'],'owners');
						$this->owners->update_field($ownerID,'lname',$propertyData['lname'],'owners');
						$this->owners->update_field($ownerID,'phone',$propertyData['phone'],'owners');
					endif;
				endif;
				$this->properties->update_record($this->session->userdata('property_id'),$propertyData);
				$json_request['status'] = TRUE;
				$json_request['message'] = 'Property saved';
			endif;
		endif;
		echo json_encode($json_request);
	}
	
	function saveDisaredProperty(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$json_request = array('status'=>FALSE,'message'=>'Property not saved','redirect'=>'');
		if($data = trim($this->input->post('postdata'))):
			$propertyData = array();
			$data = preg_split("/&/",$data);
			for($i=0;$i<count($data);$i++):
				$dataid = preg_split("/=/",$data[$i]);
				$propertyData[$dataid[0]] = trim($dataid[1]);
			endfor;
			if($propertyData):
				$this->load->model(array('desired_properties','properties'));
				if($desiredProperty = $this->desired_properties->getDesiredByPropertyID($this->session->userdata('property_id'))):
					if($this->account['group'] == 2):
						$broker = $this->desired_properties->read_field($desiredProperty['id'],'desired_properties','broker');
						if($broker != $this->account['id']):
							$json_request['message'] = 'Аccess denied';
							echo json_encode($json_request);
							exit;
						endif;
					endif;
					$json_request['status'] = TRUE;
					$json_request['message'] = 'Desired property saved';
					$this->desired_properties->update_record($desiredProperty['id'],$propertyData);
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
					$this->changePotentialBuyStatus($matchID);
					$this->sendMultiMailsPropertiesIDs(9,$propertiesIDs);
				else:
					$this->load->model('properties');
					if($result['approved_all'] == FALSE):
						$this->changePropertiesStatus(7,NULL,NULL,array($this->session->userdata('current_property')));
						$this->sendMultiMailsPropertiesIDs(7,$propertiesIDs);
					else:
						$this->changePropertiesStatus(8,NULL,NULL,array($this->session->userdata('current_property')));
						$this->sendMultiMailsPropertiesIDs(8,$propertiesIDs);
					endif;
				endif;
			endif;
			$json_request['status'] = $result['status'];
			$json_request['message'] = $result['message'];
		endif;
		echo json_encode($json_request);
	}
	
	private function getPropertySingUpData($post = NULL){
		
		if(!is_null($post)):
			$post = preg_split("/&/",$post);
			$dataval = array();
			for($i=0;$i<count($post);$i++):
				$dataid = preg_split("/=/",$post[$i]);
				if(!isset($dataid[0]) || !isset($dataid[1])):
					$json_request['message'] = 'An error while retrieving the data. try again';
					echo json_encode($json_request);
					exit();
				else:
					$dataval[trim($dataid[0])] = trim(htmlspecialchars($dataid[1]));
				endif;
			endfor;
			if($dataval):
				return $dataval;
			endif;
		endif;
		return FALSE;
	}
	/************************************** favorite & potential buy **********************************************/
	function excludeProperty(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Access denied');
		endif;
		$json_request['status'] = FALSE;
		$json_request['message'] = '<img src="'.site_url('img/no-check.png').'" alt="" /> Error removing';
		if($this->input->post('parameter') !== FALSE):
			$this->load->model('excluded_properties');
			$this->excluded_properties->insert_record($this->input->post('parameter'));
			$sql = $this->createSearchSQL(json_decode($this->session->userdata('search_json_data'),TRUE));
			$this->session->set_userdata('search_sql',$sql);
			$json_request['status'] = TRUE;
		endif;
		echo json_encode($json_request);
	}
	
	function addToFavorite(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Access denied');
		endif;
		$property = $this->input->post('parameter');
		$json_request['status'] = FALSE;
		$json_request['message'] = '<img src="'.site_url('img/no-check.png').'" alt="" /> Error adding';
		if($property):
			$this->load->model(array('property_favorite','properties'));
			$propertyID = $this->properties->record_exist('properties','id',$property);
			if($propertyID && !$this->property_favorite->record_exist($this->session->userdata('current_property'),$property)):
				$this->load->model('property_potentialby');
				if(!$this->property_potentialby->record_exist($this->session->userdata('current_property'),$property)):
					$insert['seller_id'] = $this->session->userdata('current_property');
					$insert['buyer_id'] = $property;
					$this->property_favorite->insert_record($insert);
					if($this->properties->read_field($propertyID,'properties','status') == 17):
						$this->sendMailBySellerAndBuyerPropertyID(6,$insert['seller_id'],$insert['buyer_id']);
					endif;
					$json_request['status'] = TRUE;
					$json_request['message'] = '<img src="'.site_url('img/check.png').'" alt="" /> Property added';
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
		$json_request['message'] = '<img src="'.site_url('img/no-check.png').'" alt="" /> Property not add to potential buy';
		if($property):
			$this->load->model(array('property_potentialby','properties'));
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
						$this->sendMailBySellerAndBuyerPropertyID(5,$insert['seller_id'],$insert['buyer_id']);
					endif;
					$json_request['message'] = '<img src="'.site_url('img/check.png').'" alt="" /> Property added to potential buy<br/><br/>At the moment you have selected the prefered property and you also have potential buyer. So you can wait for a match. As soon as the match will be ready you will get email notification.';
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
				$json_request['message'] = '<img src="'.site_url('img/check.png').'" alt="" /> Property removed from potential buy';
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
				$this->sendMailBySellerAndBuyerPropertyID(10,$this->session->userdata('current_property'),$property);
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
						$this->parseAndSendMail(1,array(
							'email'=>$dataval['email'],'user_first_name' => $dataval['fname'],
							'user_last_name' => $dataval['lname'],
							'confirm_link' => site_url('confirm-registering/'.$user_class.'/activation-code/'.$activate_code))
						);
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
		if($data = trim($this->input->post('postdata'))):
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
						if($companyTitle = $this->company->read_field($dataval['company'],'company','title')):
							$dataval['company'] = $companyTitle;
						else:
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
		$json_request = array('status'=>FALSE,'redirect'=>'','messages'=>'');
		if($propertyID = $this->input->post('parameter')):
			$this->load->model(array('images','properties','owners','desired_properties'));
			if($this->account['group'] == 2):
				$json_request['redirect'] = site_url(BROKER_START_PAGE);
			else:
				$json_request['redirect'] = site_url(OWNER_START_PAGE);
			endif;
			if($this->account['group'] == 2 || $this->owner['seller']):
				$images = $this->images->read_records($propertyID);
				for($i=0;$i<count($images);$i++):
					$this->filedelete($images[$i]['photo']);
				endfor;
				$this->images->delete_records($propertyID);
				$owner = $this->properties->read_field($propertyID,'properties','owner');
				$ownerID = $this->users->read_field($owner,'users','account');
				$this->properties->delete_record($propertyID,'properties');
				$this->users->delete_record($owner,'users');
				$this->owners->delete_record($ownerID,'owners');
				$desiredPropert = $this->desired_properties->getDesiredByPropertyID($propertyID);
				$this->desired_properties->delete_record($desiredPropert['id'],'desired_properties');
				$json_request['status'] = TRUE;
				$this->session->unset_userdata(array('current_property'=>'','property_id'=>''));
				$this->session->set_userdata('msgs','Property deleted');
			endif;
		else:
			$json_request['message'] = 'Error deleting<hr/>';
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
						$this->parseAndSendMail(4,array(
							'email'=>$dataval['email'],'user_name' => $user_name,
							'recovery_link' => site_url('password-recovery/'.$user_class.'/temporary-code/'.$activate_code))
						);
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
		$json_request = array('status'=>FALSE,'redirect'=>site_url('broker/search/result'),'messages'=>'');
		if($data = $this->input->post('postdata')):
			$data = preg_split("/&/",$data);
			for($i=0;$i<count($data);$i++):
				$dataid = preg_split("/=/",$data[$i]);
				$dataval[$dataid[0]] = trim($dataid[1]);
			endfor;
			if($dataval):
				if($this->account['group'] == 3):
					$json_request['redirect'] = site_url('homeowner/search/result');
				endif;
				$this->load->model('properties');
				$sql = $this->createSearchSQL($dataval);
				$properties = $this->properties->query_execute($sql);
				$zillow_result = FALSE;
				if(!empty($dataval['property_address']) && (!empty($dataval['property_zip']) || !empty($dataval['property_state']) || !empty($dataval['property_city']))):
					$this->session->set_userdata(array('zillow_address'=>$dataval['property_address'],'zillow_zip'=>$dataval['property_zip'],'zillow_state'=>$dataval['property_state'],'zillow_city'=>$dataval['property_city']));
					$zillow_result = $this->zillowApi($dataval['property_address'],$dataval['property_zip'].' '.$dataval['property_state'].' '.$dataval['property_city']);
				else:
					$this->session->unset_userdata(array('zillow_address'=>'','zillow_zip'=>'','zillow_state'=>'','zillow_city'=>''));
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

	function adminSearchProperty(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Access denied');
		endif;
		$json_request = array('status'=>FALSE,'redirect'=>site_url(ADM_START_PAGE.'/properties'),'messages'=>'');
		if($data = $this->input->post('postdata')):
			$data = preg_split("/&/",$data);
			for($i=0;$i<count($data);$i++):
				$dataid = preg_split("/=/",$data[$i]);
				$dataval[$dataid[0]] = trim($dataid[1]);
			endfor;
			if($dataval):
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
				if($properties = $this->properties->query_execute($sql)):
					$this->session->set_userdata('search_sql',$sql);
					$this->session->set_userdata('search_json_data',json_encode($dataval));
					$json_request['status'] = TRUE;
				else:
					$json_request['message'] = 'Nothing found';
				endif;
			endif;
		endif;
		echo json_encode($json_request);
	}

}