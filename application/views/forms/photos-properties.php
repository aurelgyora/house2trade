<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal form-remove-property-images')); ?>
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
		<div class="form-request"></div>
		<button class="btn btn-danger btn-delete-property-images" type="submit" name="submit" value="send">Delete property images</button>
	</div>
<?= form_close(); ?>