<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal','id'=>'save-mail-content')); ?>
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="fname">Subject*: </label>
				<input class="span8 valid-required" name="subject" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=$mail['subject'];?>">
			</div>
			<div class="control-group">
				<label for="cmail">Body*: </label>
				<textarea class="span8" rows="8" name="content" <?=TOOLTIP_FIELD_BLANK;?>><?=$mail['content'];?></textarea>
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
	<div class="form-actions">
		<button class="btn btn-success" type="submit" name="submit" value="send">Save information</button>
	</div>
<?= form_close(); ?>