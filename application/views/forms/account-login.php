<form action="/" id="account-setup" method="post" onsubmit="$('register_button').disabled = true">
	<div class="grid_3">
		<p>
			<label>Email</label>
			<input class="valid-required FieldSend" id="login-email" name="email" size="30" <?=TOOLTIP_FIELD_BLANK;?> type="text">
		</p>
		<p>
			<label>Password</label>
			<input class="valid-required FieldSend" id="login-password" name="password" size="30" <?=TOOLTIP_FIELD_BLANK;?> type="password">
		</p>
	</div>
	<div class="clear"></div>
	<div id="block-message" class="grid_2"></div>
	<div class="grid_7">
		<p class="button-row">
			<input class="btn-submit" id="login-button" name="commit" type="submit" value="Submit Form">
			<a href="<?=site_url('password-recovery')?>" class="">forgot password?</a>
		</p>
	</div>
	<div class="clear"> </div>
</form>