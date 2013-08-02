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
	
	function getPropertyStatus($property,$status,$group = 2){
		ob_start();?>
		<div class="btn-group" data-toggle="buttons-radio" data-property-id="<?=$property;?>">
		<?php if($group == 1):?>
			<button type="button" data-property-status="0" class="change-property-status btn btn-mini<?=($status == 0)?' btn-success active':'';?>">PENDING</button>
			<button type="button" data-property-status="1" class="change-property-status btn btn-mini<?=($status == 1)?' btn-success active':'';?>">ACTIVE</button>
		<?php endif;?>
			<button type="button" data-property-status="9" class="change-property-status btn btn-mini<?=($status == 9)?' btn-success active':'';?>">SOLD</button>
		<?php if($group == 1):?>
			<button type="button" data-property-status="10" class="change-property-status btn btn-mini<?=($status == 10)?' btn-success active':'';?>">PROPERTY WITH THE PROBLEM</button>
		<?php endif;?>
		<?php if($group == 2):?>
			<button type="button" data-property-status="11" class="change-property-status btn btn-mini<?=($status == 11)?' btn-success active':'';?>">DEACTIVATED</button>
		<?php endif;?>
		<?php if($group == 3):?>
			<button type="button" data-property-status="12" class="change-property-status btn btn-mini<?=($status == 12)?' btn-success active':'';?>">DEACTIVATED</button>
		<?php endif;?>
		</div>
		<?php return ob_get_clean();
	}
?>