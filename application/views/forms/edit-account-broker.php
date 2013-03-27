<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal')); ?>
	<legend>Account</legend>
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="fname">First Name*: </label>
				<input class="span4 valid-required FieldSend" name="fname" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['fname'];?>">
			</div>
			<div class="control-group">
				<label for="lname">Last Name*: </label>
				<input class="span4 valid-required FieldSend" name="lname" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['lname'];?>">
			</div>
		</fieldset>
	</div>
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="phone">Phone*: </label>
				<input class="span4 valid-required FieldSend" name="phone" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['phone'];?>">
			</div>
			<div class="control-group">
				<label for="cell">Cell: </label>
				<input class="span4 FieldSend" name="cell" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['cell'];?>">
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
	<legend>Company</legend>
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="company">Company name*: </label>
				<input class="span4 valid-required FieldSend" name="company" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['company'];?>">
			</div>
			<div class="control-group">
				<label for="address">Company address: </label>
				<input class="span4 FieldSend" name="address" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['address'];?>">
			</div>
			<div class="control-group">
				<label for="cphone">Company phone: </label>
				<input class="span4 FieldSend" name="cphone" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['cphone'];?>">
			</div>
			
		</fieldset>
	</div>
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="cmail">Company email: </label>
				<input class="span4 FieldSend" name="cmail" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['cmail'];?>">
			</div>
			<div class="control-group">
				<label for="website">Company website: </label>
				<input class="span4 FieldSend" name="website" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['website'];?>">
			</div>
			<div class="control-group">
				<label for="cphone">Company license: </label>
				<input class="span4 FieldSend" name="license" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$profile['info']['cphone'];?>">
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
				<label for="confirm">Confirm password: </label>
				<input class="span4 FieldSend" id="confirm-password" name="confirm" <?=TOOLTIP_FIELD_BLANK;?> type="password">
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
	<legend>Subscribe</legend>
	<div class="span9">
		<p class="register-check">
			<span class="checky">
				<input <?=($profile['info']['subcribe'])?'checked="checked" ':'';?> id="subcribe" name="subcribe" type="checkbox" value="1">
			</span>
			Add me to the House2Trade mailing list to receive announcements.
		</p>
	</div>
	<div class="clear"></div>
	<div class="form-actions">
		<button class="btn btn-success" id="save-profile" type="submit" name="submit" value="send">Save information</button>
	</div>
<?php endif;?>
<?= form_close(); ?>