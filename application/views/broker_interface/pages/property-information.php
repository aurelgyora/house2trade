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
						<?=anchor($this->session->userdata('backpath'),'Back');?>
					</div>
				</div>
				<?php $this->load->helper('text');?>
				<select id="input-select-property" class="span7" name="property">
				<?php for($i=0;$i<count($properties);$i++):?>
					<option value="<?=$properties[$i]['id'];?>" <?=($properties[$i]['id'] == $this->uri->segment(4))?'selected="selected"':'';?>>
						<?=$properties[$i]['fname'].' '.$properties[$i]['lname'].' '.$properties[$i]['address1'];?>
					</option>
				<?php endfor;?>
				</select>
				<div class="clear"></div>
				<hr/>
			<?php if($property):?>
				<div class="span4">
					<a class="none pull-left" href="#">
						<img class="span3 img-polaroid media-object" src="<?=site_url($property['photo']);?>" alt="">
					</a>
					<div class="clear"></div>
					<div class="span2">
						Price: <br/>Bedrooms: <br/>Bathrooms: <br/>Square:
					</div>
					<div class="span1">
						$<?=$property['price'];?><br/><?=$property['bathrooms'];?><br/><?=$property['bathrooms'];?><br/><?=$property['sqf'];?>
					</div>
				</div>
				<div class="span4">
					<h3>Property Description</h3>
					<div>
						<?=$property['description'];?>
					</div>
					<div class="clear"></div>
					<h3>Contact Information</h3>
					<div>
						<div class="span1">
							Phone: <br/>cell: <br/>Email:
						</div>
						<div class="span1">
							<?=$property['phone'];?><br/><?=$property['cell'];?><br/><?=$property['email'];?>
						</div>
					</div>
				</div>
				<div class="clear"></div>
				<hr/>
				<div>
					<a href="<?=site_url(BROKER_START_PAGE.'/edit/'.$property['id']);?>" class="btn btn-link btn-mini" type="button">Edit property</a>
					<a class="btn btn-mini btn-link link-operation-account" href="#confirm-user" data-toggle="modal" data-src="<?=$property['id'];?>" data-url="<?=site_url(BROKER_START_PAGE.'/delete');?>">Delete property</a>
					<button class="btn btn-info pull-right btn-mini disabled" disabled="disabled" id="btn-remote-to-favirite">Remove to Favorite</button>
					<button class="btn btn-info btn-mini pull-right" id="btn-add-to-potential-buy">Add to Potential Buy</button>
				</div>
			<?php endif;?>
			</div>
		</div>
		<?php $this->load->view("modal/confirm-user");?>
	</div>
	<?php $this->load->view("broker_interface/includes/scripts");?>
</body>
</html>
