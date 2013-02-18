<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view("broker_interface/includes/head");?>
</head>
<body>
	<?php $this->load->view("broker_interface/includes/header");?>
	<div class="container">
		<div class="row">
			<hr/>
			<?php $this->load->view("broker_interface/includes/rightbar");?>
			<div class="span9">
				<div class="navbar">
					<div class="navbar-inner">
						<a class="brand" href="<?=site_url(uri_string());?>">Register Property</a>
					</div>
				</div>
				<div class="clear"></div>
				<div id="div-choise-metod">
				<?php $this->load->view('forms/metod-properties-register');?>
				</div>
				<div class="clear"></div>
				<div id="div-account-properties" class="hidden">
					<?php $this->load->view('forms/account-properties');?>
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->view("broker_interface/includes/scripts");?>
</body>
</html>
