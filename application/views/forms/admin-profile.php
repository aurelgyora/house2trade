<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal border-bottom'));?>
	<fieldset>
		<div class="control-group">
			<label for="password">New password: </label>
			<input class="span4 valid-required FieldSend" id="login-password" name="password" <?=TOOLTIP_FIELD_BLANK;?> type="password">
		</div>
		<div class="control-group">
			<label for="confirm">Confirm password: </label>
			<input class="span4 valid-required FieldSend" id="confirm-password" name="confirm" <?=TOOLTIP_FIELD_BLANK;?> type="password">
		</div>
		<div class="clear"></div>
		<div class="form-actions">
			<button class="btn btn-success pull-right" id="save-profile" type="submit" name="submit" value="send">Save</button>
			<span id="block-message"></span>
		</div>
	</fieldset>
<?=form_close();?>