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
		<?php if(!$this->session->userdata('current_property') || !$match):?>
				<p>Match is missing or is not selected current seller</p>
		<?php else:?>
			<div id="form-request"></div>
		<?php if($match['status'] == 0 && $match[$match['my_status_field']] == 0):?>
			<div class="div-match-operation">
				<button class="btn btn-mini btn-link btn-approved-match" data-match-id="<?=$match['id'];?>">Approve this match</button>
				<button class="btn btn-mini btn-link btn-break-match" data-match-id="<?=$match['id'];?>">Break this match</button>
				<div class="input-append">
					<span class="add-on">%</span>
					<input class="input-mini valid-numeric valid-max-value" data-max-value="100" id="down-payment-value" placeholder="Down Payment" type="text">
					<button class="btn btn-change-down-payment" data-match="<?=$match['id']?>" type="button">SAVE</button>
				</div>
			</div>
		<?php elseif($match['status'] == 0 && $match[$match['my_status_field']] == 1):?>
			<div class="alert alert-info">
				You have approved the match!
				<!--<a href="<?=site_url('broker/match?action=cancel&match='.$match['id'].'&field='.$match['my_status_field']);?>">Click to restore</a>-->
			</div>
		<?php else:?>
			<div class="alert alert-info">
				The match cycle is approved by all participants!
				<!--<a href="<?=site_url('broker/match?action=cancel&match='.$match['id'].'&field='.$match['my_status_field']);?>">Click to restore</a>-->
			</div>
		<?php endif;?>
			<?php array_push($properties,$properties[0]);?>
			<?php for($i=0,$matchIndex=$match['level'];$i<count($properties);$i++,$matchIndex--):?>
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
						<?php if($properties[$i]['id'] == $this->session->userdata('current_property')):?>
							<p>This is your property</p>
						<?php endif;?>
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
					<?php if($match['status'.$matchIndex] == 1):?>
						<p class="text-success">Approve</p>
					<?php else:?>
						<p class="text-info">Not approve</p>
					<?php endif?>
				<?php endif;?>
			<?php endfor;?>
		<?php endif;?>
			</div>
		</div>
	</div>
	<?php $this->load->view("owner_interface/includes/footer");?>
	<?php $this->load->view("owner_interface/includes/scripts");?>
</body>
</html>
