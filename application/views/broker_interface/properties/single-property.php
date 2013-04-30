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
				<?php $this->load->view("broker_interface/forms/set-active-property");?>
				<?php if($this->uri->segment(2) == 'properties'):?>
					<a href="<?=site_url('broker/register-properties');?>" class="btn btn-small btn-link" type="button">Add new Property</a>
				<?php endif;?>
				</div>
				<div class="clear"></div>
			<?php if($property):?>
				<?php $this->load->helper('text');?>
				<div class="media">
					<a class="none pull-left" href="#">
						<img class="img-polaroid media-object" src="<?=site_url($property['photo']);?>" alt="">
					</a>
					<div class="media-body">
						<h4 class="media-heading">
							<a href="<?=site_url('broker/'.$this->uri->segment(2).'/information/'.$property['id']);?>"><?= $property['address1'];?></a>
							<span><?= $property['city'].', '.$property['state'].' '.$property['zip_code']; ?></span>
						</h4>
						<p>
							$<?=$property['price'];?> <span class="separator">|</span> 
							<?=$property['bedrooms'];?> Bd <span class="separator">|</span> 
							<?=$property['bathrooms'];?> Ba <span class="separator">|</span> 
							<?=$property['sqf'];?> Sq Ft <span class="separator">|</span> 
							<?=$property['lotsize'];?> Acres <br/>
							<?= ucfirst($property['type']); ?> Home
						</p>
						<!-- 
						<p><em><?=word_limiter($property['description'],50);?></em></p>
						<p>
							For Sale: $<?=$property['price'];?> <br/>
							Bedrooms: <?=$property['bedrooms'];?> beds <br/>
							Bathrooms: <?=$property['bathrooms'];?> baths <br/>
							<?= ucfirst($property['type']); ?>: <?=$property['sqf'];?> sq ft<br/>
							Lot: <?= $property['sqf'];?> sq ft <br/>
							Tax: $<?= $property['tax']; ?>
						</p>
						-->
					</div>
				</div>
			<?php else:?>
				<p>Property is missing or is not selected</p>
			<?php endif;?>
			</div>
		</div>
	</div>
	<?php $this->load->view("broker_interface/includes/footer");?>
	<?php $this->load->view("broker_interface/includes/scripts");?>
</body>
</html>
