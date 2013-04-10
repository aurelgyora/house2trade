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
			<hr/>
			<?php $this->load->view("admin_interface/includes/rightbar");?>
			<div class="span9">
				<div class="navbar">
					<div class="navbar-inner">
						<a class="brand" href="<?=site_url(uri_string());?>">Company</a>
					</div>
				</div>
				<a class="btn btn-primary" href="<?=site_url('administrator/companies/insert');?>">Insert Company</a>
				<div class="clear"></div>
			<?php if($company):?>
				<table class="table table-hover">
					<thead>
						<tr>
							<th class="span1">#</th>
							<th class="span1">Logo</th>
							<th class="span3">Name zip_code</th>
							<th class="span3">Address</th>
							<th class="span2">Contacts</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					<?php $this->load->helper('date');?>
					<?php $this->load->helper('text');?>
				<?php for($i=0;$i<count($company);$i++):?>
						<tr data-account="<?=$company[$i]['id']?>">
							<td><?=$this->uri->segment(5)+$i+1;?></td>
							<td><img src="<?=site_url('loadimage/logo/'.$company[$i]['id']);?>" width="86" alt="" /></td>
							<td><?=$company[$i]['title'].' '.$company[$i]['zip_code'];?></td>
							<td><?=$company[$i]['state'].' '.$company[$i]['city'].' '.$company[$i]['address1'];?></td>
							<td><?=$company[$i]['email'].' '.$company[$i]['phone'].' '.$company[$i]['website'];?></td>
							<td>
								<a href="<?=site_url('administrator/companies/edit/'.$company[$i]['id']);?>" class="btn btn-mini set-operation" type="button">Edit</a>
								<a href="<?=site_url('administrator/companies/delete/'.$company[$i]['id']);?>" class="btn btn-mini btn-danger" type="button">Delete</a>
							</td>
						</tr>
				<?php endfor;?>
					</tbody>
				</table>
				<?=$pages;?>
			<?php else:?>
				<h3>List is empty</h3>
			<?php endif;?>
			</div>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/footer");?>
	<?php $this->load->view("admin_interface/includes/scripts");?>
</body>
</html>
