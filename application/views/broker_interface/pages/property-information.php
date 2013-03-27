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
						<?=anchor($this->session->userdata('backpath'),'Back');?>
					</div>
				</div>
			<?php if($property):?>
				<p>
					<img class="img-polaroid" src="<?=site_url($property['photo']);?>" alt="">
				</p>
				<h2 class="pp">Property Details</h2>
				<p>
					For Sale: $<?=$property['price'];?> <br/>
					Bedrooms: <?=$property['bedrooms'];?> beds <br/>
					Bathrooms: <?=$property['bathrooms'];?> baths <br/>
					<?= ucfirst($property['type']); ?>: <?=$property['sqf'];?> sq ft<br/>
					Lot: <?= $property['sqf'];?> sq ft <br/>
					Tax: $<?= $property['tax']; ?>
				</p>
				<h2 class="pp">Description</h2>
				<p>
					<?=$property['description'];?>
				</p>
				<h2 class="pp">Contacts</h2>
				<p>
					Phone: <?=$property['phone'];?><br/>
					Cell: <?=$property['cell'];?><br/>
					Email: <a href="mailto:<?=$property['email'];?>"><?=$property['email'];?></a>
				</p>
				<?php if($property['broker_id'] == $this->user['uid']):?>
				<div>
					<a href="<?=site_url(BROKER_START_PAGE.'/edit/'.$property['id']);?>" class="btn btn-link btn-mini" type="button">Edit property</a>
					<a class="btn btn-mini btn-link link-operation-account" href="#confirm-user" data-toggle="modal" data-src="<?=$property['id'];?>" data-url="<?=site_url(BROKER_START_PAGE.'/delete');?>">Delete property</a>
				</div>
				<?php else:?>
				<div>
			<?php if($this->session->userdata('current_owner')):?>
				<?php if(!$property['favorite']):?>
					<button class="btn btn-mini btn-link btn-property-add-favorite" data-src="<?=$property['id'];?>">Add to favorite</button>
					<button class="btn btn-mini btn-link btn-property-add-potential-by" style="display: none;" data-src="<?=$property['id'];?>">Add to potential by</button>
					<?php if($property['potentialby']):?>
					<button class="btn btn-mini btn-link btn-property-remove-potential-by" data-src="<?=$property['id'];?>">Remove from potential by</button>
					<?php endif;?>
				<?php elseif($property['favorite']):?>
					<button class="btn btn-mini btn-link btn-property-remove-favorite" data-src="<?=$property['id'];?>">Remove from favorite</button>
					<?php if(!$property['potentialby']):?>
					<button class="btn btn-mini btn-link btn-property-add-potential-by" data-src="<?=$property['id'];?>">Add to potential by</button>
					<?php elseif($property['potentialby']):?>
					<button class="btn btn-mini btn-link btn-property-remove-potential-by" data-src="<?=$property['id'];?>">Remove from potential by</button>
					<?php endif;?>
				<?php endif;?>
			<?php endif;?>
				</div>
				<?php endif;?>
			<?php else:?>
				<h3>Information is missing</h3>
			<?php endif;?>
			</div>
		</div>
		<?php $this->load->view("modal/confirm-user");?>
	</div>
	<?php $this->load->view("broker_interface/includes/scripts");?>
</body>
</html>
