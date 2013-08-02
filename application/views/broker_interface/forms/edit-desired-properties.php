<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal form-edit-desired-property')); ?>
	<legend>Desired property</legend>
	<fieldset>
		<div class="span4">
			<div class="control-group">
				<label for="city">City*: </label>
				<input class="span2 valid-required FieldSend" name="desired_city" type="text" value="<?=$desired_property['city'];?>">
			</div>
			<div class="control-group">
				<label for="state">State*: </label>
				<input class="span2 valid-required FieldSend" name="desired_state" type="text" value="<?=$desired_property['state'];?>">
			</div>
			<div class="control-group">
				<label for="type">Type*: </label>
				<select class="span4 FieldSend" name="desired_type">
				<?php for($i=0;$i<count($property_type);$i++):?>
					<option value="<?=$property_type[$i]['id'];?>" <?=($desired_property['type'] == $property_type[$i]['id'])?'selected="selected"':''?>><?=$property_type[$i]['title'];?></option>
				<?php endfor;?>
				</select>
			</div>
			<div class="control-group">
				<label for="state">Zip code*: </label>
				<input class="span2 valid-required FieldSend" name="desired_zip_code" type="text" value="<?=($desired_property['zip_code'])?$desired_property['zip_code']:'';?>">
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<label for="bathrooms">Bathrooms: </label>
				<input class="span2 digital FieldSend" name="desired_bathrooms" type="text" value="<?=($desired_property['bathrooms'])?$desired_property['bathrooms']:'';?>">
			</div>
			<div class="control-group">
				<label for="bedrooms">Bedrooms: </label>
				<input class="span2 digital FieldSend" name="desired_bedrooms" type="text" value="<?=($desired_property['bedrooms'])?$desired_property['bedrooms']:'';?>">
			</div>
			<div class="control-group">
				<label for="price">Max price*: </label>
				<input class="span2 numeric-float valid-required FieldSend" name="desired_max_price" type="text" value="<?=($desired_property['max_price'])?$desired_property['max_price']:'';?>">
			</div>
		</div>
	</fieldset>
	<div class="clear"></div>
	<div class="form-actions">
		<div class="form-request"></div>
		<span class="wait-request hidden"><img src="<?=site_url('img/loading.gif');?>" alt="" /></span>
		<button class="btn btn-success btn-save-disared-property" data-target="<?=($this->uri->segment(2) == 'recommended')?'refresh':'';?>" type="submit" name="submit" value="send">Save disared property</button>
	</div>
<?= form_close(); ?>