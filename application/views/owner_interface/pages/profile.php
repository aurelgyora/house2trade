<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view("owner_interface/includes/head");?>
</head>
<body>
	<?php $this->load->view("owner_interface/includes/header");?>
	<div class="container">
		<div class="row">
			<hr/>
			<?php $this->load->view("owner_interface/includes/rightbar");?>
			<div class="span9">
				<div class="navbar">
					<div class="navbar-inner">
						<a class="brand" href="<?=site_url(uri_string());?>">My profile</a>
					</div>
				</div>
				<div class="clear"></div>
				<?php $this->load->view('forms/edit-account-owner');?>
			</div>
		</div>
	</div>
	<?php $this->load->view("owner_interface/includes/scripts");?>
</body>
</html>