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
				<p>See foreclosures in your area - for free!</p>
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
								<?php if($zillow_exist_id != FALSE):?>
									<a href="<?=site_url('broker/'.$this->uri->segment(2).'/information/'.$zillow['id']);?>"><?=$zillow['address1'];?></a>
									<span><?=$zillow['city'].', '.$zillow['state'].' '.$zillow['zip_code']; ?></span>
									<?php if($zillow['status'] == 17):?>
										<small>Property is not in our listing</small>
									<?php endif;?>
								<?php else:?>
									<a href="#"><?=$zillow['address1'];?></a>
									<span><?=$zillow['city'].', '.$zillow['state'].' '.$zillow['zip_code']; ?></span>
									<small>Property is not in our listing</small>
								<?php endif; ?>
								</h4>
								<p>
									$<?=$zillow['price'];?> <span class="separator">|</span> 
									<?=$zillow['bedrooms'];?> Bd <span class="separator">|</span> 
									<?=$zillow['bathrooms'];?> Ba <span class="separator">|</span> 
									<?=$zillow['sqf'];?> Sq Ft <span class="separator">|</span> 
									<?=$zillow['lotsize'];?> Acres <br/>
									<?= ucfirst($zillow['type']); ?> Home
									<?php if(isset($zillow['year']) && $zillow['year']):?>
									<span class="separator">|</span> Built <?= $zillow['year'];?>
									<?php endif;?>
									<?php if(isset($zillow['last-sold-date']) && $zillow['last-sold-date']):?>
									<span class="separator">|</span>Last Sold in <?= date("M Y",strtotime($zillow['last-sold-date']));?>
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
						<a class="pull-left" href="<?=site_url('broker/search/information/'.$properties[$i]['id']);?>">
							<img class="img-polaroid media-object" src="<?=site_url($properties[$i]['photo']);?>" alt="">
						</a>
						<div class="media-body">
							<h4 class="media-heading">
								<a href="<?=site_url('broker/'.$this->uri->segment(2).'/information/'.$properties[$i]['id']);?>">
									<small>HT-<?=$properties[$i]['id'];?></small> <?=$properties[$i]['address1'];?>
								</a>
								<span><?= $properties[$i]['city'].', '.$properties[$i]['state'].' '.$properties[$i]['zip_code']; ?></span>
							</h4>
							<?php if($properties[$i]['status'] == 17):?>
								<small>Property is not in our listing</small>
							<?php endif;?>
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
						<p class="property-owner">Already added to potential by</p>
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
	<?php $this->load->view("broker_interface/includes/footer");?>
	<?php $this->load->view("broker_interface/includes/scripts");?>
</body>
</html>