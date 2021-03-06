<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view("admin_interface/includes/head");?>

<link rel="stylesheet" href="<?=base_url('css/chosen.css');?>" />
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
						<a class="brand" href="<?=site_url(ADM_START_PAGE.'/properties');?>">Properties</a>
					</div>
				</div>
				<div id="div-search-property">
					<?php $this->load->view('admin_interface/forms/search-properties');?>
				</div>
				<?php $this->load->helper('text');?>
			<?php for($i=0;$i<count($properties);$i++):?>
				<div class="media">
					<a class="pull-left" href="<?=site_url(ADM_START_PAGE.'/properties/information/'.$properties[$i]['id']);?>">
						<img class="img-polaroid media-object" src="<?=site_url($properties[$i]['photo']);?>" alt="">
					</a>
					<div class="media-body">
						<h4 class="media-heading">
							<a href="<?=site_url(ADM_START_PAGE.'/properties/information/'.$properties[$i]['id']);?>"><?= $properties[$i]['address1'];?></a>
							<span><?= $properties[$i]['city'].', '.$properties[$i]['state'].' '.$properties[$i]['zip_code']; ?></span>
						</h4>
						<p>
							$<?=$properties[$i]['price'];?> <span class="separator">|</span> 
							<?=$properties[$i]['bedrooms'];?> Bd <span class="separator">|</span> 
							<?=$properties[$i]['bathrooms'];?> Ba <span class="separator">|</span> 
							<?=$properties[$i]['sqf'];?> Sq Ft <span class="separator">|</span> 
							<?=$properties[$i]['lotsize'];?> Acres <br/>
							<?= ucfirst($properties[$i]['type']); ?> Home
						</p>
						<?php if($properties[$i]['status'] == 11):?>
							<p class="property-owner">Broker deactive property</p>
						<?php elseif($properties[$i]['status'] == 12):?>
							<p class="property-owner">Homeowner deactive property</p>
						<?php endif;?>
						<?=getPropertyStatus($properties[$i]['id'],$properties[$i]['status'],$this->profile['group']);?>
					</div>
				</div>
			<?php endfor;?>
			<?=$pagination;?>
			</div>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/footer");?>
	<?php $this->load->view("admin_interface/includes/scripts");?>
</body>
</html>
