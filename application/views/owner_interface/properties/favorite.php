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
			<?php if($this->session->userdata('current_property') === FALSE || $this->owner['seller'] || count($select) > 1):?>
				<div class="navbar">
					<?php $this->load->view("owner_interface/forms/set-active-property");?>
				</div>
				<div class="clear"></div>
			<?php endif;?>
				<?php $this->load->helper('text');?>
			<?php for($i=0;$i<count($properties);$i++):?>
				<div class="media">
					<a class="none pull-left" href="#">
						<img class="img-polaroid media-object" src="<?=site_url($properties[$i]['photo']);?>" alt="">
					</a>
					<div class="media-body">
						<h4 class="media-heading">
							<a href="<?=site_url('homeowner/'.$this->uri->segment(2).'/information/'.$properties[$i]['id']);?>">
								<small>HT-<?=$properties[$i]['id'];?></small> <?=$properties[$i]['address1'];?>
							</a>
							<span><?= $properties[$i]['city'].', '.$properties[$i]['state'].' '.$properties[$i]['zip_code']; ?></span>
						</h4>
						<p>
							$<?=$properties[$i]['price'];?> <span class="separator">|</span> 
							<?=$properties[$i]['bedrooms'];?> Bd <span class="separator">|</span> 
							<?=$properties[$i]['bathrooms'];?> Ba <span class="separator">|</span> 
							<?=$properties[$i]['sqf'];?> Sq Ft <span class="separator">|</span> 
							<?=$properties[$i]['lotsize'];?> Acres <br/>
							<?= ucfirst($properties[$i]['type']); ?> Home
						</p>
					</div>
				<?php if($properties[$i]['status'] == 3):?>
					<p class="property-owner">Property under contract</p>
					<div class="clear"></div>
				<?php endif;?>
					<button class="btn btn-mini btn-link btn-property-remove-favorite" data-target="remove" data-src="<?=$properties[$i]['id'];?>">Remove from worth seeing</button>
				<?php if($properties[$i]['status'] != 17):?>
					<a href="#addToPotentialBy" role="button" class="btn btn-mini btn-link show-modal-confirm" data-propery-target="remove" data-propery-id="<?=$properties[$i]['id'];?>" data-toggle="modal">Add to potential buy</a>
				<?php endif;?>
				</div>
			<?php endfor;?>
			<?php if($this->session->userdata('current_property') === FALSE || !$properties):?>
				<p>Favorite properties is missing or is not selected current seller</p>
			<?php endif;?>
			<?=$pages;?>
			</div>
		</div>
		<?php $this->load->view("broker_interface/modal/add-to-potential-by");?>
	</div>
	<?php $this->load->view("owner_interface/includes/footer");?>
	<?php $this->load->view("owner_interface/includes/scripts");?>
</body>
</html>