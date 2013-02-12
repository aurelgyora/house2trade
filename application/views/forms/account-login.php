<form action="/" id="account-setup" method="post" onsubmit="$('register_button').disabled = true">
	<div class="grid_3">
		<p>
			<label>Email</label>
			<input class="valid-required FieldSend" id="login-email" data-trigger="focus" name="email" size="30" data-placement="right" role="tooltip" data-original-title="This field can not be blank" type="text">
		</p>
		<p>
			<label>Password</label>
			<input class="valid-required FieldSend" id="login-password" data-trigger="focus" name="password" size="30" data-placement="right" role="tooltip" data-original-title="This field can not be blank" type="password">
		</p>
	</div>
	<div class="clear"></div>
	<div class="grid_7">
		<p class="button-row">
			<input class="btn-submit" id="login_button" data-trigger="click" data-placement="right" role="tooltip" data-original-title="" name="commit" type="submit" value="Submit Form">
		</p>
	</div>
	<div class="clear"> </div>
</form>