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
					<div class="navbar-inner">Search properties</div>
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
				<?php for($i=0;$i<count($properties);$i++):?>
					<div class="media">
						<a class="none pull-left" href="#">
							<img class="span2 img-polaroid media-object" src="<?=site_url($properties[$i]['photo']);?>" alt="">
						</a>
						<div class="media-body">
							<h4 class="media-heading">
								<a href="<?=site_url(BROKER_START_PAGE.'/information/'.$properties[$i]['id']);?>"><?=$properties[$i]['address1'];?></a>
							</h4>
							<p><em><?=word_limiter($properties[$i]['description'],50);?></em></p>
							<p>
								<?=$properties[$i]['city'].', '.$properties[$i]['state'].', '.$properties[$i]['type'];?><br/>
								Bathrooms: <?=$properties[$i]['bathrooms'];?>, Bedrooms: <?=$properties[$i]['bathrooms'];?>, Square: <?=$properties[$i]['sqf'];?>,
								Tax: <?=$properties[$i]['tax'];?>, Price: <?=$properties[$i]['price'];?>.
							</p>
						</div>
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
