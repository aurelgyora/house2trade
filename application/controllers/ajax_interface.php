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
				if($dataval[$dataid[0]] == ''):
					$dataval = array();
					break;
				endif;
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
						$this->session->set_userdata(array('logon'=>md5($dataval['email']),'userid'=>$dataval['user_id']));
						$this->load->helper('string');
						$activate_code = random_string('alpha',25);
						$this->users->update_field($dataval['user_id'],'temporary_code',$activate_code,'users');
						ob_start();?>
<p>Hello <em><?=$dataval['fname'].' '.$dataval['lname'];?></em>,</p>
<p>Thank you for registering in Hause2Trade.<br/>Please activate your account the link below:<br/>
<?=anchor('comfirm-registering/broker/activation-code/'.$activate_code,base_url().'comfirm-registering/broker/activation-code/'.$activate_code,array('target'=>'_blank'));?></p><?
$mailtext = ob_get_clean();
						$this->send_mail($dataval['email'],'robot@house2trade.com','Hause2Trade','Register to Hause2Trade',$mailtext);
						$statusval['message'] = '<img src="'.site_url("img/check.png").'" alt="" /> You are send a latter to confirm registration';
						$statusval['status'] = TRUE;
					endif;
				else:
					$statusval['message'] = "Email already exist";
				endif;
			endif;
		endif;
		echo json_encode($statusval);
	}
}