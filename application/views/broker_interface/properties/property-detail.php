<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view("broker_interface/includes/head");?>
<link rel="stylesheet" href="<?=site_url('css/fotorama.css');?>" />
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
					<?php if($this->session->userdata('search_sql')):?>
						<?=anchor('broker/search/result','Back to search result','class="btn btn-link"');?>
						<?php if($this->session->userdata('backpath') == BROKER_START_PAGE):?>
							<?=anchor('broker/search/result','Back to my properties','class="btn btn-link"');?>
						<?php endif;?>
					<?php else:?>
						<?=anchor($this->session->userdata('backpath'),'Back','class="btn btn-link"');?>
					<?php endif;?>
					</div>
				</div>
	<?php if($property):?>
				<?php $this->load->view("broker_interface/forms/set-current-property");?>
			<?php if($images):?>
				<div class="fotorama" data-width="499" data-height="333">
				<?php for($i=0;$i<count($images);$i++):?>
					<a href="<?=site_url($images[$i]['photo']);?>"><img src="<?=site_url($images[$i]['photo']);?>"></a>
				<?php endfor;?>
				</div>
			<?php else:?>
				<p><img src="<?=site_url('img/thumb.png');?>"></p>
			<?php endif;?>
				<h2 class="pp">Property Details</h2>
				<p>
					City, Address, State, Zip: <?=$property['city'].', '.$property['address1'].', '.$property['state'].' '.$property['zip_code'];?> <br/>
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
			<?php if($property['status'] < 17):?>
				<h2 class="pp">Contacts</h2>
				<p>
					Phone: <?=$property['phone'];?><br/>
					Cell: <?=$property['cell'];?><br/>
					Email: <a href="mailto:<?=$property['email'];?>"><?=$property['email'];?></a>
				</p>
			<?php endif;?>
			<?php if($property['broker'] == $this->account['id']):?>
				<a href="<?=site_url(BROKER_START_PAGE.'/edit/'.$property['id']);?>" class="btn btn-link btn-mini" type="button">Edit property</a>
				<a class="btn btn-mini btn-link link-operation-account" href="#confirm-user" data-toggle="modal" data-src="<?=$property['id'];?>" data-url="<?=site_url(BROKER_START_PAGE.'/delete');?>">Delete property</a>
			<?php endif;?>
	<?php if($property['status'] != 17):?>
		<?php if(($property['id'] != $this->session->userdata('current_property'))):?>
			<?php if(!$property['potentialby']):?>
				<?php if(!$property['favorite']):?>
					<button class="btn btn-mini btn-link btn-property-add-favorite" data-src="<?=$property['id'];?>">Add to favorite</button>
					<button class="btn btn-mini btn-link btn-property-remove-favorite hidden" data-target="null" data-src="<?=$property['id'];?>">Remove from favorite</button>
				<?php else:?>
					<button class="btn btn-mini btn-link btn-property-remove-favorite" data-target="null" data-src="<?=$property['id'];?>">Remove from favorite</button>
					<button class="btn btn-mini btn-link btn-property-add-favorite hidden" data-src="<?=$property['id'];?>">Add to favorite</button>
				<?php endif;?>
			<?php else:?>
					<h3>Already added to potential by</h3>
				<?php endif;?>
		<?php else:?>
				<button class="btn btn-mini btn-link disabled" disabled="disabled">Add to favorite</button>
		<?php endif;?>
	<?php endif;?>
	<?php else:?>
				<h3>Information is missing</h3>
	<?php endif;?>
			</div>
		</div>
		<?php $this->load->view("modal/confirm-user");?>
	</div>
	<?php $this->load->view("broker_interface/includes/footer");?>
	<?php $this->load->view("broker_interface/includes/scripts");?>
	<script type="text/javascript" src="<?=site_url('js/vendor/fotorama.js');?>"></script>
</body>
</html>
