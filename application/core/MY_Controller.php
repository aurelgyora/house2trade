<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
	
	var $account = array('id'=>0,'group'=>0);
	var $profile = '';
	var $loginstatus = FALSE;
	
	function __construct(){
		
		parent::__construct();
		
		$sessionLogon = $this->session->userdata('logon');
		if($sessionLogon):
			$this->account = json_decode($this->session->userdata('account'),TRUE);
			if($this->account):
				if(!$this->session->userdata('profile')):
					$profile = FALSE;
					switch($this->account['group']):
						case 1: $profile = $this->users->read_record($this->account['id'],'users');break;
						case 2:
							$this->load->model('accounts_brokers');
							$profile =$this->accounts_brokers->read_record($this->account['id'],'accounts_brokers');
							break;
						case 3:
							$this->load->model('accounts_owners');
							$profile =$this->accounts_owners->read_record($this->account['id'],'accounts_owners');
							break;
					endswitch;
					if($profile && ($sessionLogon == md5($profile['email']))):
						$this->profile = $profile;
						$this->session->set_userdata('profile',json_encode($this->profile));
						$this->loginstatus = TRUE;
					endif;
				else:
					$this->profile = json_decode($this->session->userdata('profile'),TRUE);
					$this->loginstatus = TRUE;
				endif;
			endif;
		endif;
	}
	
	function jsonAccount($field = FALSE){
		
		$account = '';
		if($this->loginstatus):
			if($this->profile):
				$account = json_decode($this->profile,TRUE);
				if($field):
					return $account[$field];
				endif;
			endif;
		endif;
		return $account;
	}
	
	/*************************************************************************************************************/
	
	public function zillowApi($address,$zip){
		
		$this->load->library('zillow_api');
//		$zws_id = 'X1-ZWz1dj3m0o5c7f_6bk45';
//		$zws_id = 'X1-ZWz1djlx0zrnyj_9d4gz';
//		$zws_id = 'X1-ZWz1djm0z1zrwr_9fxlx';
		$zws_id = 'X1-ZWz1bgwfzdn5l7_9hc6e';
		$zillow_api = new Zillow_Api($zws_id);
		$search_result = $zillow_api->GetDeepSearchResults(array('address'=>$address,'citystatezip'=>$zip));
		$code = (int)$search_result->message->code;
		if(!$code):
			$tax = (float)$search_result->response->results->result->taxAssessment;
			if($tax):
				$tax = substr($tax, 0, strlen($tax)-2);
			endif;
			$result = array(
				'page-content'=>(string)$search_result->response->results->result->links->homedetails,
				'property-fname' => '',
				'property-lname' => '',
				'login-email' => '',
				'property-city' => (string)$search_result->response->results->result->address->city,
				'property-state' => (string)$search_result->response->results->result->address->state,
				'property-address1' => (string)$search_result->response->results->result->address->street,
				'property-zipcode' => (string)$search_result->response->results->result->address->zipcode,
				'property-type' => (string)$search_result->response->results->result->useCode,
				'property-bathrooms' => (int)$search_result->response->results->result->bathrooms,
				'property-bedrooms' => (int)$search_result->response->results->result->bedrooms,
				'property-sqf' => (int)$search_result->response->results->result->finishedSqFt,
				'property-lot-size' => (int)$search_result->response->results->result->lotSizeSqFt,
				'property-price' => 0,
				'property-tax' => $tax,
				'property-year' => (int)$search_result->response->results->result->yearBuilt,
				'property-last-sold-date' => (string)$search_result->response->results->result->lastSoldDate,
				'property-last-sold-price' => (int)$search_result->response->results->result->lastSoldPrice,
				'property-bank-price' => 0,
				'property-mls' => '',
				'property-discription' => ''
			);
			return $result;
		else:
			return FALSE;
		endif;
	}

	public function arrayImagesFromPage($siteURL){
		
		$images = array();
		if(!empty($siteURL)):
			$content = file_get_contents($siteURL);
			preg_match_all("/<img.*?class=\"hip-photo\".*?(http:\/\/(.*?))\">/",$content,$matches,PREG_SET_ORDER);
			foreach($matches as $key => $value):
				if(isset($value[1])):
					$images[] = $value[1];
				endif;
			endforeach;
		endif;
		if($images):
			return $images;
		else:
			return FALSE;
		endif;
	}
	
	/*************************************************************************************************************/
	
	public function changePropertiesStatus($operationCode = 0,$sellerID = NULL,$buyerID = NULL,$propertiesIDs = NULL){
		/*$operationCode = {
			'0' => add to potential by;
			'1' => owner or broker cancel match;
			'7' => match approved by owner or broker;
			'8' => match approved by All !!!;
			other => backup value
		}*/
		$result = FALSE;
		if($operationCode == 0):
			$result = $this->changeStatusForSellerAndBuyer($sellerID,$buyerID);
		else:
			$result = $this->changeStatusForManyProperties($propertiesIDs,$operationCode);
		endif;
		return $result;
	}
	
	private function changeStatusForSellerAndBuyer($sellerID,$buyerID){
		
		$this->load->model('properties');
		$sellerStatus = $this->properties->read_field($sellerID,'properties','status');
		$buyerStatus = $this->properties->read_field($buyerID,'properties','status');
		switch($sellerStatus):
			case 1: $sellerStatus = 13; break;
			case 14: $sellerStatus = 16; break;
			case 15: $sellerStatus = 13; break;
		endswitch;
		$result = $this->properties->update_field($sellerID,'status',$sellerStatus,'properties');
		switch($buyerStatus):
			case 1: $buyerStatus = 14; break;
			case 15: $buyerStatus = 14; break;
			case 13: $buyerStatus = 16; break;
		endswitch;
		$result = $this->properties->update_field($buyerID,'status',$buyerStatus,'properties');
		return $result;
	}
	
	private function changeStatusForManyProperties($propertiesIDs,$setStatusValue){
		
		$this->load->model('properties');
		return $this->properties->updateFields('status',$setStatusValue,$propertiesIDs,'properties');
	}
	
	/*************************************************************************************************************/
	
	public function getMatchPropertiesIDs($match){
		
		if(!empty($match)):
			$propertiesIDs = array();
			for($i=1;$i<=$match['level'];$i++):
				$propertiesIDs[] = $match['property_id'.$i];
			endfor;
			return array_reverse($propertiesIDs);
		else:
			return NULL;
		endif;
	}
	
	public function getMatchPropertiesInformationList($propertiesIDs){
		
		if(!is_null($propertiesIDs)):
			$this->load->model(array('properties','property_potentialby'));
			$propertiesInfoList = $this->properties->getPropertiesWhereIN($propertiesIDs);
			$downPayments = $this->property_potentialby->getDownPaymentsValues($propertiesIDs);
			for($i=0;$i<count($propertiesInfoList)-1;$i++):
				$propertiesInfoList[$i]['down_payment'] = $this->getDownPaymentValues($propertiesInfoList,$downPayments,$i,$i+1);
			endfor;
			$propertiesInfoList[count($propertiesInfoList)-1]['down_payment'] = $this->getDownPaymentValues($propertiesInfoList,$downPayments,count($propertiesInfoList)-1,0);
			return $propertiesInfoList;
		else:
			return NULL;
		endif;
	}
	
	public function setDownPaymentValue($matchID,$downPaymentValue){
		
		$this->load->model('match');
		$match = $this->match->read_record($matchID,'match');
		if($nameFieldSeller = array_search($this->session->userdata('current_property'),$match)):
			if(($nameFieldSeller[11]-1) == 0):
				$nameFieldBuyer = 'property_id6';
			else:
				$nameFieldBuyer = 'property_id'.($nameFieldSeller[11]-1);
			endif;
			$this->load->model('property_potentialby');
			$downPaymentID = $this->property_potentialby->getDownPaymentValue($match[$nameFieldSeller],$match[$nameFieldBuyer]);
			return $this->property_potentialby->update_field($downPaymentID,'down_payment',$downPaymentValue,'property_potentialby');
		else:
			return FALSE;
		endif;
	}
	
	public function changeMatchStatusValue($matchID,$status){
		
		$this->load->model('match');
		$match = $this->match->read_record($matchID,'match');
		$result = array('status'=>FALSE,'message'=>'Error!','approved_all'=>FALSE);
		if($nameFieldSeller = array_search($this->session->userdata('current_property'),$match)):
			$nameFieldStatus = 'status'.($nameFieldSeller[11]);
			$this->match->update_field($matchID,$nameFieldStatus,$status,'match');
			$match[$nameFieldStatus] = $status;
			$message = 'You have approved the match!';
			if($status == 1):
				$MainStatus = 1;
				for($i=1;$i<=$match['level'];$i++):
					if($match['status'.$i] == 0):
						$MainStatus = 0;
					endif;
				endfor;
				if($MainStatus == 1):
					$this->match->update_field($matchID,'status',1,'match');
					$message = 'The match cycle is approved by all participants!';
					$result['approved_all'] = TRUE;
				endif;
			elseif($status == 2):
				$this->match->update_field($matchID,'status',2,'match');
				$message = 'Match is broken!';
			endif;
			$result['message'] = '<div class="alert alert-info">'.$message.' <a href="'.site_url('broker/match?action=cancel&match='.$matchID.'&field='.$nameFieldStatus).'">Cancel operation</a></div>';
			$result['status'] = $status;
		endif;
		return $result;
	}
	
	public function cancelOperationWithMatch($matchID,$field){
		
		$this->load->model(array('match','properties'));
		$match = $this->match->read_record($matchID,'match');
		$result = array('status'=>FALSE,'message'=>'Error!');
		if($nameFieldSeller = array_search($this->session->userdata('current_property'),$match)):
			$this->match->update_field($matchID,$field,0,'match');
			$this->match->update_field($matchID,'status',0,'match');
			$backupStatusProperty = $this->session->userdata('backupStatusProperty');
			$this->changePropertiesStatus($backupStatusProperty,NULL,NULL,array($this->session->userdata('current_property')));
			$result['status'] = TRUE;
		endif;
		return $result;
	}
	
	private function getDownPaymentValues($properties,$downpayments,$current,$next){
		
		$down_payment = array('value'=>0,'my_value'=>0);
		for($j=0;$j<count($downpayments);$j++):
			if(($downpayments[$j]['seller_id'] == $properties[$current]['id']) && ($downpayments[$j]['buyer_id'] == $properties[$next]['id'])):
				$down_payment['value'] = $downpayments[$j]['down_payment'];
				if($properties[$current]['id'] == $this->session->userdata('current_property')):
					$down_payment['my_value'] = 1;
				else:
					$down_payment['my_value'] = 0;
				endif;
				break;
			endif;
		endfor;
		return $down_payment;
	}
	
	/*************************************************************************************************************/
	public function pagination($url,$uri_segment,$total_rows,$per_page){
		
		$this->load->library('pagination');
		$config['base_url'] 		= base_url()."$url/from/";
		$config['uri_segment'] 		= $uri_segment;
		$config['total_rows'] 		= $total_rows;
		$config['per_page'] 		= $per_page;
		$config['num_links'] 		= 4;
		$config['first_link']		= 'First';
		$config['last_link'] 		= 'Last';
		$config['next_link'] 		= 'Next &raquo;';
		$config['prev_link'] 		= '&laquo; Prev';
		$config['cur_tag_open']		= '<li class="active"><a href="#">';
		$config['cur_tag_close'] 	= '</a></li>';
		$config['full_tag_open'] 	= '<div class="pagination"><ul>';
		$config['full_tag_close'] 	= '</ul></div>';
		$config['first_tag_open'] 	= '<li>';
		$config['first_tag_close'] 	= '</li>';
		$config['last_tag_open'] 	= '<li>';
		$config['last_tag_close'] 	= '</li>';
		$config['next_tag_open'] 	= '<li>';
		$config['next_tag_close'] 	= '</li>';
		$config['prev_tag_open'] 	= '<li>';
		$config['prev_tag_close'] 	= '</li>';
		$config['num_tag_open'] 	= '<li>';
		$config['num_tag_close'] 	= '</li>';
		
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}
	
	public function send_mail($to,$from_mail,$from_name,$subject,$text){
		
		$this->load->library('email');
		$this->email->clear(TRUE);
		$config['smtp_host'] = 'localhost';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		
		$this->email->initialize($config);
		$this->email->to($to);
		$this->email->from($from_mail,$from_name);
		$this->email->bcc('');
		$this->email->subject($subject);
		$this->email->message($text);
		if($this->email->send()):
			return TRUE;
		else:
			return FALSE;
		endif;
	}
	
	public function loadimage(){
		
		$section = $this->uri->segment(2);
		$id = $this->uri->segment(3);
		switch ($section):
			case 'logo': $this->load->model('company'); $image = $this->company->read_field($id,'company','logo'); break;
			default : show_404();break;
		endswitch;
		if(!$image):
			$image = file_get_contents(getcwd().'/img/thumb.png');
		endif;
		header('Content-type: image/gif');
		
		echo $image;
	}
	
	public function image_manupulation($userfile,$dim,$ratio,$width = FALSE,$height = FALSE){
		
		$this->load->library('image_lib');
		$this->image_lib->clear();
		$config['image_library'] = 'gd2';
		$config['source_image'] = $userfile;
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = $ratio;
		$config['master_dim'] = $dim;
		$config['width'] = $width;
		$config['height'] = $height;
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
	}
	
	public function fileupload($userfile,$overwrite,$catalog){
		
		$config['upload_path'] 		= './documents/'.$catalog.'/';
		$config['allowed_types'] 	= 'doc|docx|xls|xlsx|txt|pdf';
		$config['remove_spaces'] 	= TRUE;
		$config['overwrite'] 		= $overwrite;
		
		$this->load->library('upload',$config);
		
		if(!$this->upload->do_upload($userfile)):
			return FALSE;
		endif;
		
		return TRUE;
	}

	public function filedelete($file){
		
		$file = getcwd().'/'.$file;
		if(is_file($file)):
			@unlink($file);
			return TRUE;
		else:
			return FALSE;
		endif;
	}

	public function translite($string){
		
		$rus = array("1","2","3","4","5","6","7","8","9","0","ё","й","ю","ь","ч","щ","ц","у","к","е","н","г","ш","з","х","ъ","ф","ы","в","а","п","р","о","л","д","ж","э","я","с","м","и","т","б","Ё","Й","Ю","Ч","Ь","Щ","Ц","У","К","Е","Н","Г","Ш","З","Х","Ъ","Ф","Ы","В","А","П","Р","О","Л","Д","Ж","Э","Я","С","М","И","Т","Б"," ");
		$eng = array("1","2","3","4","5","6","7","8","9","0","yo","iy","yu","","ch","sh","c","u","k","e","n","g","sh","z","h","","f","y","v","a","p","r","o","l","d","j","е","ya","s","m","i","t","b","Yo","Iy","Yu","CH","","SH","C","U","K","E","N","G","SH","Z","H","","F","Y","V","A","P","R","O","L","D","J","E","YA","S","M","I","T","B","-");
		$string = str_replace($rus,$eng,$string);
		if(!empty($string)):
			$string = preg_replace('/[^a-z0-9,-]/','',strtolower($string));
			$string = preg_replace('/[-]+/','-',$string);
			$string = preg_replace('/[\.\?\!\)\(\,\:\;]/','',$string);
			return $string;
		else:
			return FALSE;
		endif;
	}

	public function english_symbol($string){
		
		if(!empty($string)):
			$string = preg_replace('/[ ]+/','-',strtolower($string));
			$string = preg_replace('/[^a-z,-]/','',$string);
			$string = preg_replace('/[-]+/','-',$string);
			return $string;
		else:
			return FALSE;
		endif;
	}
	
	public function valid_url_symbol($string){
		
		if(!empty($string)):
			$string = preg_replace('/[ ]+/','-',strtolower($string));
			$string = preg_replace('/[^a-z0-9,-\/\?\&\$\#\@]/','',strtolower($string));
			$string = preg_replace('/[-]+/','-',$string);
			$string = preg_replace('/[\.\?\!\)\(\,\:\;]/','',$string);
			return $string;
		else:
			return FALSE;
		endif;
	}

	public function setActiveUsers($usersList,$field = 'id'){
		
		$list = NULL;
		$session_data = $this->users->activeUserData();
		for($i=0;$i<count($session_data);$i++):
			preg_match("/\"userid\"\;s\:[0-9]+\:\"([0-9]+)\"/i",$session_data[$i]['user_data'], $userid);
			if(isset($userid[1])):
				$list[] = (int)$userid[1];
			endif;
		endfor;
		for($i=0;$i<count($usersList);$i++):
			$usersList[$i]['online'] = FALSE;
			for($j=0;$j<count($list);$j++):
				if($usersList[$i][$field] == $list[$j]):
					$usersList[$i]['online'] = TRUE;
				endif;
			endfor;
		endfor;
		return $usersList;
	} //добавляет поле online которое показывает активность пользователя в сети за последние 15 минут
	
	public function account_information($user_id,$class){
		
		switch($class):
		 	case 1: $info['name'] = 'Администратор'; return $info; break;
			case 2: $this->load->model('brokers'); return $info = $this->brokers->read_record($user_id,'brokers');break;
		 	case 3: $this->load->model('owners'); return $info = $this->owners->read_record($user_id,'owners');break;
			default : FALSE; break;
		endswitch;
	}
	
	
}