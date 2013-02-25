<?=form_open($this->uri->uri_string(),array('id'=>'form-metod-property-register')); ?>
	<legend>Get property info by MLS ID</legend>
	<div class="span2">
		<fieldset>
			<div class="control-group">
				<label for="fname">MLS *</label>
				<input class="span2 digital valid-required FieldSend" id="mls-parameter" name="mls" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
			<div class="control-group">
				<label for="zip_code">ZIP code *</label>
				<input class="span2 digital valid-required FieldSend" id="zipcode-parameter" name="zip_code" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
	<div class="form-actions">
		<button class="btn btn-success" type="submit" id="set-properties-data" name="submit" value="send">Get property info</button>
		<span class="decision">or</span>
		<a class="none link-more" id="set-properties-manual-data" href="#">Add property manually</a>
		<span id="metod-block-message"></span>
	</div>
<?= form_close(); ?>