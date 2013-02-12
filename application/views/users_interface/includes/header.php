<header>
	<div class="container_12">
		<a class="logo grid_4 none" href="#"><img src="<?=site_url('img/logo.png');?>" alt="House2Trade" /></a>
		<nav class="grid_8">
			<ul class="auth">
					<li><?=anchor('login','Log in')?></li>
					<li>&ndash; or &ndash;</li>
					<li><?=anchor('signup','Sign up')?></li>
				</ul>
			<ul class="main-nav">
				<li><?=anchor('','Home');?></li>
				<li><?=anchor('search','Search');?></li>
				<li><?=anchor('how-it-works','How It Works');?></li>
				<li><?=anchor('trading-concepts','Trading Concepts');?></li>
				<li><?=anchor('about-us','About Us');?></li>
				<li><?=anchor('contacts','Contacts');?></li>
			</ul>
		</nav>
		<div class="clear"></div>
	<?php if(uri_string() == ''):?>
		<div id="banner-slider" class="clearfix">
			<div class="slide">
				<h1 class="slogan">Sell more properties.</h1>
				<p class="h1-desc">
					House2Trade increases your profits by helping you to have more buyers and sell more properties.  
					The new advanced tools for Real Estate professionals will assist you at every step and help you to
					find the best proposals. Our patented engine will help you to find the best match.
				</p>
				<a href="<?=site_url('');?>" class="btn-submit">Sign up today. <span class="btn-comment">It's free.</span></a>
			</div>
		</div>
	<?php endif;?>
	</div>
</header>