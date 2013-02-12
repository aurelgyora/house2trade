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
				if($user && $user['active']):
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
}