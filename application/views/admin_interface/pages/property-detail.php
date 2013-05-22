<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view("admin_interface/includes/head");?>
<link rel="stylesheet" href="<?=site_url('css/fotorama.css');?>" />
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
						<?=anchor($this->session->userdata('backpath'),'Back to properties list','class="btn btn-link"');?>
					</div>
				</div>
				<div class="clear"></div>
		<?php if($property):?>
				<div class="span5">
			<?php if($images): ?>
				<div class="fotorama" data-width="460" data-height="333" data-cropToFit="true" data-loop="true" data-autoplay="true">
				<?php for($i=0;$i<count($images);$i++):?>
					<a href="<?=site_url($images[$i]['photo']);?>"><img src="<?=site_url($images[$i]['photo']);?>"></a>
				<?php endfor;?>
				</div>
			<?php else:?>
				<p><img src="<?=site_url('img/thumb.png');?>"></p>
			<?php endif;?>
				</div>
				<div class="span3">
					<h1 class="pp-title"><?= $property['address1'].'<br/>'.$property['city'].', '.$property['state'].' '.$property['zip_code'];?></h1>
					<h2 class="pp">Property Details</h2>
					<p>
						<strong>Foreclosure:</strong> $<?=$property['price'];?> <br/>
						<strong>Bedrooms:</strong> <?=$property['bedrooms'];?> beds <br/>
						<strong>Bathrooms:</strong> <?=$property['bathrooms'];?> baths <br/>
						<strong><?= ucfirst($property['type']); ?></strong>: <?=$property['sqf'];?> sq ft<br/>
						<strong>Lot:</strong> <?= $property['sqf'];?> sq ft <br/>
						<strong>Tax:</strong> $<?= $property['tax']; ?>
					</p>
					<h2 class="pp">Description</h2>
					<p><?=$property['description'];?></p>
				<?php if($property['status'] < 17 && isset($property['email'])):?>
					<h2 class="pp">Contacts</h2>
					<p>
						<strong>Phone:</strong> <?=$property['phone'];?><br/>
						<strong>Cell:</strong> <?=$property['cell'];?><br/>
						<strong>Email:</strong> <?=$property['email'];?>
					</p>
				<?php else:?>
					<p>Not from our listing</p>
				<?php endif;?>
				</div>
		<?php else:?>
			<h3>Information is missing</h3>
		<?php endif;?>
			</div>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/footer");?>
	<?php $this->load->view("admin_interface/includes/scripts");?>
</body>
</html>
