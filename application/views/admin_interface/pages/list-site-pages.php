<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view("admin_interface/includes/head");?>
<link rel="stylesheet" href="<?=site_url('css/jgrowl.css');?>" />
</head>
<body>
	<?php $this->load->view("admin_interface/includes/header");?>
	<div class="container">
		<div class="row">
			<div class="span9">
				<div class="navbar">
					<div class="navbar-inner">
						<a class="brand" href="<?=site_url('administrator/control-panel/pages');?>">Pages content</a>
						<ul class="nav pull-right">
							<li><a href="<?=site_url('administrator/control-panel/pages/home');?>">Home page</a></li>
							<li><a href="<?=site_url('administrator/control-panel/pages/about-us');?>">About Us</a></li>
							<li><a href="<?=site_url('administrator/control-panel/pages/contacts');?>">Contacts</a></li>
							<li><a href="<?=site_url('administrator/control-panel/pages/company');?>">Company</a></li>
						</ul>
					</div>
				</div>
				<div class="clear"></div>
		<?php if($pages):?>
				<table class="table table-hover">
					<caption>Pages list</caption>
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
								<a href="<?=site_url(uri_string().'/'.$pages[$i]['url']);?>" class="btn btn-mini set-operation" type="button"><i class="icon-edit"></i></a>
							</td>
						</tr>
				<?php endfor;?>
					</tbody>
				</table>
			<?php endif;?>
			</div>
		<?php $this->load->view("admin_interface/includes/rightbar");?>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/scripts");?>
</body>
</html>
