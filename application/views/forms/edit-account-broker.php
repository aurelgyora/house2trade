<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal')); ?>
	<legend>Profile Broker</legend>
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="fname">First Name: </label>
				<input class="span4 valid-required FieldSend" name="fname" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['fname'];?>">
			</div>
			<div class="control-group">
				<label for="lname">Last Name: </label>
				<input class="span4 valid-required FieldSend" name="lname" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['lname'];?>">
			</div>
		</fieldset>
	</div>
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="email">Email: </label>
				<input class="span4 valid-required FieldSend" id="login-email" name="email" <?=TOOLTIP_FIELD_BLANK;?> type="text"  value="<?=$profile['email'];?>">
			</div>
			<div class="control-group">
				<label for="email">SignUp date: </label>
				<input class="span4 valid-required FieldSend" name="signdate" <?=TOOLTIP_FIELD_BLANK;?> type="text"  value="<?=$profile['signdate'];?>">
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="phone">Phone: </label>
				<input class="span4 valid-required FieldSend" name="phone" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['phone'];?>">
			</div>
			<div class="control-group">
				<label for="cell">Cell: </label>
				<input class="span4 valid-required FieldSend" name="cell" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['cell'];?>">
			</div>
			
		</fieldset>
	</div>
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="license ">License: </label>
				<input class="span4 valid-required FieldSend" name="license" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['license'];?>">
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
	<div class="form-actions">
		<button class="btn btn-success pull-right" type="submit" disabled="disabled" name="submit" value="send">Add properties</button>
		<span id="block-message"></span>
	</div>
<?= form_close(); ?>