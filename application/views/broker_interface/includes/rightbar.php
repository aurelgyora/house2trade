<div class="span3">
	<div class="well sidebar-nav">
		<ul class="nav nav-pills nav-stacked">
			<li class="nav-header">Navigation</li>
			<li num="search"><?=anchor('broker/search','Search');?></li> 
			<li num="profile"><?=anchor('broker/profile','My account');?></li>
			<li num="properties"><?=anchor(BROKER_START_PAGE,'Properties');?></li>
		<?php if($this->session->userdata('current_owner')):?>
			<li num="favorite"><?=anchor('broker/favorite','Favorite');?></li>
			<li num="potential-by"><?=anchor('broker/potential-by','Potential by');?></li>
		<?php endif;?>
			<!--
			<li num="instant-trade"><?=anchor('broker/instant-trade','Instant Trade');?></li>
			<li num="match"><?=anchor('broker/match','Match');?></li>
			-->
			<li class="nav-header">Actions</li>
			<li><?=anchor('logout','Logout');?></li>
		</ul>
	</div>
</div>