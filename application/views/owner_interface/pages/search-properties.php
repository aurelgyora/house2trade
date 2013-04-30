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
								<img class="img-polaroid media-object" src="<?=$zillow['photo'];?>" alt="">
							</a>
							<div class="media-body">
								<h4 class="media-heading">
								<?php if($zillow_exist_id):?>
									<a href="<?=site_url('homeowner/search/information/'.$zillow['id']);?>"><?=$zillow['address1'].', '.$zillow['city'].', '.$zillow['state'];?></a>
								<?php else:?>
									<?=$zillow['address1'].', '.$zillow['city'].', '.$zillow['state'];?> <br/>
									<small>Property is not in our listing</small>
								<?php endif;?>
								</h4>
								<p><em><?=word_limiter($zillow['description'],100);?></em></p>
								<p>
									For Sale: $<?=($zillow['price'])?$zillow['price']:' &mdash;';?><br/>
									Bedrooms: <?=($zillow['bedrooms'])?$zillow['bedrooms'].' beds':'&mdash;';?><br/>
									Bathrooms: <?=($zillow['bathrooms'])?$zillow['bathrooms'].' beds':'&mdash;';?><br/>
									<?= ucfirst($zillow['type']); ?>: <?=$zillow['sqf'];?> sq ft<br/>
									Lot: <?= $zillow['sqf'];?> sq ft <br/>
									Tax: $<?=$zillow['tax'];?>
								<?php if(isset($zillow['year']) && $zillow['year']):?>
									<br/>Year Built: <?= $zillow['year'];?><br/>
								<?php endif;?>
								<?php if(isset($zillow['last-sold-date']) && $zillow['last-sold-date']):?>
									Last Sold: <?= date("M Y",strtotime($zillow['last-sold-date']));?>
								<?php endif;?>
								<?php if(isset($zillow['last-sold-price']) && $zillow['last-sold-price']):?>
									 for $<?= $zillow['last-sold-price'];?>
								<?php endif;?>
								</p>
							</div>
						<?php if($zillow_exist_id && !$zillow['potentialby']):?>
							<?php if(!$zillow['favorite']):?>
								<button class="btn btn-mini btn-link btn-property-add-favorite" data-src="<?=$zillow['id'];?>">Add to favorite</button>
								<button class="btn btn-mini btn-link btn-property-remove-favorite hidden" data-src="<?=$zillow['id'];?>">Remove from favorite</button>
							<?php else:?>
								<button class="btn btn-mini btn-link btn-property-remove-favorite" data-src="<?=$zillow['id'];?>">Remove from favorite</button>
								<button class="btn btn-mini btn-link btn-property-add-favorite hidden" data-src="<?=$zillow['id'];?>">Add to favorite</button>
							<?php endif;?>
						<?php endif;?>
						</div>
					<?php endif;?>
				<?php for($i=0;$i<count($properties);$i++):?>
					<?php if(isset($zillow_exist_id) && ($properties[$i]['id'] == $zillow_exist_id)):?>
						<?php continue;?>
					<?php endif;?>
					<div class="media">
						<a class="pull-left" href="<?=site_url('homeowner/search/information/'.$properties[$i]['id']);?>">
							<img class="img-polaroid media-object" src="<?=site_url($properties[$i]['photo']);?>" alt="">
						</a>
						<div class="media-body">
							<h4 class="media-heading">
								<a href="<?=site_url('homeowner/search/information/'.$properties[$i]['id']);?>"><?= $properties[$i]['address1'].', '.$properties[$i]['city'].', '.$properties[$i]['state'].' '.$properties[$i]['zip_code'];?></a>
							</h4>
							<p><em><?=word_limiter($properties[$i]['description'],50);?></em></p>
							<p>
								For Sale: $<?=$properties[$i]['price'];?> <br/>
								Bedrooms: <?=($properties[$i]['bedrooms'])?$properties[$i]['bedrooms'].' beds':'&mdash;';?><br/>
								Bathrooms: <?=($properties[$i]['bathrooms'])?$properties[$i]['bathrooms'].' baths':'&mdash;';?><br/>
								<?= ucfirst($properties[$i]['type']); ?>: <?=$properties[$i]['sqf'];?> sq ft<br/>
								Lot: <?= $properties[$i]['sqf'];?> sq ft <br/>
								Tax: $<?= $properties[$i]['tax']; ?>
							</p>
						</div>
			<?php if(($properties[$i]['owner'] != $this->account['id']) && ($properties[$i]['status'] != 17)):?>
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
				</div>
				<?=$pages;?>
			<?php endif;?>
			</div>
		</div>
	</div>
	<?php $this->load->view("owner_interface/includes/footer");?>
	<?php $this->load->view("owner_interface/includes/scripts");?>
</body>
</html>
