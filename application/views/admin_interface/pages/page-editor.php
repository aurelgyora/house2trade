<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view("admin_interface/includes/head");?>
</head>
<body>
	<?php $this->load->view("admin_interface/includes/header");?>
	<div class="container">
		<div class="row">
			<div class="span9">
				<div class="navbar">
					<div class="navbar-inner">
						<a class="brand" href="<?=site_url('administrator/control-panel/pages');?>">Pages content</a>
						<ul class="nav pull-right">
							<li><a href="<?=site_url('administrator/control-panel/pages/home');?>">Home page</a></li>
							<li><a href="<?=site_url('administrator/control-panel/pages/about-us');?>">About Us</a></li>
							<li><a href="<?=site_url('administrator/control-panel/pages/contacts');?>">Contacts</a></li>
							<li><a href="<?=site_url('administrator/control-panel/pages/company');?>">Company</a></li>
						</ul>
					</div>
				</div>
				<div class="clear"></div>
				<?php $this->load->view("forms/page-editor");?>
			</div>
		<?php $this->load->view("admin_interface/includes/rightbar");?>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/scripts");?>
	<script type="text/javascript" src="<?=site_url('ckeditor/ckeditor.js');?>"></script>
</body>
</html>
