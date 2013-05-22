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
				<?php $this->load->view("broker_interface/forms/setect-property");?>
				</div>
				<div class="clear"></div>
		<?php if(!$this->session->userdata('current_property') || !$match):?>
				<p>Match is missing or is not selected current seller</p>
		<?php else:?>
			<div id="form-request"></div>
			<div class="div-match-operation">
				<button class="btn btn-mini btn-link btn-appoved-match" data-match-id="<?=$match['id'];?>">Approved this match</button>
				<button class="btn btn-mini btn-link btn-break-match" data-match-id="<?=$match['id'];?>">Break this match</button>
				<div class="input-append">
					<span class="add-on">%</span>
					<input class="input-mini valid-numeric valid-max-value" data-max-value="100" id="down-payment-value" placeholder="Down Payment" type="text">
					<button class="btn btn-change-down-payment" data-match="<?=$match['id']?>" type="button">SAVE</button>
				</div>
			</div>
			<?php array_push($properties,$properties[0]);?>
			<?php for($i=0;$i<count($properties);$i++):?>
				<div class="media">
					<a class="none pull-left" href="#">
						<img class="img-polaroid media-object" src="<?=site_url($properties[$i]['photo']);?>" alt="">
					</a>
					<div class="media-body">
						<h4 class="media-heading">
							<a href="<?=site_url('broker/'.$this->uri->segment(2).'/information/'.$properties[$i]['id']);?>"><?=$properties[$i]['address1'];?></a>
							<span><?=$properties[$i]['city'].', '.$properties[$i]['state'].' '.$properties[$i]['zip_code']; ?></span>
						</h4>
						<p>
							$<?=$properties[$i]['price'];?> <span class="separator">|</span> 
							<?=$properties[$i]['bedrooms'];?> Bd <span class="separator">|</span> 
							<?=$properties[$i]['bathrooms'];?> Ba <span class="separator">|</span> 
							<?=$properties[$i]['sqf'];?> Sq Ft <span class="separator">|</span> 
							<?=$properties[$i]['lotsize'];?> Acres <br/>
							<?= ucfirst($properties[$i]['type']); ?> Home <br/>
						</p>
					</div>
				</div>
				<?php if(($i+1) < count($properties)):?>
					<img src="<?=site_url('img/ArrowDown.png');?>" alt="" />
					Down Payment: 
					<?php if($properties[$i]['down_payment']['my_value'] == 1):?>
						<span id="my-down-payment-value"><?=$properties[$i]['down_payment']['value']; ?></span> 
					<?php else:?>
						<?=$properties[$i]['down_payment']['value']; ?>
					<?php endif?>
					%
				<?php endif;?>
			<?php endfor;?>
		<?php endif;?>
			</div>
		</div>
	</div>
	<?php $this->load->view("broker_interface/includes/footer");?>
	<?php $this->load->view("broker_interface/includes/scripts");?>
</body>
</html>
