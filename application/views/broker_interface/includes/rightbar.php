<div class="span3">
	<div class="well sidebar-nav">
		<ul class="nav nav-pills nav-stacked">
			<li class="nav-header">Navigation</li>
			<li data-active="search"><?=anchor('broker/search','Search');?></li>
			<li data-active="profile"><?=anchor('broker/profile','My account');?></li>
			<li data-active="properties"><?=anchor(BROKER_START_PAGE,'Properties');?></li>
			<li data-active="recommended"><?=anchor('broker/recommended','Recommended');?></li>
			<li data-active="favorite"><?=anchor('broker/favorite','Worth seeing ');?></li>
			<li data-active="potential-by"><?=anchor('broker/potential-by','Potential buy');?></li>
			<li data-active="instant-trade"><?=anchor('broker/instant-trade','Instant Match');?></li>
			<li data-active="match"><?=anchor('broker/match','Match');?></li>
			<li class="nav-header">Actions</li>
			<li><?=anchor('/','Home Page');?></li>
			<li><?=anchor('logout','Logout');?></li>
		</ul>
	</div>
</div>