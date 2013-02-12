<form action="/" class="form-signup" id="account-setup" method="post" onsubmit="$('register_button').disabled = true">
	<div class="grid_3">
		<p>
			<label>First Name</label>
			<input class="valid-required FieldSend" name="fname" <?=TOOLTIP_FIELD_BLANK;?> size="30" type="text">
		</p>
		<p>
			<label>Last Name</label>
			<input class="valid-required FieldSend" name="lname" <?=TOOLTIP_FIELD_BLANK;?> size="30" type="text">
		</p>
		<p>
			<label>Phone</label>
			<input class="valid-required FieldSend" name="phone" <?=TOOLTIP_FIELD_BLANK;?> size="30" type="text">
		</p>
		<p id="license_id">
			<label>License ID</label>
			<input class="valid-required FieldSend" name="license" <?=TOOLTIP_FIELD_BLANK;?> size="30" type="text">
		</p>
	</div>
	<div class="grid_3">
		<p>
			<label>Email</label>
			<input id="login-email" class="valid-required FieldSend" name="email" <?=TOOLTIP_FIELD_BLANK;?> size="30" type="text">
		</p>
		<p>
			<label>Password</label>
			<input id="login-password" class="valid-required FieldSend" name="password" <?=TOOLTIP_FIELD_BLANK;?> size="30" type="password">
		</p>
		<p>
			<label>Type password again</label>
			<input id="login-password-confirm" class="valid-required FieldSend" name="confirm" <?=TOOLTIP_FIELD_BLANK;?> size="30" type="password">
		</p>
		
	</div>
	<div class="clear"></div>
	<div class="grid_7">
		<p class="register-check">
			<span class="checky">
				<input id="user-terms-of-service" class="FieldSend" name="termsofservice]" autocomplete="off" type="checkbox" value="1">
			</span>
			I agree to the <a href="<?=site_url();?>" class="link-more" target="_blank">Terms of Service</a> 
			and the <a href="<?=site_url();?>" class="link-more" target="_blank">Privacy Policy</a>.
		</p>
		<p class="register-check">
			<span class="checky">
				<input checked="checked" class="FieldSend" id="user-subcribe" name="subcribe" autocomplete="off" type="checkbox" value="1">
			</span>
			Add me to the House2Trade mailing list to receive announcements.
		</p>
		<div class="clear"></div>
		<p class="button-row">
			<input class="btn-submit pull-left" id="register-button" disabled="disabled" name="commit" type="submit" value="Submit Form">
			<span id="block-message"></span>
		</p>
	</div>
	<div class="clear"> </div>
</form>