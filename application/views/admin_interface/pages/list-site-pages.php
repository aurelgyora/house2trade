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
				<div class="navbar">
					<div class="navbar-inner">
						<a class="brand" href="<?=site_url(ADM_START_PAGE.'/pages');?>">Pages content</a>
						<ul class="nav pull-right">
							<li><a href="<?=site_url(ADM_START_PAGE.'/pages/home');?>">Home page</a></li>
							<li><a href="<?=site_url(ADM_START_PAGE.'/pages/about-us');?>">About Us</a></li>
							<li><a href="<?=site_url(ADM_START_PAGE.'/pages/contacts');?>">Contacts</a></li>
							<li><a href="<?=site_url(ADM_START_PAGE.'/pages/company');?>">Company</a></li>
						</ul>
					</div>
				</div>
				<div class="clear"></div>
				<div id="form-request"></div>
		<?php if($pages):?>
				<table class="table table-hover table-striped">
					<thead>
						<tr>
							<th class="span3">URL</th>
							<th class="span5">Title</th>
							<th class="span1">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
				<?php for($i=0;$i<count($pages);$i++):?>
						<tr>
							<td><?=$pages[$i]['url']?></td>
							<td><?=$pages[$i]['title']?></td>
							<td>
								<a href="<?=site_url(uri_string().'/'.$pages[$i]['url']);?>" class="btn set-operation" type="button">Edit</a>
							</td>
						</tr>
				<?php endfor;?>
					</tbody>
				</table>
			<?php endif;?>
			</div>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/footer");?>
	<?php $this->load->view("admin_interface/includes/scripts");?>
</body>
</html>
