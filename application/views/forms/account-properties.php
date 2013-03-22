<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal','id'=>'form-property-register')); ?>
	<legend>HomeOwner data</legend>
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="fname">First Name*: </label>
				<input class="span4 valid-required FieldSend" name="fname" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="Vladimir">
			</div>
			<div class="control-group">
				<label for="lname">Last Name*: </label>
				<input class="span4 valid-required FieldSend" name="lname" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="Kharseev">
			</div>
			<div class="control-group">
				<label for="email">Email*: </label>
				<input class="span4 valid-required unique-email FieldSend" id="login-email" name="email" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="owner@house2trade.us">
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
	<legend>Property data</legend>
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="city">City*: </label>
				<input class="span4 valid-required FieldSend" name="city" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="Rostov-on-Don">
			</div>
			<div class="control-group">
				<label for="state">State*: </label>
				<input class="span4 valid-required FieldSend" name="state" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="Lenin's">
			</div>
			<div class="control-group">
				<label for="address1">Address 1*: </label>
				<textarea class="span4 FieldSend" rows="1" name="address1" <?=TOOLTIP_FIELD_BLANK;?>>Rostov-on-Don</textarea>
			</div>
			<div class="control-group">
				<label for="address2">Address 2: </label>
				<textarea class="span4 FieldSend" rows="1" name="address2" <?=TOOLTIP_FIELD_BLANK;?>>Rostov-on-Don</textarea>
			</div>
			<div class="control-group">
				<label for="type">Type*: </label>
				<input class="span2 valid-required FieldSend" name="type" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="Living">
			</div>
			<div class="control-group">
				<label for="zip_code">Zip code*: </label>
				<input id="property-zipcode" class="span2 digital valid-required FieldSend" name="zip_code" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="9846980">
			</div>
			<div class="control-group">
				<label for="bathrooms">Bathrooms*: </label>
				<input id="property-bathrooms" class="span2 digital valid-required FieldSend" name="bathrooms" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="2">
			</div>
			<div class="control-group">
				<label for="bedrooms">Bedrooms*: </label>
				<input id="property-bedrooms" class="span2 digital valid-required FieldSend" name="bedrooms" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="1">
			</div>
			<div class="control-group">
				<label for="sqf">Square Feed*: </label>
				<input class="span2 valid-required FieldSend" name="sqf" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="250">
			</div>
			<div class="control-group">
				<label for="price">Price*: </label>
				<input id="property-price" class="span2 numeric-float valid-required FieldSend" name="price" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="10000.00">
			</div>
			<div class="control-group">
				<label for="tax">Tax: </label>
				<input id="property-tax" class="span2 digital FieldSend" name="tax" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="123456">
			</div>
			<div class="control-group">
				<label for="mls">MLS*: </label>
				<input id="property-mls" class="span2 digital valid-required FieldSend" name="mls" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="90898763">
			</div>
			<div class="control-group">
				<label for="description">Description*: </label>
				<textarea class="span8 valid-required FieldSend" rows="2" name="description" <?=TOOLTIP_FIELD_BLANK;?>>sascsacsa asdasds</textarea>
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
	<div class="form-actions">
		<div id="form-request"></div>
		<button class="btn btn-success" type="submit" id="register-properties" name="submit" value="send">Add property</button>
		<span class="decision">or</span>
		<a class="none link-more" id="set-properties-auto-data" href="#">Add property info by MLS ID</a>
	</div>
<?= form_close(); ?>