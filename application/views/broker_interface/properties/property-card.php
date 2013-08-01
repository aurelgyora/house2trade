<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view("broker_interface/includes/head");?>
<link rel="stylesheet" type="text/css" media="all" href="<?=site_url('css/images.css');?>" />
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
						<?=anchor('broker/properties/information/'.$this->session->userdata('property_id'),'Back to property detail','class="btn btn-link"');?>
					</div>
				</div>
				<div id="div-property-information" class="div-manage-property">
				<?php $this->load->view('broker_interface/forms/edit-properties');?>
					<div class="form-actions">
						<a class="none btn edit-desired-property"><i class="icon-edit"></i> Edit desired property</a>
						<a class="none btn add-property-images"><i class="icon-plus"></i> Add images</a>
						<a class="none btn remove-property-images"><i class="icon-minus"></i>Remove images</a>
					</div>
				</div>
				<div class="clear"></div>
				<div id="div-edit-desired-property" class="div-manage-property hidden">
					<?php $this->load->view('broker_interface/forms/edit-desired-properties');?>
					<div class="form-actions">
						<a class="none btn btn-edit-main-property"><i class="icon-edit"></i> Edit main property</a>
						<a class="none btn add-property-images"><i class="icon-plus"></i> Add images</a>
						<a class="none btn remove-property-images"><i class="icon-minus"></i>Remove images</a>
					</div>
				</div>
				<div class="clear"></div>
				<div id="div-insert-photo-properties" class="div-manage-property hidden">
					<?php $this->load->view('forms/insert-photos-properties');?>
					<div class="form-actions">
						<a class="none btn btn-edit-main-property"><i class="icon-edit"></i> Edit main property</a>
						<a class="none btn edit-desired-property"><i class="icon-edit"></i> Edit desired property</a>
						<a class="none btn remove-property-images"><i class="icon-minus"></i>Remove images</a>
					</div>
				</div>
				<div id="div-remove-photo-properties" class="div-manage-property hidden">
					<?php $this->load->view('forms/photos-properties');?>
					<div class="form-actions">
						<a class="none btn btn-edit-main-property"><i class="icon-edit"></i> Edit main property</a>
						<a class="none btn edit-desired-property"><i class="icon-edit"></i> Edit desired property</a>
						<a class="none btn add-property-images"><i class="icon-plus"></i> Add images</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->view("broker_interface/includes/footer");?>
	<?php $this->load->view("broker_interface/includes/scripts");?>
	<script type="text/javascript" src="<?=site_url('js/upload.js');?>"></script>
</body>
</html>
