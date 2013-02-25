<form action="/" class="form-signup" id="account-setup" method="post" onsubmit="$('register_button').disabled = true">
	<input type="hidden" class="FieldSend" name="class" id="signup-class" autocomplete="off" value="2">
	<div class="grid_6">
		<div class="btn-group" data-toggle="buttons-radio">
			<button type="button" id="account-broker-setup" data-class="2" class="btn change-signup-class active">Register as Broker</button>
			<button type="button" id="account-homeowner-setup" data-class="3" class="btn change-signup-class">Register as HomeOwner</button>
		</div>
	</div>
	<div class="clear"> </div>
	<div class="grid_3">
		<p>
			<label>First Name *</label>
			<input class="valid-required FieldSend" name="fname" <?=TOOLTIP_FIELD_BLANK;?> size="30" type="text">
		</p>
		<p>
			<label>Last Name *</label>
			<input class="valid-required FieldSend" name="lname" <?=TOOLTIP_FIELD_BLANK;?> size="30" type="text">
		</p>
		<p data-class="broker">
			<label>Company name *</label>
			<input class="FieldSend" name="company" <?=TOOLTIP_FIELD_BLANK;?> size="30" type="text">
		</p>
	</div>
	<div class="grid_3">
		<p>
			<label>Email *</label>
			<input id="login-email" class="valid-required FieldSend" name="email" <?=TOOLTIP_FIELD_BLANK;?> size="30" type="text">
		</p>
		<p>
			<label>Phone *</label>
			<input class="valid-required FieldSend" name="phone" <?=TOOLTIP_FIELD_BLANK;?> size="30" type="text">
		</p>
		<p id="license_id" data-class="broker">
			<label>License ID</label>
			<input class="FieldSend" name="license"<?=TOOLTIP_FIELD_BLANK;?> size="30" type="text">
		</p>
	</div>
	<div class="clear"></div>
	<div class="grid_7">
		<p data-class="homeowner">
			<input type="hidden" name="seller" id="seller" autocomplete="off" value="1">
			<label>Are you planning to sell your property and buy another one?</label>
			<input type="radio" name="rd" class="rd-seller" checked="checked" autocomplete="off" value="1"> YES
			<input type="radio" name="rd" class="rd-seller" autocomplete="off" value="0"> NO
		</p>
		<p class="register-check">
			<span class="checky">
				<input id="user-terms-of-service" class="FieldSend" name="termsofservice" autocomplete="off" type="checkbox" value="1">
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
			<span id="register-cancel">
				<span class="decision">or</span>
				<a href="#" class="link-more" hidefocus="true">Cancel registration</a>
			</span>
			<span id="block-message"></span>
		</p>
	</div>
	<div class="clear"></div>
</form>