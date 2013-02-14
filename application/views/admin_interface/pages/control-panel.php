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
							<?=anchor('administrator/control-panel/pages','<img src="'.site_url('img/thumb.png').'" alt="" />',array('class'=>'thumbnail'));?>
							<h6>Section &laquo;Pages&raquo;</h6>
						</div>
					</li>
					
				</ul>
				<div class="clear"></div>
				<ul class="thumbnails">
					<li class="span2">
						<div class="thumbnail">
							<?=anchor('administrator/control-panel/accounts','<img src="'.site_url('img/thumb.png').'" alt="" />',array('class'=>'thumbnail'));?>
							<h6>Section &laquo;Accounts&raquo;</h6>
						</div>
					</li>
					
					<div class="clear"></div>
				</ul>
			</div>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/scripts");?>
</body>
</html>
