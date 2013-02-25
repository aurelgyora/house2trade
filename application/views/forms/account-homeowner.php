<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal')); ?>
	<legend>Registration HomeOwner</legend>
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="email">Email: </label>
				<input class="valid-required FieldSend" id="login-email" name="email" size="30" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
			<div class="control-group">
				<label for="email">Password: </label>
				<input class="valid-required FieldSend" id="login-password" name="password" size="30" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
			
			<div class="control-group">
				<label for="zip_code">Zip code: </label>
				<input class="valid-required FieldSend" id="login-email" name="zip_code" size="30" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
			<div class="control-group">
				<label for="link" class="control-label">Ссылка: </label>
				<div class="controls">
					<input type="text" class="input-xlarge input-valid" name="link" value="<?=set_value('link');?>">
					<span class="help-inline" style="display:none;">&nbsp;</span>
				</div>
			</div>
			<div class="control-group">
				<label for="sort" class="control-label">Пордковый номер: </label>
				<div class="controls">
					<input type="text" class="span1 digital" name="sort" value="<?=set_value('sort');?>">
					<span class="help-inline" style="display:none;">&nbsp;</span>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="email">Email: </label>
				<input class="valid-required FieldSend" id="login-email" name="email" size="30" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
			<div class="control-group">
				<label for="email">Password: </label>
				<input class="valid-required FieldSend" id="login-password" name="password" size="30" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
			
			<div class="control-group">
				<label for="zip_code">Zip code: </label>
				<input class="valid-required FieldSend" id="login-email" name="zip_code" size="30" <?=TOOLTIP_FIELD_BLANK;?> type="text">
			</div>
			<div class="control-group">
				<label for="link" class="control-label">Ссылка: </label>
				<div class="controls">
					<input type="text" class="input-xlarge input-valid" name="link" value="<?=set_value('link');?>">
					<span class="help-inline" style="display:none;">&nbsp;</span>
				</div>
			</div>
			<div class="control-group">
				<label for="sort" class="control-label">Пордковый номер: </label>
				<div class="controls">
					<input type="text" class="span1 digital" name="sort" value="<?=set_value('sort');?>">
					<span class="help-inline" style="display:none;">&nbsp;</span>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
	<div class="form-actions">
		<button class="btn btn-success" type="submit" id="send" name="submit" value="send">Добавить</button>
		<button class="btn btn-inverse backpath" type="button">Отменить</button>
	</div>
<?= form_close(); ?>