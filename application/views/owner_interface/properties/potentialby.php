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
					<?php $this->load->view("owner_interface/forms/setect-property");?>
				</div>
				<div class="clear"></div>
				<?php $this->load->helper('text');?>
			<?php for($i=0;$i<count($properties);$i++):?>
				<div class="media">
					<a class="none pull-left" href="#">
						<img class="img-polaroid media-object" src="<?=site_url($properties[$i]['photo']);?>" alt="">
					</a>
					<div class="media-body">
						<h4 class="media-heading">
							<a href="<?=site_url('homeowner/'.$this->uri->segment(2).'/information/'.$properties[$i]['id']);?>"><?= $properties[$i]['address1'].', '.$properties[$i]['city'].', '.$properties[$i]['state'].' '.$properties[$i]['zip_code'];?></a>
						</h4>
						<p><em><?=word_limiter($properties[$i]['description'],50);?></em></p>
						<p>
							For Sale: $<?=$properties[$i]['price'];?> <br/>
							Bedrooms: <?=$properties[$i]['bedrooms'];?> beds <br/>
							Bathrooms: <?=$properties[$i]['bathrooms'];?> baths <br/>
							<?= ucfirst($properties[$i]['type']); ?>: <?=$properties[$i]['sqf'];?> sq ft<br/>
							Lot: <?= $properties[$i]['sqf'];?> sq ft <br/>
							Tax: $<?= $properties[$i]['tax']; ?>
						</p>
					</div>
					<button class="btn btn-mini btn-link btn-property-remove-potential-by" data-target="remove" data-src="<?=$properties[$i]['id'];?>">Remove from potential by</button>
				</div>
			<?php endfor;?>
			<?php if(!$this->session->userdata('current_property') || !$properties):?>
				<p>Favorite properties is missing or is not selected current seller</p>
			<?php endif;?>
			</div>
		</div>
	</div>
	<?php $this->load->view("owner_interface/includes/footer");?>
	<?php $this->load->view("owner_interface/includes/scripts");?>
</body>
</html>