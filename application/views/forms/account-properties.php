<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal')); ?>
	<legend>HomeOwner data</legend>
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="fname">First Name*: </label>
				<input class="span4 valid-required FieldSend" name="fname" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
			<div class="control-group">
				<label for="lname">Last Name*: </label>
				<input class="span4 valid-required FieldSend" name="lname" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
			<div class="control-group">
				<label for="email">Email*: </label>
				<input class="span4 valid-required FieldSend" id="login-email" name="email" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
	<legend>Property data</legend>
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="city">City*: </label>
				<input class="span4 valid-required FieldSend" name="city" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
			<div class="control-group">
				<label for="state">State*: </label>
				<input class="span4 valid-required FieldSend" name="state" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
			<div class="control-group">
				<label for="address1">Address 1*: </label>
				<textarea class="span4 FieldSend" rows="1" name="address1" <?=TOOLTIP_FIELD_BLANK;?>></textarea>
			</div>
			<div class="control-group">
				<label for="address2">Address 2: </label>
				<textarea class="span4 FieldSend" rows="1" name="address2" <?=TOOLTIP_FIELD_BLANK;?>></textarea>
			</div>
			<div class="control-group">
				<label for="type">Type*: </label>
				<input class="span2 valid-required FieldSend" name="type" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
			<div class="control-group">
				<label for="zip_code">Zip code*: </label>
				<input class="span2 digital valid-required FieldSend" name="zip_code" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
			<div class="control-group">
				<label for="bathrooms">Bathrooms*: </label>
				<input class="span2 digital valid-required FieldSend" name="bathrooms" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
			<div class="control-group">
				<label for="bedrooms">Bedrooms*: </label>
				<input class="span2 digital valid-required FieldSend" name="bedrooms" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
			<div class="control-group">
				<label for="sqf">Square Feed*: </label>
				<input class="span2 valid-required FieldSend" name="sqf" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
			<div class="control-group">
				<label for="price">Price*: </label>
				<input class="span2 numeric-float valid-required FieldSend" name="price" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
			<div class="control-group">
				<label for="tax">Tax: </label>
				<input class="span2 digital FieldSend" name="tax" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
			<div class="control-group">
				<label for="mls">MLS*: </label>
				<input class="span2 digital valid-required FieldSend" name="mls" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
			<div class="control-group">
				<label for="description">Description*: </label>
				<textarea class="span8 valid-required FieldSend" rows="2" name="description" <?=TOOLTIP_FIELD_BLANK;?>></textarea>
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
	<div class="form-actions">
		<button class="btn btn-success pull-right" type="submit" id="register-properties" name="submit" value="send">Register property info</button>
		<div class="span4">
			<a class="none pull-right muted" id="set-properties-auto-data" href="#">I want to add property info by via MLS ID</a>
		</div>
		<span id="block-message"></span>
	</div>
<?= form_close(); ?>