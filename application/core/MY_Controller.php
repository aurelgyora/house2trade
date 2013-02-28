<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
	
	var $user = array('uid'=>0,'name'=>'','email'=>'','class'=>0,'class_name'=>'','class_translit'=>'');
	var $loginstatus = FALSE;
	
	function __construct(){
		
		parent::__construct();
		
		$this->load->model('pages');
		
		$cookieuid = $this->session->userdata('logon');
		if(isset($cookieuid) and !empty($cookieuid)):
			$this->user['uid'] = $this->session->userdata('userid');
			if(isset($this->user['uid']) && !is_null($this->user['uid'])):
				$userinfo = $this->users->read_record($this->user['uid'],'users');
				if($userinfo):
					//получаем информацию о пользователе
					$this->load->model('usersclass');
					$this->user['class_name'] = $this->usersclass->read_field($userinfo['class'],'users_class','title');
					$this->user['email'] = $userinfo['email'];
					$this->user['class'] = $userinfo['class'];
					$this->user['class_translit'] = $this->usersclass->read_field($this->user['class'],'users_class','translit');
					switch($this->user['class']):
						case 1: $this->user['name'] = 'Administrator'; break;
						case 2: $this->load->model('brokers');$this->user['name'] = $this->brokers->read_name($userinfo['user_id'],'brokers'); break;
						case 3: $this->load->model('owners');$this->user['name'] = $this->owners->read_name($userinfo['user_id'],'owners'); break;
					endswitch;
					$this->loginstatus = TRUE;
				endif;
			endif;
			if($this->session->userdata('logon') != md5($userinfo['email'])):
				$this->loginstatus = FALSE;
				$this->user = array();
			endif;
		endif;
	}
	
	public function pagination($url,$uri_segment,$total_rows,$per_page){
		
		$this->load->library('pagination');
		$config['base_url'] 		= base_url()."$url/from/";
		$config['uri_segment'] 		= $uri_segment;
		$config['total_rows'] 		= $total_rows;
		$config['per_page'] 		= $per_page;
		$config['num_links'] 		= 4;
		$config['first_link']		= 'В начало';
		$config['last_link'] 		= 'В конец';
		$config['next_link'] 		= 'Далее &raquo;';
		$config['prev_link'] 		= '&laquo; Назад';
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
			case 'photo':$image = $this->mdusers->read_field($id,'users','photo'); break;
			case 'avatar':$image = $this->mdusers->read_field($id,'users','thumbnail'); break;
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