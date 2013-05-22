<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view("admin_interface/includes/head");?>
</head>
<body>
	<?php $this->load->view("admin_interface/includes/header");?>
	<div class="container">
		<div class="row">
			<hr/>
			<?php $this->load->view("admin_interface/includes/rightbar");?>
			<div class="span9">
				<div class="navbar">
					<div class="navbar-inner">
						<a class="brand" href="<?=site_url(uri_string());?>">Account information</a>
						<ul class="nav pull-right">
							<li<?=($profile['group'] == 2)?' class="active"':''?>><a href="<?=site_url('administrator/broker/accounts');?>">Broker</a></li>
							<li<?=($profile['group'] == 3)?' class="active"':''?>><a href="<?=site_url('administrator/homeowner/accounts');?>">HomeOwner</a></li>
						</ul>
					</div>
				</div>
				<div class="clear"></div>
				<?php if($profile['group'] == 2):
					$this->load->view('broker_interface/forms/edit-account');
				elseif($profile['group'] == 3):
					$this->load->view('forms/edit-account-owner');
				endif;?>
			</div>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/footer");?>
	<?php $this->load->view("admin_interface/includes/scripts");?>
</body>
</html>
