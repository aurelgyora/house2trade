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
						<a href="<?=site_url('broker/register-properties');?>" class="btn btn-link btn-small pull-right" type="button">Add new Property</a>
					</div>
				</div>
				<div class="clear"></div>
				<?php $this->load->helper('text');?>
			<?php for($i=0;$i<count($properties);$i++):?>
				<div class="media">
					<a class="none pull-left" href="#">
						<img class="span2 img-polaroid media-object" src="<?=site_url($properties[$i]['photo']);?>" alt="">
					</a>
					<div class="media-body">
						<a href="<?=site_url(BROKER_START_PAGE.'/edit/'.$properties[$i]['id']);?>" class="btn btn-mini pull-right" type="button"><i class="icon-edit"></i> Edit property</a>
						<h4 class="media-heading"><?=$properties[$i]['address1'];?></h4>
						<p><em><?=word_limiter($properties[$i]['description'],50);?></em></p>
						<p>
							<?=$properties[$i]['city'].', '.$properties[$i]['state'].', '.$properties[$i]['type'];?><br/>
							Bathrooms: <?=$properties[$i]['bathrooms'];?>; Bedrooms: <?=$properties[$i]['bathrooms'];?>; Square: <?=$properties[$i]['sqf'];?>;
							Tax: <?=$properties[$i]['tax'];?>; Price: <?=$properties[$i]['price'];?>;
						</p>
					</div>
				</div>
			<?php endfor;?>
			</div>
		</div>
	</div>
	<?php $this->load->view("broker_interface/includes/scripts");?>
</body>
</html>
