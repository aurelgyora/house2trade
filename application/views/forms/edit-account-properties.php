<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal','id'=>'form-edit-property-info')); ?>
<?php if($property['owner_id'] != $this->user['uid']):?>
	<legend>Owner account data</legend>
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="fname">First Name*: </label>
				<input class="span4 valid-required FieldSend" name="fname" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$property['owner']['fname'];?>">
			</div>
			<div class="control-group">
				<label for="lname">Last Name*: </label>
				<input class="span4 valid-required FieldSend" name="lname" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$property['owner']['lname'];?>">
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
<?php endif;?>
	<legend>Property info</legend>
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="city">City*: </label>
				<input class="span4 valid-required FieldSend" name="city" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$property['city'];?>">
			</div>
			<div class="control-group">
				<label for="state">State*: </label>
				<input class="span4 valid-required FieldSend" name="state" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$property['state'];?>">
			</div>
			<div class="control-group">
				<label for="address1">Address 1*: </label>
				<textarea class="span4 valid-required FieldSend" rows="1" name="address1" <?=TOOLTIP_FIELD_BLANK;?>><?=$property['address1'];?></textarea>
			</div>
			<div class="control-group">
				<label for="address2">Address 2: </label>
				<textarea class="span4 FieldSend" rows="1" name="address2" <?=TOOLTIP_FIELD_BLANK;?>><?=$property['address2'];?></textarea>
			</div>
			<div class="control-group">
				<label for="type">Type*: </label>
				<input class="span2 valid-required FieldSend" name="type" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$property['type'];?>">
			</div>
			<div class="control-group">
				<label for="zip_code">Zip code*: </label>
				<input class="span2 digital valid-required FieldSend" readonly="readonly" name="zip_code" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$property['zip_code'];?>">
			</div>
			<div class="control-group">
				<label for="bathrooms">Bathrooms*: </label>
				<input class="span2 digital valid-required FieldSend" name="bathrooms" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$property['bathrooms'];?>">
			</div>
			<div class="control-group">
				<label for="bedrooms">Bedrooms*: </label>
				<input class="span2 digital valid-required FieldSend" name="bedrooms" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$property['bedrooms'];?>">
			</div>
			<div class="control-group">
				<label for="sqf">Square Feed*: </label>
				<input class="span2 valid-required FieldSend" name="sqf" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$property['sqf'];?>">
			</div>
			<div class="control-group">
				<label for="price">Price*: </label>
				<input class="span2 numeric-float valid-required FieldSend" name="price" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$property['price'];?>">
			</div>
			<div class="control-group">
				<label for="tax">Tax: </label>
				<input class="span2 digital valid-required FieldSend" name="tax" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$property['tax'];?>">
			</div>
			<div class="control-group">
				<label for="mls">MLS*: </label>
				<input class="span2 digital valid-required FieldSend" readonly="readonly" name="mls" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$property['mls'];?>">
			</div>
			<div class="control-group">
				<label for="description">Description*: </label>
				<textarea class="span8 valid-required FieldSend" rows="4" name="description" <?=TOOLTIP_FIELD_BLANK;?>><?=$property['description'];?></textarea>
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
<?php if(FALSE):?>
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
<?php endif;?>
	<div class="form-actions">
		<span class="pull-right" id="block-message"></span>
		<div class="clear"></div>
		<button class="btn btn-success pull-right" id="save-property" type="submit" name="submit" value="send">Save property info</button>
		<div class="span4">
			<a class="none btn add-property-images"><i class="icon-plus"></i> Add images</a>
			<a class="none btn" id="remove-property-images"><i class="icon-minus"></i>Remove images</a>
		</div>
	</div>
<?= form_close(); ?>