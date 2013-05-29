<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
	<!--<![endif]-->
	<head>
		<?php $this -> load -> view("users_interface/includes/head"); ?>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<?php $this -> load -> view("users_interface/includes/header"); ?>
		<?=$page['content'];?>
		<?php $this->load->view("users_interface/includes/footer");?>
		<?php $this->load->view("users_interface/includes/scripts");?>
	</body>
</html>
