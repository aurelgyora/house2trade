<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal','id'=>'form-remove-property-images')); ?>
	<legend>List property images</legend>
	<div class="media">
	<?php for($i=0;$i<count($images);$i++):?>
		<div class="span3 property-image-item">
			<img class="span2 img-polaroid media-object" src="<?=site_url($images[$i]['photo']);?>" alt="" >
			<div class="media-body">
				<input type="checkbox" name="image<?=$i;?>" class="image-checked FieldSend" value="<?=$images[$i]['id'];?>" autocomplete="off" />
			</div>
		</div>
	<?php endfor;?>
	</div>
	<div class="form-actions">
		<span class="pull-right" id="block-message"></span>
		<div class="clear"></div>
		<button class="btn btn-danger pull-right" id="delete-property-images" type="submit" name="submit" value="send">Delete property images</button>
		<div class="span4">
			<a class="none btn add-property-images"><i class="icon-plus"></i> Add images</a>
		</div>
	</div>
<?= form_close(); ?>