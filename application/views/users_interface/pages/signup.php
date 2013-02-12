<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<?php $this->load->view("users_interface/includes/head");?>
</head>
<body>
	<?php $this->load->view("users_interface/includes/header");?>
	<div id="main" class="single">
		<div class="container_12 clearfix">
			<div class="grid_12 clearfix">
				<h1>Create a new account</h1>
				<p>All fields are required. We will <a class="link-more" href="<?=site_url('');?>">take good care</a> of your info.</p>
			</div>
			<div class="grid_7">
			<?php $this->load->view("forms/account-setup");?>
			</div>
			<div class="grid_4">
				<?=$page['content'];?>
			</div>
		</div>
	</div>
<?php $this->load->view("users_interface/includes/footer");?>
<?php $this->load->view("users_interface/includes/scripts");?>
</body>
</html>