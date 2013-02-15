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
				<div class="pull-right muted">
					<a href="<?=site_url('broker/register-properties');?>" class="btn btn-mini set-operation" type="button">Add HomeOwner</a>
				</div>
			<?php if($properties):?>
				<table class="table table-hover">
					<thead>
						<tr>
							<th class="span1">ID</th>
							<th class="span3">Name</th>
							<th class="span3">address1</th>
							<th class="span1"></th>
						</tr>
					</thead>
					<tbody>
				<?php for($i=0;$i<count($properties);$i++):?>
					<tr>
						<td><?=$properties[$i]['id']?></td>
						<td><?=$properties[$i]['fname'].' '.$properties[$i]['lname']?></td>
						<td><?=$properties[$i]['address1']?></td>
						<td>
							<a href="<?=site_url(uri_string());?>" class="btn btn-mini set-operation" type="button"><i class="icon-edit"></i></a>
						</td>
					</tr>
				<?php endfor;?>
					</tbody>
				</table>
			<?php endif;?>
			</div>
		</div>
	</div>
	<?php $this->load->view("broker_interface/includes/scripts");?>
</body>
</html>
