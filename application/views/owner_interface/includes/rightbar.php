<div class="span3">
	<div class="well sidebar-nav">
		<ul class="nav nav-pills nav-stacked">
			<li class="nav-header">Navigation</li>
			<li data-active="search"><?=anchor('homeowner/search','Search');?></li>
			<li data-active="profile"><?=anchor('homeowner/profile','My account');?></li>
			<li data-active="properties"><?=anchor(OWNER_START_PAGE,'Properties');?></li>
			<li data-active="recommended"><?=anchor('homeowner/recommended','Recommended');?></li>
			<li data-active="favorite"><?=anchor('homeowner/favorite','Worth seeing');?></li>
			<li data-active="potential-by"><?=anchor('homeowner/potential-by','Potential buy');?></li>
			<li data-active="instant-trade"><?=anchor('homeowner/instant-trade','Instant Match');?></li>
			<li data-active="match"><?=anchor('homeowner/match','Match');?></li>
			<li class="nav-header">Actions</li>
			<li><?=anchor('/','Home Page');?></li>
			<li><?=anchor('logout','Logout');?></li>
		</ul>
	</div>
</div>