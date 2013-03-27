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
				<div id="div-view-account-broker">
					<legend>Account</legend>
					<div class="span4">
						<fieldset>
							<div class="control-group">
								First Name: <span id="fname"><?=$profile['info']['fname'];?></span>
							</div>
							<div class="control-group">
								Last Name: <span id="lname"><?=$profile['info']['lname'];?></span>
							</div>
						</fieldset>
					</div>
					<div class="span4">
						<fieldset>
							<div class="control-group">
								Phone: <span id="phone"><?=$profile['info']['phone'];?></span>
							</div>
							<div class="control-group">
								Cell: <span id="cell"><?=$profile['info']['cell'];?></span>
							</div>
						</fieldset>
					</div>
					<div class="clear"></div>
					<legend>Company</legend>
					<div class="span4">
						<fieldset>
							<div class="control-group">
								Company name: <span id="company"><?=$profile['info']['company'];?></span>
							</div>
							<div class="control-group">
								Company address: <span id="address"><?=$profile['info']['address'];?></span>
							</div>
							<div class="control-group">
								Company phone: <span id="cphone"><?=$profile['info']['cphone'];?></span>
							</div>
						</fieldset>
					</div>
					<div class="span4">
						<fieldset>
							<div class="control-group">
								Company email: <span id="cmail"><?=$profile['info']['cmail'];?></span>
							</div>
							<div class="control-group">
								Company website: <span id="website"><?=$profile['info']['website'];?></span>
							</div>
							<div class="control-group">
								Company license: <span id="license"><?=$profile['info']['license'];?></span>
							</div>
						</fieldset>
					</div>
					<div class="clear"></div>
					<div class="form-actions">
						<button class="btn btn-success" id="edit-profile">Edit information</button>
						<span id="block-message"></span>
					</div>
				</div>
				<div class="clear"></div>
				<div id="div-edit-account-broker" class="hidden">
					<?php $this->load->view('forms/edit-account-broker')?>
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->view("broker_interface/includes/scripts");?>
</body>
</html>
