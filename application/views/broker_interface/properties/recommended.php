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
				<?php $this->load->view("broker_interface/forms/select-property");?>
				</div>
				<div class="clear"></div>
			<?php if($this->session->userdata('current_property') == FALSE || empty($properties)):?>
				<p>Recommended properties is missing or is not selected current seller</p>
			<?php endif;?>
			<?php if($this->session->userdata('current_property') != FALSE):?>
				<div class="div-desired-property-form hidden">
					<?php $this->load->view('broker_interface/forms/edit-desired-properties');?>
				</div>
				<a class="none btn btn-link show-desired-property-form" href="">Show form of desired property</a>
			<?php endif;?>
				<?php $this->load->helper('text');?>
			<?php for($i=0;$i<count($properties);$i++):?>
					<div class="media">
						<a class="pull-left" href="<?=site_url('broker/properties/information/'.$properties[$i]['id']);?>">
							<img class="img-polaroid media-object" src="<?=site_url($properties[$i]['photo']);?>" alt="">
						</a>
						<div class="media-body">
							<h4 class="media-heading">
								<a href="<?=site_url('broker/properties/information/'.$properties[$i]['id']);?>"><?= $properties[$i]['address1'];?></a>
								<span><?= $properties[$i]['city'].', '.$properties[$i]['state'].' '.$properties[$i]['zip_code']; ?></span>
							</h4>
							<p><em><?=word_limiter($properties[$i]['description'],50);?></em></p>
							<p>
								$<?=$properties[$i]['price'];?> <span class="separator">|</span> 
								<?=$properties[$i]['bedrooms'];?> Bd <span class="separator">|</span> 
								<?=$properties[$i]['bathrooms'];?> Ba <span class="separator">|</span> 
								<?=$properties[$i]['sqf'];?> Sq Ft <span class="separator">|</span> 
								<?=$properties[$i]['lotsize'];?> Acres <br/>
								<?= ucfirst($properties[$i]['type']); ?> Home
							</p>
						</div>
			<?php if($properties[$i]['id'] != $this->session->userdata('current_property')):?>
				<?php if(!$properties[$i]['potentialby']):?>
					<?php if(!$properties[$i]['favorite']):?>
						<button class="btn btn-mini btn-link btn-property-add-favorite" data-src="<?=$properties[$i]['id'];?>">Add to favorite</button>
						<button class="btn btn-mini btn-link btn-property-remove-favorite hidden" data-target="null" data-src="<?=$properties[$i]['id'];?>">Remove from favorite</button>
					<?php else:?>
						<button class="btn btn-mini btn-link btn-property-remove-favorite" data-target="null" data-src="<?=$properties[$i]['id'];?>">Remove from favorite</button>
						<button class="btn btn-mini btn-link btn-property-add-favorite hidden" data-src="<?=$properties[$i]['id'];?>">Add to favorite</button>
					<?php endif;?>
				<?php else:?>
						<h4>Already added to potential by</h4>
				<?php endif;?>
			<?php endif;?>
					</div>
			<?php endfor;?>
			<?=$pages;?>
			</div>
		</div>
		<?php $this->load->view("broker_interface/modal/add-to-potential-by");?>
	</div>
	<?php $this->load->view("broker_interface/includes/footer");?>
	<?php $this->load->view("broker_interface/includes/scripts");?>
</body>
</html>