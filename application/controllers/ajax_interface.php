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

	function signup_broker(){
		
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
				if($dataval['password'] != $dataval['confirm']):
					$dataval = array();
				endif;
				if(!$this->users->user_exist('email',$dataval['email'])):
					$dataval['user_id'] = $this->users->insert_record($dataval);
					if($dataval['user_id']):
						$this->load->model('brokers');
						$brokerID = $this->brokers->insert_record($dataval);
						$this->users->update_field($dataval['user_id'],'user_id',$brokerID,'users');
						$this->load->helper('string');
						$activate_code = random_string('alpha',25);
						$this->users->update_field($dataval['user_id'],'temporary_code',$activate_code,'users');
						ob_start();?>
<p>Hello <em><?=$dataval['fname'].' '.$dataval['lname'];?></em>,</p>
<p>Thank you for registering at House2Trade.<br/>Please click the link below to activate your account:<br/>
<?=anchor('comfirm-registering/broker/activation-code/'.$activate_code,base_url().'comfirm-registering/broker/activation-code/'.$activate_code,array('target'=>'_blank'));?></p><?
$mailtext = ob_get_clean();
						$this->send_mail($dataval['email'],'robot@house2trade.com','House2Trade','Register to House2Trade',$mailtext);
						$statusval['message'] = '<img src="'.site_url("img/check.png").'" alt="" /> The letter with registration confirmation was sent to your email';
						$statusval['status'] = TRUE;
					endif;
				else:
					$statusval['message'] = "Email already exist";
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
						$this->load->helper('string');
						$activate_code = random_string('alpha',25);
						$this->users->update_field($dataval['user_id'],'temporary_code',$activate_code,'users');
						ob_start();?>
<p>Hello <em><?=$dataval['fname'].' '.$dataval['lname'];?></em>,</p>
<p>Thank you for registering at Hause2Trade.<br/>Please click the link below to activate your account:<br/>
<?=anchor('comfirm-registering/homeowner/activation-code/'.$activate_code,base_url().'comfirm-registering/broker/activation-code/'.$activate_code,array('target'=>'_blank'));?></p><?
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
		$statusval = array('status'=>FALSE,'message'=>'Profile saved');
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
					if(!empty($dataval['password'])):
						$this->users->update_field($this->user['uid'],'password',md5($dataval['password']),'users');
					endif;
				endif;
			endif;
		endif;
		echo json_encode($statusval);
	}

}