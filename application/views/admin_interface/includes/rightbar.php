<div class="span3">
	<div class="well sidebar-nav">
		<ul class="nav nav-pills nav-stacked">
			<li class="nav-header">Sections</li>
			<li num="pages"><?=anchor(ADM_START_PAGE.'/pages','Pages content');?></li>
			<li num="accounts"><?=anchor('administrator/broker/accounts','Accounts');?></li>
			<li num="properties"><?=anchor('administrator/properties','Properties');?></li>
			<li num="companies"><?=anchor('administrator/companies','Companies');?></li>
			<li num="mails"><?=anchor('administrator/control-panel/mails','EMail templates');?></li>
			<li class="nav-header">Tools</li>
			<li num="control-panel"><?=anchor(ADM_START_PAGE,'Control Panel');?></li>
			<li num="profile"><?=anchor('administrator/profile','Profile');?></li>
			<li><?=anchor('/','Home Page');?></li>
			<li><?=anchor('logout','Logout');?></li>
		</ul>
	</div>
</div>