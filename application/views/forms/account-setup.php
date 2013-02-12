<form action="/" id="account-setup" method="post" onsubmit="$('register_button').disabled = true">
	<input id="community_id" name="community_id" type="hidden" value="372">
	<input id="user_username" name="user[username]" type="hidden" value="graphememan">
	<input id="user_identity_url" name="user[identity_url]" type="hidden">
	<div class="grid_3">
		<p>
			<label>First Name</label>
			<input id="user_first_name" name="user[first_name]" size="30" type="text">
		</p>
		<p>
			<label>Last Name</label>
			<input id="user_last_name" name="user[last_name]" size="30" type="text">
		</p>
		<p>
			<label>Phone</label>
			<input id="user_phone" name="user[phone]" size="30" type="text">
		</p>
		<p id="zipcode" style="">
			<label>Zip Code</label>
			<input id="user_zipcode" name="user[zipcode]" size="30" type="text">
		</p>
	</div>
	<div class="grid_3">
		<p>
			<label>Email</label>
			<input id="user_email" name="user[email]" size="30" type="text">
		</p>
		<p>
			<label>Password</label>
			<input id="user_password" name="user[password]" size="30" type="password">
		</p>
		<p>
			<label>Type password again</label>
			<input id="user_password_confirmation" name="user[password_confirmation]" size="30" type="password">
		</p>
		<p id="license_id" style="">
			<label>License ID</label>
			<input id="user_license_id" name="user[license_id]" size="30" type="text">
		</p>
	</div>
	<div class="clear"> </div>
	<div class="grid_7">
		<p class="register-check">
			<span class="checky">
				<input name="user[terms_of_service]" type="hidden" value="0">
				<input id="user_terms_of_service" name="user[terms_of_service]" type="checkbox" value="1">
			</span>
			I agree to the <a href="#" class="link-more" target="_blank">Terms of Service</a> 
			and the <a href="#" class="link-more" target="_blank">Privacy Policy</a>.
		</p>
		<p class="register-check">
			<span class="checky">
				<input name="user[on_mailing_list]" type="hidden" value="0">
				<input checked="checked" id="user_on_mailing_list" name="user[on_mailing_list]" type="checkbox" value="1">
			</span>
			Add me to the House2Trade mailing list to receive announcements.
		</p>
		<p class="button-row">
			<input class="btn-submit" id="register_button" name="commit" type="submit" value="Submit Form">
		</p>
	</div>
	<div class="clear"> </div>
</form>