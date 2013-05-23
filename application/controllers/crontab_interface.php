<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Crontab_interface extends MY_Controller{
	
	function __construct(){
		
		parent::__construct();
	}
	
	public function sendingEmailAboutNewMatch(){
		
		echo 'OK';
	}
	
}
?>