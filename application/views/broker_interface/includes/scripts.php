<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.js"></script>
<script>window.jQuery || document.write('<script src="<?=site_url("js/vendor/jquery.js");?>"><\/script>')</script>
<script type="text/javascript" src="<?=site_url('js/libs/bootstrap.js');?>"></script>
<script type="text/javascript" src="<?=site_url('js/libs/base.js');?>"></script>
<script type="text/javascript" src="<?=site_url('js/logined.js');?>"></script>
<script type="text/javascript" src="<?=site_url('js/cabinet/selects.js');?>"></script>
<script type="text/javascript">
<?php if($this->uri->total_segments() == 2):?>
	$("li[data-active='<?=$this->uri->segment(2);?>']").addClass('active');
<?php endif;?>
<?php if($this->uri->segment(2) == 'properties' && $this->uri->total_segments() != 2):?>
	$("li[data-active='<?=$this->uri->segment(2);?>']").addClass('active');
<?php endif;?>
<?php if($this->uri->segment(2) == 'search' && $this->uri->total_segments() != 2):?>
	$("li[data-active='<?=$this->uri->segment(2);?>']").addClass('active');
<?php endif;?>
</script>