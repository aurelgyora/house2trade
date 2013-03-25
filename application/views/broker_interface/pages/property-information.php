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
				<div class="span4">
					<a class="none pull-left" href="#">
						<img class="span3 img-polaroid media-object" src="<?=site_url($property['photo']);?>" alt="">
					</a>
					<div class="clear"></div>
					<div class="span2">
						Price: <br/>Bedrooms: <br/>Bathrooms: <br/>Square:
					</div>
					<div class="span1">
						$<?=$property['price'];?><br/><?=$property['bedrooms'];?><br/><?=$property['bathrooms'];?><br/><?=$property['sqf'];?>
					</div>
				</div>
				<div class="span4">
					<h3>Property Description</h3>
					<div>
						<?=$property['description'];?>
					</div>
					<div class="clear"></div>
					<h3>Contact Information</h3>
					<div>
						<div class="span1">
							Phone: <br/>cell: <br/>Email:
						</div>
						<div class="span1">
							<?=$property['phone'];?><br/><?=$property['cell'];?><br/><?=$property['email'];?>
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<hr/>
				<?php if($property['broker_id'] == $this->user['uid']):?>
				<div>
					<a href="<?=site_url(BROKER_START_PAGE.'/edit/'.$property['id']);?>" class="btn btn-link btn-mini" type="button">Edit property</a>
					<a class="btn btn-mini btn-link link-operation-account" href="#confirm-user" data-toggle="modal" data-src="<?=$property['id'];?>" data-url="<?=site_url(BROKER_START_PAGE.'/delete');?>">Delete property</a>
				</div>
				<?php else:?>
				<div>
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
