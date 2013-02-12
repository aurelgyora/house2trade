<?php require_once(PATH_PAGE_VARIABLE);
if(uri_string() == ''):
	$uri = 'home';
else:
	$uri = to_underscore(uri_string());
endif;?>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title><?=$head_variable[$uri]['title'];?></title>
<meta name="description" content="<?=$head_variable[$uri]['description'];?>" />
<meta name="viewport" content="width=device-width" />
<link rel="stylesheet" href="<?=site_url('css/normalize.min.css');?>" />
<link rel="stylesheet" href="<?=site_url('css/960.css');?>" />
<link rel="stylesheet" href="<?=site_url('css/main.css');?>" />
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400,700,300" type="text/css" />
<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,200italic,300italic,400italic,600italic" rel="stylesheet" type="text/css" />
<script src="<?=site_url('js/vendor/modernizr-2.6.2.min.js');?>"></script>