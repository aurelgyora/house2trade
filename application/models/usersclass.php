<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Usersclass extends MY_Model{

	var $id		 = 0;
	var $title	 = '';
	var $comment = '';

	function __construct(){
		parent::__construct();
	}
}