<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal','id'=>'form-property-register')); ?>
	<legend>Add property manually - Step <span id="span-step-number">1</span></legend>
	<div class="div-register-property register-property-step-1">
		<legend>HomeOwner data</legend>
		<fieldset>
			<div class="span4">
				<div class="control-group">
					<label for="fname">First Name*: </label>
					<input id="property-fname" class="span2 valid-required FieldSend" name="fname" type="text" value="">
				</div>
				<div class="control-group">
					<label for="lname">Last Name*: </label>
					<input id="property-lname" class="span2 valid-required FieldSend" name="lname" type="text" value="">
				</div>
			</div>
			<div class="span4">
				<div class="control-group">
					<label for="email">Email*: </label>
					<input id="login-email" class="span2 valid-required unique-email FieldSend" name="email" type="text" value="">
				</div>
			</div>
		</fieldset>
		<div class="clear"></div>
		<legend>Property data</legend>
		<fieldset>
			<div class="span4">
				<div class="control-group">
					<label for="city">City*: </label>
					<input id="property-city" class="span2 valid-required FieldSend" name="city" type="text" value="">
				</div>
				<div class="control-group">
					<label for="state">State*: </label>
					<input id="property-state" class="span2 valid-required FieldSend" name="state" type="text" value="">
				</div>
				<div class="control-group">
					<label for="type">Type*: </label>
					<select id="property-type" class="span4 FieldSend" name="type">
					<?php for($i=0;$i<count($property_type);$i++):?>
						<option value="<?=$property_type[$i]['id'];?>"><?=$property_type[$i]['title'];?></option>
					<?php endfor;?>
					</select>
				</div>
				<div class="control-group">
					<label for="bathrooms">Bathrooms*: </label>
					<input id="property-bathrooms" class="span2 digital valid-required FieldSend" name="bathrooms" type="text" value="">
				</div>
				<div class="control-group">
					<label for="bedrooms">Bedrooms*: </label>
					<input id="property-bedrooms" class="span2 digital valid-required FieldSend" name="bedrooms" type="text" value="">
				</div>
				<div class="control-group">
					<label for="sqf">Square Feed*: </label>
					<input id="property-sqf" class="span2 valid-required FieldSend" name="sqf" type="text" value="">
				</div>
				<div class="control-group">
					<label for="sqf">Loot Size*: </label>
					<input id="property-lot-size" class="span2 valid-required FieldSend" name="lotsize" type="text" value="">
				</div>
				<div class="control-group">
					<label for="price">Price*: </label>
					<input id="property-price" class="span2 numeric-float valid-required FieldSend" name="price" type="text" value="">
				</div>
			</div>
			<div class="span4">
				<div class="control-group">
					<label for="zip_code">Zip code*: </label>
					<input id="property-zipcode" class="span2 digital valid-required FieldSend" name="zip_code" type="text" value="">
				</div>
				<div class="control-group">
					<label for="address1">Address 1*: </label>
					<textarea id="property-address1" class="span3 valid-required FieldSend" rows="3" name="address1"></textarea>
				</div>
				<div class="control-group">
					<label for="address2">Address 2: </label>
					<textarea id="property-address2" class="span3 FieldSend" rows="3" name="address2"></textarea>
				</div>
				<div class="control-group">
					<label for="tax">Tax: </label>
					<input id="property-tax" class="span2 digital FieldSend" name="tax" type="text" value="">
				</div>
				<div class="control-group">
					<label for="mls">Bank price: </label>
					<input id="property-bank-price" class="span2 numeric-float FieldSend" name="bank_price" type="text" value="">
				</div>
				<div class="control-group">
					<label for="mls">MLS: </label>
					<input id="property-mls" class="span2 FieldSend" name="mls" type="text" value="">
				</div>
				<div class="control-group">
					<label for="description">Description*: </label>
					<textarea id="property-discription" class="span3 valid-required FieldSend" rows="3" name="description"></textarea>
				</div>
			</div>
		</fieldset>
		<div class="clear"></div>
	</div>
	<div class="div-register-property register-property-step-2 hidden">
		<legend>Desired property</legend>
		<fieldset>
			<div class="span4">
				<div class="control-group">
					<label for="city">City*: </label>
					<input class="span2 valid-required FieldSend" name="desired_city" type="text" value="">
				</div>
				<div class="control-group">
					<label for="state">State*: </label>
					<input class="span2 valid-required FieldSend" name="desired_state" type="text" value="">
				</div>
				<div class="control-group">
					<label for="type">Type*: </label>
					<select class="span4 FieldSend" name="desired_type">
					<?php for($i=0;$i<count($property_type);$i++):?>
						<option value="<?=$property_type[$i]['id'];?>"><?=$property_type[$i]['title'];?></option>
					<?php endfor;?>
					</select>
				</div>
				<div class="control-group">
					<label for="state">Zip code*: </label>
					<input class="span2 valid-required FieldSend" name="desired_zip_code" type="text" value="">
				</div>
			</div>
			<div class="span4">
				<div class="control-group">
					<label for="bathrooms">Bathrooms: </label>
					<input class="span2 digital FieldSend" name="desired_bathrooms" type="text" value="">
				</div>
				<div class="control-group">
					<label for="bedrooms">Bedrooms: </label>
					<input class="span2 digital FieldSend" name="desired_bedrooms" type="text" value="">
				</div>
				<div class="control-group">
					<label for="price">Max price*: </label>
					<input class="span2 numeric-float valid-required FieldSend" name="desired_max_price" type="text" value="">
				</div>
			</div>
		</fieldset>
		<div class="clear"></div>
	</div>
	<div class="form-actions">
		<div id="form-request"></div>
		<button class="btn btn-success btn-broker-register-property" data-register-step="1" type="button">Continue</button>
		<span class="decision">or</span>
		<a class="none link-more" id="set-properties-auto-data" href="#">Add property info by ZIP</a>
	</div>
<?= form_close(); ?>