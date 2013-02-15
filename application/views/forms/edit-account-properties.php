<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal')); ?>
	<legend>Account data</legend>
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="fname">First Name*: </label>
				<input class="span4 valid-required FieldSend" name="fname" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['fname'];?>">
			</div>
		</fieldset>
	</div>
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="lname">Last Name*: </label>
				<input class="span4 valid-required FieldSend" name="lname" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['lname'];?>">
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
	<legend>Properties</legend>
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="city">City*: </label>
				<input class="span4 valid-required FieldSend" name="city" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['city'];?>">
			</div>
			<div class="control-group">
				<label for="state">State*: </label>
				<input class="span4 valid-required FieldSend" name="state" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['state'];?>">
			</div>
			<div class="control-group">
				<label for="address1">Address 1*: </label>
				<textarea class="span4 valid-required FieldSend" rows="1" name="address1" <?=TOOLTIP_FIELD_BLANK;?>><?=$profile['info']['address1'];?></textarea>
			</div>
			<div class="control-group">
				<label for="address2">Address 2: </label>
				<textarea class="span4 FieldSend" rows="1" name="address2" <?=TOOLTIP_FIELD_BLANK;?>><?=$profile['info']['address2'];?></textarea>
			</div>
		</fieldset>
	</div>
	<div class="span2">
		<fieldset>
			<div class="control-group">
				<label for="type">Type*: </label>
				<input class="span2 valid-required FieldSend" name="type" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['type'];?>">
			</div>
		</fieldset>
	</div>
	<div class="span2">
		<fieldset>
			<div class="control-group">
				<label for="zip_code">Zip code*: </label>
				<input class="span2 digital valid-required FieldSend" name="zip_code" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['zip_code'];?>">
			</div>
		</fieldset>
	</div>
	<div class="span2">
		<fieldset>
			<div class="control-group">
				<label for="bathrooms">Bathrooms*: </label>
				<input class="span2 digital valid-required FieldSend" name="bathrooms" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['bathrooms'];?>">
			</div>
		</fieldset>
	</div>
	<div class="span2">
		<fieldset>
			<div class="control-group">
				<label for="bedrooms">Bedrooms*: </label>
				<input class="span2 digital valid-required FieldSend" name="bedrooms" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['bedrooms'];?>">
			</div>
		</fieldset>
	</div>
	<div class="span2">
		<fieldset>
			<div class="control-group">
				<label for="sqf">Square Feed*: </label>
				<input class="span2 valid-required FieldSend" name="sqf" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['sqf'];?>">
			</div>
		</fieldset>
	</div>
	<div class="span2">
		<fieldset>
			<div class="control-group">
				<label for="price">Price*: </label>
				<input class="span2 numeric-float valid-required FieldSend" name="price" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['price'];?>">
			</div>
		</fieldset>
	</div>
	<div class="span2">
		<fieldset>
			<div class="control-group">
				<label for="tax">Tax: </label>
				<input class="span2 digital valid-required FieldSend" name="tax" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['tax'];?>">
			</div>
		</fieldset>
	</div>
	<div class="span2">
		<fieldset>
			<div class="control-group">
				<label for="mls">MLS*: </label>
				<input class="span2 digital valid-required FieldSend" readonly="readonly" name="mls" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['mls'];?>">
			</div>
		</fieldset>
	</div>
	<div class="span9">
		<fieldset>
			<div class="control-group">
				<label for="description">Description*: </label>
				<textarea class="span8 valid-required FieldSend" rows="4" name="description" <?=TOOLTIP_FIELD_BLANK;?>><?=$profile['info']['description'];?></textarea>
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
<?php if($profile['id'] == $this->user['uid']):?>
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
	<div class="form-actions">
		<button class="btn btn-success pull-right" id="save-profile" type="submit" name="submit" value="send">Save</button>
		<span id="block-message"></span>
	</div>
<?php endif;?>
<?= form_close(); ?>