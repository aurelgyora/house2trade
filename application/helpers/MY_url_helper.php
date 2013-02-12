<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

	function to_underscore($uri_string){
		
		if(!empty($uri_string)):
			return preg_replace('/[\/ ~%.:\-]+/','_',$uri_string);
		else:
			return FALSE;
		endif;
	}
?>