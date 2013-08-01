<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal','id'=>'form-property-register')); ?>
<?php
	$seller = FALSE;
	if(isset($this->owner['seller']) && $this->owner['seller']):
		$seller = TRUE;
	endif;
?>
<?php if(!$seller):?>
	<legend>HomeOwner data</legend>
	<fieldset>
		<div class="span4">
			<div class="control-group">
				<label for="fname">First Name*: </label>
				<input id="property-fname" class="span2 valid-required FieldSend" name="fname" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="">
			</div>
			<div class="control-group">
				<label for="lname">Last Name*: </label>
				<input id="property-lname" class="span2 valid-required FieldSend" name="lname" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="">
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<label for="email">Email*: </label>
				<input id="login-email" class="span2 valid-required unique-email FieldSend" name="email" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="">
			</div>
		</div>
	</fieldset>
	<div class="clear"></div>
<?php endif;?>
	<legend>Property data</legend>
	<fieldset>
		<div class="span4">
			<div class="control-group">
				<label for="city">City*: </label>
				<input id="property-city" class="span2 valid-required FieldSend" name="city" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="">
			</div>
			<div class="control-group">
				<label for="state">State*: </label>
				<input id="property-state" class="span2 valid-required FieldSend" name="state" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="">
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
				<input id="property-bathrooms" class="span2 digital valid-required FieldSend" name="bathrooms" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="">
			</div>
			<div class="control-group">
				<label for="bedrooms">Bedrooms*: </label>
				<input id="property-bedrooms" class="span2 digital valid-required FieldSend" name="bedrooms" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="">
			</div>
			<div class="control-group">
				<label for="sqf">Square Feed*: </label>
				<input id="property-sqf" class="span2 valid-required FieldSend" name="sqf" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="">
			</div>
			<div class="control-group">
				<label for="sqf">Loot Size*: </label>
				<input id="property-lot-size" class="span2 valid-required FieldSend" name="lotsize" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="">
			</div>
			<div class="control-group">
				<label for="price">Price*: </label>
				<input id="property-price" class="span2 numeric-float valid-required FieldSend" name="price" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="">
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<label for="zip_code">Zip code*: </label>
				<input id="property-zipcode" class="span2 digital valid-required FieldSend" name="zip_code" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="">
			</div>
			<div class="control-group">
				<label for="address1">Address 1*: </label>
				<textarea id="property-address1" class="span3 valid-required FieldSend" rows="3" name="address1" <?=TOOLTIP_FIELD_BLANK;?>></textarea>
			</div>
			<div class="control-group">
				<label for="address2">Address 2: </label>
				<textarea id="property-address2" class="span3 FieldSend" rows="3" name="address2" <?=TOOLTIP_FIELD_BLANK;?>></textarea>
			</div>
			<div class="control-group">
				<label for="tax">Tax: </label>
				<input id="property-tax" class="span2 digital FieldSend" name="tax" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="">
			</div>
			<div class="control-group">
				<label for="mls">Bank price: </label>
				<input id="property-bank-price" class="span2 numeric-float FieldSend" name="bank_price" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="">
			</div>
			<div class="control-group">
				<label for="mls">MLS: </label>
				<input id="property-mls" class="span2 FieldSend" name="mls" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="">
			</div>
			<div class="control-group">
				<label for="description">Description*: </label>
				<textarea id="property-discription" class="span3 valid-required FieldSend" rows="3" name="description" <?=TOOLTIP_FIELD_BLANK;?>></textarea>
			</div>
		</div>
	</fieldset>
	<legend>Desired property</legend>
	<fieldset>
	</fieldset>
	<div class="clear"></div>
	<div class="form-actions">
		<div id="form-request"></div>
		<span class="wait-request hidden"><img src="<?=site_url('img/loading.gif');?>" alt="" /></span>
	<?php if($this->account['group'] == 3 && $this->owner['seller']):?>
		<button class="btn btn-success" type="submit" id="seller-register-properties" name="submit" value="send">Add property</button>
	<?php else:?>
		<button class="btn btn-success" type="submit" id="register-properties" name="submit" value="send">Add property</button>
	<?php endif;?>
		<span class="decision">or</span>
		<a class="none link-more" id="set-properties-auto-data" href="#">Add property info by ZIP</a>
	</div>
<?= form_close(); ?>