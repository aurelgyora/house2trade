<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

	function blog_limiter($content){
		
		if(!empty($content)):
			$pattern = "/\<cut text\=\"(.+?)\">/i";
			$replacement = "<a href=\"#\" class=\"none advanced muted\">\$1</a> <cut>";
			return preg_replace($pattern, $replacement,$content);
		else:
			return '';
		endif;
	}
	
	function getStatus($status){
		
		$html = '<div class="btn-group" data-toggle="buttons-radio">';
		if($status):
			$html .= '<button type="button" class="user-status btn btn-mini btn-success active">YES</button><button type="button" class="user-status btn btn-mini">NO</button>';
		else:
			$html .= '<button type="button" class="user-status btn btn-mini">YES</button><button type="button" class="user-status btn btn-mini btn-danger active">NO</button>';
		endif;
		return $html .= '</div>';
	}
?>