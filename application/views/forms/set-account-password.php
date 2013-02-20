<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal')); ?>
	<input class="FieldSend" name="setpswd" value="1" type="hidden" />
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="password">Your password: </label>
				<input class="span4 valid-required FieldSend" id="login-password" name="password" <?=TOOLTIP_FIELD_BLANK;?> type="password">
			</div>
			<div class="control-group">
				<label for="confirm">Confirm password: </label>
				<input class="span4 valid-required FieldSend" id="confirm-password" name="confirm" <?=TOOLTIP_FIELD_BLANK;?> type="password">
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
	<div class="form-actions">
		<button class="btn btn-success pull-right" id="set-password" type="submit" name="submit" value="send">Set password</button>
		<span id="block-message"></span>
	</div>
<?= form_close(); ?>