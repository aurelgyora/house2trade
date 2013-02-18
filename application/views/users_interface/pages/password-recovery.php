<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<?php $this->load->view("users_interface/includes/head");?>
<link rel="stylesheet" href="<?=site_url('css/bootstrap-customize.css');?>" />
</head>
<body>
	<?php $this->load->view("users_interface/includes/header");?>
	<div id="main" class="single">
		<div class="container_12 clearfix">
			<div class="grid_12 clearfix">
				<h1>Restore account password</h1>
				<p>Enter your email address specified during registration.</p>
			</div>
			<div class="grid_7">
				<form action="/" class="form-forgot" method="post">
					<div class="grid_7">
						<p>
							<label>Email*</label>
							<input class="FieldSend" id="login-email" name="email" <?=TOOLTIP_FIELD_BLANK;?> size="30" type="text">
						</p>
					</div>
					<div class="grid_7">
						<p class="button-row">
							<input class="btn-submit" id="forgot-button" name="forgot" type="submit" value="Recovery">
							<span id="block-message"></span>
						</p>
					</div>
					<div class="clear"></div>
				</form>
			</div>
		</div>
	</div>
<?php $this->load->view("users_interface/includes/footer");?>
<?php $this->load->view("users_interface/includes/scripts");?>
<script src="<?=site_url('js/libs/bootstrap.min.js');?>"></script>
<script src="<?=site_url('js/guests.js');?>"></script>
</body>
</html>