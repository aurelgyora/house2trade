<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal')); ?>
	<legend>Get property info by via MLS ID</legend>
	<div class="span2">
		<fieldset>
			<div class="control-group">
				<label for="fname">MLS*: </label>
				<input class="span2 valid-required FieldSend" id="mls-parameter" name="mls" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
			<div class="control-group">
				<label for="email">ZIP code*: </label>
				<input class="span2 valid-required FieldSend" id="zipcode-parameter" name="zap_code" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
	<div class="form-actions">
		<button class="btn btn-success pull-right" type="submit" id="set-properties-data" name="submit" value="send">Get property info</button>
		<div class="span4">
			<a class="none pull-right muted" id="set-properties-manual-data" href="#">I want to add property info manually</a>
		</div>
		<span id="block-message"></span>
	</div>
<?= form_close(); ?>