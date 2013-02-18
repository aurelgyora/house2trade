<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_interface extends MY_Controller{
	
	function __construct(){
		
		parent::__construct();
	}

	/******************************************** accounts *******************************************************/
	function login(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$statusval = array('status'=>FALSE,'message'=>'Login is impossible','redirect'=>base_url());
		$data = trim($this->input->post('postdata'));
		if($data):
			$data = preg_split("/&/",$data);
			for($i=0;$i<count($data);$i++):
				$dataid = preg_split("/=/",$data[$i]);
				$dataval[$i] = trim($dataid[1]);
			endfor;
			if($dataval):
				$user = $this->users->auth_user($dataval[0],$dataval[1]);
				if($user && $user['status']):
					$statusval['status'] = TRUE;
					$statusval['message'] = '';
					$this->session->set_userdata(array('logon'=>md5($dataval[0]),'userid'=>$user['id']));
					switch($user['class']):
						case 1: $statusval['redirect'] .= 'administrator/control-panel';
							break;
						case 2: $statusval['redirect'] .= 'broker/control-panel';
							break;
						case 3: $statusval['redirect'] .= 'homeowner/control-panel';
							break;
					endswitch;
				endif;
			endif;
		endif;
		echo json_encode($statusval);
	}

	function signup_account(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$statusval = array('status'=>FALSE,'error'=>FALSE,'email'=>FALSE,'message'=>'');
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
								$this->load->model('properties');
								$propertiesID = $this->properties->insert_record($dataval);
								$this->users->update_field($dataval['user_id'],'user_id',$propertiesID,'users');
								$this->users->update_field($dataval['user_id'],'class',3,'users');
								$this->users->update_field($dataval['user_id'],'temporary_code',$activate_code,'users');
								$user_class = 'homeowner';
								break;
						endswitch;
						ob_start();?>
<p>Hello <em><?=$dataval['fname'].' '.$dataval['lname'];?></em>,</p>
<p>Thank you for registering at House2Trade.<br/>Please click the link below to activate your account:<br/>
<?=anchor('comfirm-registering/'.$user_class.'/activation-code/'.$activate_code,base_url().'comfirm-registering/'.$user_class.'/activation-code/'.$activate_code,array('target'=>'_blank'));?></p><?
$mailtext = ob_get_clean();
						$this->send_mail($dataval['email'],'robot@house2trade.com','House2Trade','Register to House2Trade',$mailtext);
						$statusval['status'] = TRUE;
						$statusval['message'] = '<img src="'.site_url("img/check.png").'" alt="" /> The letter with registration confirmation was sent to your email';
					endif;
				else:
					$statusval['email'] = TRUE;
				endif;
			endif;
		endif;
		echo json_encode($statusval);
	}

	function signup_properties(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$statusval = array('status'=>FALSE,'message'=>'Signup is impossible');
		$data = trim($this->input->post('postdata'));
		if($data):
			$data = preg_split("/&/",$data);
			for($i=0;$i<count($data);$i++):
				$dataid = preg_split("/=/",$data[$i]);
				$dataval[$dataid[0]] = trim($dataid[1]);
			endfor;
			if($dataval):
				if(!$this->users->user_exist('email',$dataval['email'])):
					$this->load->helper('string');
					$dataval['password'] = random_string('alnum',12);
					$dataval['user_id'] = $this->users->insert_record($dataval);
					if($dataval['user_id']):
						$this->load->model('properties');
						$propertiesID = $this->properties->insert_record($dataval);
						$this->users->update_field($dataval['user_id'],'user_id',$propertiesID,'users');
						$this->users->update_field($dataval['user_id'],'class',3,'users');
						$this->users->update_field($dataval['user_id'],'status',1,'users');
						ob_start();?>
<p>Hello <em><?=$dataval['fname'].' '.$dataval['lname'];?></em>,</p>
<p>Your account has been created at Hause2Trade !<br/>
To log in to your personal account, use the username and password specified during registration.<br/>
Your login: <?=$dataval['email'];?><br/>
Your password: <?=$dataval['password'];?><br/>
<strong>Attention! </strong>Do not forget to change your password!<br/>
<br/>Please click on the link below to go to your profile:<br/>
<?=anchor('homeowner/profile',base_url().'homeowner/profile',array('target'=>'_blank'));?></p><?
$mailtext = ob_get_clean();
						$this->send_mail($dataval['email'],'robot@house2trade.com','Hause2Trade','Register to Hause2Trade',$mailtext);
						$statusval['message'] = '<img src="'.site_url("img/check.png").'" alt="" /> The letter with registration confirmation was sent to homeowner email';
						$statusval['status'] = TRUE;
					endif;
				else:
					$statusval['message'] = "Email already exist";
				endif;
			endif;
		endif;
		echo json_encode($statusval);
	}
	
	function change_user_status(){
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$statusval = array('status'=>FALSE);
		$data = trim($this->input->post('postdata'));
		if($data):
			$currentStatus = $this->users->read_field($data,'users','status');
			if(!$currentStatus):
				$this->users->update_field($data,'status',1,'users');
				$this->users->update_field($data,'temporary_code','','users');
				$statusval['status'] = TRUE;
			else:
				$this->users->update_field($data,'status',0,'users');
				$statusval['status'] = FALSE;
			endif;
		endif;
		echo json_encode($statusval);
	}
	
	function save_profile(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$statusval = array('status'=>FALSE,'message'=>'Profile saved','redirect'=>'');
		$data = trim($this->input->post('postdata'));
		if($data):
			$data = preg_split("/&/",$data);
			for($i=0;$i<count($data);$i++):
				$dataid = preg_split("/=/",$data[$i]);
				$dataval[$dataid[0]] = trim($dataid[1]);
			endfor;
			if($dataval):
				if($dataval['password'] != $dataval['confirm']):
					$statusval['message'] = 'Passwords do not match';
				else:
					$statusval['status'] = TRUE;
					if(!isset($dataval['setpswd'])):
						switch($this->user['class']):
							case 2:	$this->load->model('brokers');
									$dataval['id'] = $this->users->read_field($this->user['uid'],'users','user_id');
									$this->brokers->update_record($dataval);
									break;
							case 3:	$this->load->model('properties');
									$dataval['id'] = $this->users->read_field($this->user['uid'],'users','user_id');
									$this->properties->update_record($dataval);
									break;
						endswitch;
					endif;
					switch($this->user['class']):
						case 2:	$statusval['redirect'] = site_url('broker/control-panel');
								break;
						case 3:	$statusval['redirect'] = site_url('homeowner/control-panel');
								break;
					endswitch;
					if(!empty($dataval['password'])):
						$this->users->update_field($this->user['uid'],'password',md5($dataval['password']),'users');
					endif;
				endif;
			endif;
		endif;
		echo json_encode($statusval);
	}
	
	function send_forgot_password(){
		
		if(!$this->input->is_ajax_request()):
			show_error('Аccess denied');
		endif;
		$statusval = array('status'=>FALSE,'error'=>FALSE,'email'=>FALSE,'message'=>'');
		$data = trim($this->input->post('postdata'));
		if($data):
			$data = preg_split("/&/",$data);
			for($i=0;$i<count($data);$i++):
				$dataid = preg_split("/=/",$data[$i]);
				$dataval[$dataid[0]] = trim($dataid[1]);
			endfor;
			if($dataval):
				$uid = $this->users->user_exist('email',$dataval['email']);
				$status = $this->users->read_field($uid,'users','status');
				if($status && $uid):
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
								$this->load->model('properties');
								$user_name = $this->properties->read_name($user_id,'properties');
								$user_class = 'homeowner';
								break;
						endswitch;
						ob_start();?>
<p>Hello <em><?=$user_name;?></em>,</p>
<p>You have requested a new password to access personal account. To do this, follow the links below:<br/>
<?=anchor('password-recovery/'.$user_class.'/temporary-code/'.$activate_code,base_url().'password-recovery/'.$user_class.'/temporary-code/'.$activate_code,array('target'=>'_blank'));?></p><?
$mailtext = ob_get_clean();
						$this->send_mail($dataval['email'],'robot@house2trade.com','House2Trade','Restore account password to House2Trade',$mailtext);
						$statusval['status'] = TRUE;
						$statusval['message'] = '<img src="'.site_url("img/check.png").'" alt="" /> Letter from further action was sent to your email';
					endif;
				else:
					$statusval['email'] = TRUE;
				endif;
			endif;
		endif;
		echo json_encode($statusval);
	}

}