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
						<a class="brand" href="<?=site_url(uri_string());?>">Email templates list</a>
					</div>
				</div>
				<div class="clear"></div>
				<?=$msgs;?>
				<table class="table table-hover">
					<thead>
						<tr>
							<th class="span1">#</th>
							<th class="span7">Subject</th>
							<th class="span1">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
				<?php for($i=0;$i<count($mails);$i++):?>
						<tr data-src="<?=$mails[$i]['id']?>">
							<td><?=$mails[$i]['id'];?></td>
							<td><?=$mails[$i]['subject'];?></td>
							<td>
								<a href="<?=site_url('administrator/control-panel/mails/edit/'.$mails[$i]['id']);?>" class="btn btn-mini set-operation" type="button">Edit</a>
							</td>
						</tr>
				<?php endfor;?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/scripts");?>
</body>
</html>
