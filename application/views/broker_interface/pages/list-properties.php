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
					<?php $this->load->view("forms/select-active-owner");?>
				<?php if($this->uri->segment(2) == 'properties'):?>
					<a href="<?=site_url('broker/register-properties');?>" class="btn btn-small btn-link pull-right" type="button">Add new Property</a>
				<?php endif;?>
				</div>
				<div class="clear"></div>
				<?php $this->load->helper('text');?>
			<?php for($i=0;$i<count($properties);$i++):?>
				<div class="media">
					<a class="none pull-left" href="#">
						<img class="span2 img-polaroid media-object" src="<?=site_url($properties[$i]['photo']);?>" alt="">
					</a>
					<div class="media-body">
						<h4 class="media-heading">
							<a href="<?=site_url('broker/'.$this->uri->segment(2).'/information/'.$properties[$i]['id']);?>"><?=$properties[$i]['address1'];?></a>
						</h4>
						<p><em><?=word_limiter($properties[$i]['description'],50);?></em></p>
						<p>
							<?=$properties[$i]['city'].', '.$properties[$i]['state'].', '.$properties[$i]['type'];?><br/>
							Bathrooms: <?=$properties[$i]['bathrooms'];?>, Bedrooms: <?=$properties[$i]['bedrooms'];?>, Square: <?=$properties[$i]['sqf'];?>,
							Tax: <?=$properties[$i]['tax'];?>, Price: <?=$properties[$i]['price'];?>.
						</p>
					</div>
			<?php if($properties[$i]['owner_id'] != $this->session->userdata('current_owner')):?>
				<?php if(!$properties[$i]['favorite']):?>
					<button class="btn btn-mini btn-link btn-property-add-favorite" data-src="<?=$properties[$i]['id'];?>">Add to favorite</button>
					<button class="btn btn-mini btn-link btn-property-add-potential-by" style="display: none;" data-src="<?=$properties[$i]['id'];?>">Add to potential by</button>
					<?php if($properties[$i]['potentialby']):?>
					<button class="btn btn-mini btn-link btn-property-remove-potential-by" data-src="<?=$properties[$i]['id'];?>">Remove from potential by</button>
					<?php endif;?>
				<?php elseif($properties[$i]['favorite']):?>
					<button class="btn btn-mini btn-link btn-property-remove-favorite" data-src="<?=$properties[$i]['id'];?>">Remove from favorite</button>
					<?php if(!$properties[$i]['potentialby']):?>
					<button class="btn btn-mini btn-link btn-property-add-potential-by" data-src="<?=$properties[$i]['id'];?>">Add to potential by</button>
					<?php elseif($properties[$i]['potentialby']):?>
					<button class="btn btn-mini btn-link btn-property-remove-potential-by" data-src="<?=$properties[$i]['id'];?>">Remove from potential by</button>
					<?php endif;?>
				<?php endif;?>
			<?php endif;?>
				</div>
			<?php endfor;?>
			<?php if(!$properties):?>
				<h3>List is empty or not selected homeowner</h3>
			<?php endif;?>
			</div>
		</div>
	</div>
	<?php $this->load->view("broker_interface/includes/scripts");?>
</body>
</html>
