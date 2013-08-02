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
			<?php if($this->session->userdata('current_property') === FALSE || $this->owner['seller'] || count($select) > 1):?>
				<div class="navbar">
					<?php $this->load->view("owner_interface/forms/select-property");?>
				<?php if($this->uri->segment(2) == 'properties' && $this->owner['seller']):?>
					<a href="<?=site_url('homeowner/register-properties');?>" class="btn btn-small btn-link" type="button">Add new Property</a>
				<?php endif;?>
				</div>
				<div class="clear"></div>
			<?php endif;?>
				<?php $this->load->helper('text');?>
			<?php for($i=0;$i<count($properties);$i++):?>
				<div class="media">
					<a class="pull-left" href="<?=site_url('homeowner/'.$this->uri->segment(2).'/information/'.$properties[$i]['id']);?>">
						<img class="img-polaroid media-object" src="<?=site_url($properties[$i]['photo']);?>" alt="">
					</a>
					<div class="media-body">
						<h4 class="media-heading">
							<a href="<?=site_url('homeowner/'.$this->uri->segment(2).'/information/'.$properties[$i]['id']);?>">
								<small>HT-<?=$properties[$i]['id'];?></small> <?=$properties[$i]['address1'];?>
							</a>
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
						<?=getPropertyStatus($properties[$i]['id'],$properties[$i]['status'],$this->profile['group']);?>
					</div>
				</div>
			<?php endfor;?>
			<?=$pagination;?>
			</div>
		</div>
	</div>
	<?php $this->load->view("owner_interface/includes/footer");?>
	<?php $this->load->view("owner_interface/includes/scripts");?>
</body>
</html>