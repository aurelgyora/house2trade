<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view("admin_interface/includes/head");?>
</head>
<body>
	<?php $this->load->view("admin_interface/includes/header");?>
	<div class="container">
		<div class="row">
			<hr/>
			<?php $this->load->view("admin_interface/includes/rightbar");?>
			<div class="span9">

				<ul class="thumbnails">
	              <li class="span2">
	                <div class="thumbnail">
	                	<?=anchor(ADM_START_PAGE.'/pages','<img src="/dev/img/icon_edit.png">');?>
	                	<div class="caption">
	                    	<p><strong>Content management</strong></p>
	                    </div>
	                </div>
	              </li>
	              <li class="span2">
	                <div class="thumbnail">
	                  	<?=anchor('administrator/broker/accounts','<img src="/dev/img/icon_accounts.png">');?>
		                <div class="caption">
	                    	<p><strong>Accounts management</strong></p>
	                    </div>
	                </div>
	              </li>
	            </ul>

			</div>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/footer");?>
	<?php $this->load->view("admin_interface/includes/scripts");?>
</body>
</html>
