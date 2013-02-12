<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal')); ?>
	<input type="hidden" value="<?=$page['id'];?>" name="id" />
	<fieldset>
		<div class="control-group">
			<textarea rows="14" class="span9 ckeditor" name="content"><?=$page['content'];?></textarea>
		</div>
		<div class="form-actions">
			<button class="btn btn-primary" id="saveItem" type="submit" name="submit" value="submit">Save</button>
			<button class="btn btn-inverse" id="cancel">Cancel</button>
		</div>
	</fieldset>
<?= form_close(); ?>