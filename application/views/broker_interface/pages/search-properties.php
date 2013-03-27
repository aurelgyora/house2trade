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
				</div>
				<div class="clear"></div>
				<div id="div-search-property" <?=($this->session->userdata('search_sql'))?'class="hidden"':'';?>>
					<?php $this->load->view('forms/search-properties');?>
				</div>
			<?php if($this->session->userdata('search_sql')):?>
				<a class="none btn btn-link" id="a-search-property" href="">Search Form</a>
				<div class="clear"></div>
				<hr/>
				<?php $this->load->helper('text');?>
				<div id="div-search-property-result">
					<?php if(isset($zillow) && $zillow):?>
						<div class="media">
							<a class="none pull-left" href="#">
								<img class="img-polaroid media-object" src="<?=site_url($zillow['photo']);?>" alt="">
							</a>
							<div class="media-body">
								<h4 class="media-heading">
								<?php if($zillow_exist_id):?>
									<a href="<?=site_url(BROKER_START_PAGE.'/information/'.$zillow['id']);?>"><?=$zillow['address1'].', '.$zillow['city'].', '.$zillow['state'];?></a>
								<?php else:?>
									<?=$zillow['address1'].', '.$zillow['city'].', '.$zillow['state'];?> <br/>
									<small>Property is not in our listing</small>
								<?php endif;?>
								</h4>
								<p><em><?=word_limiter($zillow['description'],100);?></em></p>
								<p>
									For Sale: $<?=$zillow['price'];?> <br/>
									Bedrooms: <?=$zillow['bedrooms'];?> beds <br/>
									Bathrooms: <?=$zillow['bathrooms'];?> baths <br/>
									<?= ucfirst($zillow['type']); ?>: <?=$zillow['sqf'];?> sq ft<br/>
									Lot: <?= $zillow['sqf'];?> sq ft <br/>
									Tax: $<?= substr($zillow['tax'], 0, strlen($zillow['tax'])-2); ?>
								</p>
							</div>
						</div>
					<?php endif;?>
				<?php for($i=0;$i<count($properties);$i++):?>
					<?php if(isset($zillow_exist_id) && ($properties[$i]['id'] == $zillow_exist_id)):?>
						<?php continue;?>
					<?php endif;?>
					<div class="media">
						<a class="none pull-left" href="#">
							<img class="img-polaroid media-object" src="<?=site_url($properties[$i]['photo']);?>" alt="">
						</a>
						<div class="media-body">
							<h4 class="media-heading">
								<a href="<?=site_url(BROKER_START_PAGE.'/information/'.$properties[$i]['id']);?>"><?= $properties[$i]['address1'].', '.$properties[$i]['city'].', '.$properties[$i]['state'].' '.$properties[$i]['zip_code'];?></a>
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
				<?php if($this->session->userdata('current_owner')):?>
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
				</div>
				<?=$pages;?>
			<?php endif;?>
			</div>
		</div>
	</div>
	<?php $this->load->view("broker_interface/includes/scripts");?>
</body>
</html>
