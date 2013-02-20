<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal','id'=>'form-edit-property-info')); ?>
	<legend>Account data</legend>
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="fname">First Name*: </label>
				<input class="span4 valid-required FieldSend" name="fname" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$owner['fname'];?>">
			</div>
			<div class="control-group">
				<label for="lname">Last Name*: </label>
				<input class="span4 valid-required FieldSend" name="lname" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$owner['lname'];?>">
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
	<legend>Change password</legend>
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="password">New password: </label>
				<input class="span4 FieldSend" id="login-password" name="password" <?=TOOLTIP_FIELD_BLANK;?> type="password">
			</div>
			<div class="control-group">
				<label for="confirm">Comfirm password: </label>
				<input class="span4 FieldSend" id="comfirm-password" name="confirm" <?=TOOLTIP_FIELD_BLANK;?> type="password">
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
	<div class="span9 hidden">
		<p class="register-check">
			<span class="checky">
				<input id="subcribe" name="subcribe" type="checkbox" value="0">
			</span>
			Add me to the House2Trade mailing list to receive announcements.
		</p>
	</div>
	<div class="clear"></div>
	<div class="form-actions">
		<button class="btn btn-success pull-right" id="save-profile" type="submit" name="submit" value="send">Save profile</button>
		<span class="pull-right" id="block-message"></span>
	</div>
<?= form_close(); ?>