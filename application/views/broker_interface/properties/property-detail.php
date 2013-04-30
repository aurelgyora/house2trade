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
			<div class="span6">
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
			</div>
			<div class="row">
				<div class="span6">
				
				<?php if($property):?>
					<?php $this->load->view("broker_interface/forms/set-current-property");?>
						
					<ul class="nav nav-tabs" id="myTab">
						<?php if($images):?>
						<li class="active"><a href="#photos">Photos</a></li>
						<?php endif; ?>
						<li><a href="#map">Map</a></li>
						<li><a href="#panorama">Street View</a></li>
					</ul>
					 
					<div class="tab-content">
						<div class="tab-pane" id="map">
							<div id="map-canvas" style="width: 450px; height: 300px"></div>
						</div>
						
						<div class="tab-pane" id="panorama">
    						<div id="pano" style="width: 450px; height: 300px;"></div>
						</div>
						
						<?php if($images): ?>
						<div class="tab-pane active" id="photos">
							<div class="fotorama" data-width="460" data-height="333" data-cropToFit="true" data-loop="true" data-autoplay="true">
							<?php for($i=0;$i<count($images);$i++):?>
								<a href="<?=site_url($images[$i]['photo']);?>"><img src="<?=site_url($images[$i]['photo']);?>"></a>
							<?php endfor;?>
							</div>
						</div>
						<?php else:?>
							<p><img src="<?=site_url('img/thumb.png');?>"></p>
						<?php endif;?>
					</div>
					
					<div class="property-actions">
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
					</div>
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
					<p>
						<?=$property['description'];?>
					</p>
				<?php if($property['status'] < 17):?>
					<h2 class="pp">Contacts</h2>
					<p>
						<strong>Phone:</strong> <?=$property['phone'];?><br/>
						<strong>Cell:</strong> <?=$property['cell'];?><br/>
						<strong>Email:</strong> <?=$property['email'];?>
					</p>
				<?php endif;?>
				<?php else:?>
					<h3>Information is missing</h3>
				<?php endif;?>
				</div>
			</div>
		</div>
		<?php $this->load->view("modal/confirm-user");?>
	</div>
	<?php $this->load->view("broker_interface/includes/footer");?>
	<?php $this->load->view("broker_interface/includes/scripts");?>
	<script type="text/javascript" src="<?=site_url('js/vendor/fotorama.js');?>"></script>
	<script type="text/javascript">
	  	$('#myTab a').click(function (e) {
			e.preventDefault();
			$(this).tab('show');
			initialize();
		})
	</script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript">
		var geocoder, map, marker, panorama;
		
		function initialize() {
			var mapOptions = {
				zoom : 15,
				mapTypeId : google.maps.MapTypeId.ROADMAP
			}
			map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
			
		  	var panoramaOptions = {
		    	pov: {
		      		heading: 18,
		      		pitch: 5
		    	}
		  	};
		  	panorama = new  google.maps.StreetViewPanorama(document.getElementById('pano'), panoramaOptions);			
			
			geocoder = new google.maps.Geocoder();
			geocoder.geocode({
				'address' : "<?= $property['address1'].', '.$property['city'].', '.$property['state'].' '.$property['zip_code'].', United States';?>"
			}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					map.setCenter(results[0].geometry.location);
					panorama.setPosition(results[0].geometry.location);
					marker = new google.maps.Marker({
						map : map,
						position : results[0].geometry.location
					});
				} else { }
			});
		
	  		map.setStreetView(panorama);
		}
		
		initialize();
	</script>	
</body>
</html>
