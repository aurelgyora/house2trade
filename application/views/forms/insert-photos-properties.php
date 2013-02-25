<form id="upload" action="<?=site_url('multi-upload');?>" method="POST" enctype="multipart/form-data">
	<p id="photos-block-message"></p>
	<div class="clear"></div>
	<fieldset>
		<legend>Use the form below to upload property images</legend>
		<input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="5000000" />
		<div class="control-group">
			<p>&nbsp;</p>
			<label for="fileselect">Files to upload:</label>
			<input type="file" id="fileselect" size="45" autocomplete="off" name="fileselect[]" multiple="multiple" />
			<div id="filedrag">or drop files here</div>
		</div>
		<div id="submitbutton">
			<button type="submit">Upload Files</button>
		</div>
	</fieldset>
</form>
<div id="progress"></div>
<?php if($this->uri->segment(3) != 'edit'):?>
<div class="alert">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Warning!</strong> Don't refresh the page while upload images. If this happens, you can add images when editing property.
</div>
<?php endif;?>
<div id="messages"><ul id="list-images" class="thumbnails"></ul></div>