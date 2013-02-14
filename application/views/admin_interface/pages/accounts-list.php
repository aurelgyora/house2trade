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
						<a class="brand" href="<?=site_url('administrator/'.$this->uri->segment(2).'/accounts');?>">Accounts</a>
						<ul class="nav pull-right">
							<li<?=($this->uri->segment(2) == 'broker')?' class="active"':''?>><a href="<?=site_url('administrator/broker/accounts');?>">Brokers</a></li>
							<li<?=($this->uri->segment(2) == 'homeowner')?' class="active"':''?>><a href="<?=site_url('administrator/homeowner/accounts');?>">HomeOwners</a></li>
						</ul>
					</div>
				</div>
				<div class="clear"></div>
		<?php if($users):?>
				<table class="table table-hover">
					<thead>
						<tr>
							<th class="span1">№</th>
							<th class="span2">Name</th>
							<th class="span2">Email</th>
							<th class="span2">Status</th>
							<th class="span2">SignUp date</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
					<?php $this->load->helper('date');?>
					<?php $this->load->helper('text');?>
				<?php for($i=0;$i<count($users);$i++):?>
						<tr data-account="<?=$users[$i]['uid']?>">
							<td><?=$this->uri->segment(5)+$i+1;?></td>
							<td><?=$users[$i]['fname'].' '.$users[$i]['lname']?></td>
							<td><?=$users[$i]['email']?></td>
							<td><?=getStatus($users[$i]['status']);?></td>
							<td><?=swap_dot_date_without_time($users[$i]['signdate']);?></td>
							<td>
								<a href="<?=site_url('administrator/account/'.$users[$i]['uid']);?>" class="btn btn-mini set-operation" type="button"><i class="icon-user"></i></a>
							</td>
						</tr>
				<?php endfor;?>
					</tbody>
				</table>
			<?php endif;?>
				<?=$pages;?>
			</div>
		</div>
	</div>
	<?php $this->load->view("admin_interface/includes/scripts");?>
</body>
</html>
