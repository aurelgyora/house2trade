<?=form_open($this->uri->uri_string(),array('id'=>'form-metod-property-register')); ?>
	<legend>Get information about your property</legend>
	<div class="span2">
		<fieldset>
			<div class="control-group">
				<label for="address">Address *</label>
				<input class="span2 valid-required FieldSend" id="address-parameter" name="address" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
			<div class="control-group">
				<label for="zip_code">City, State, Zip code *</label>
				<input class="span2 digital valid-required FieldSend" id="zipcode-parameter" name="zip_code" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
	<div class="form-actions">
		<span id="metod-block-message"></span>
		<span class="wait-request hidden"><img src="<?=site_url('img/loading.gif');?>" alt="" /></span>
		<button class="btn btn-success" type="submit" id="set-properties-data" name="submit" value="send">Get property info</button>
		<span class="decision">or</span>
		<a class="none link-more" id="set-properties-manual-data" href="#">Add property manually</a>
	</div>
<?= form_close(); ?>