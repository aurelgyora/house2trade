<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view("owner_interface/includes/head");?>
<link rel="stylesheet" type="text/css" media="all" href="<?=site_url('css/images.css');?>" />
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
						<?=anchor('homeowner/properties/information/'.$this->session->userdata('property_id'),'Back');?>
					</div>
				</div>
				<div id="div-property-information">
				<?php $this->load->view('forms/edit-account-properties');?>
				</div>
				<div class="clear"></div>
				<div id="div-insert-photo-properties" class="hidden">
					<?php $this->load->view('forms/insert-photos-properties');?>
				</div>
				<div id="div-remove-photo-properties" class="hidden">
					<?php $this->load->view('forms/photos-properties');?>
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->view("owner_interface/includes/footer");?>
	<?php $this->load->view("owner_interface/includes/scripts");?>
	<script type="text/javascript" src="<?=site_url('js/upload.js');?>"></script>
</body>
</html>
