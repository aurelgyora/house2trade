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
								Company name: <span id="company"><?=(!empty($profile['company']))?$profile['company']:'The company is not listed';?></span>
							</div>
						</fieldset>
					</div>
					<div class="clear"></div>
					<div class="form-actions">
						<div class="form-request"></div>
						<button class="btn btn-success" id="edit-profile">Edit profile</button>
					</div>
				</div>
				<div class="clear"></div>
				<div id="div-edit-account-broker" class="hidden">
					<?php $this->load->view('broker_interface/forms/edit-account')?>
				</div>
			</div>
		</div>
	</div>
	<?php $this->load->view("broker_interface/includes/footer");?>
	<?php $this->load->view("broker_interface/includes/scripts");?>
</body>
</html>
