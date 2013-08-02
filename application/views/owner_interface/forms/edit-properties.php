<?=form_open($this->uri->uri_string(),array('class'=>'form-horizontal form-edit-main-property')); ?>
	<legend>Property data</legend>
	<fieldset>
		<div class="span4">
			<div class="control-group">
				<label for="city">City*: </label>
				<input class="span2 valid-required FieldSend" name="city" type="text" value="<?=$property['city'];?>">
			</div>
			<div class="control-group">
				<label for="state">State*: </label>
				<input class="span2 valid-required FieldSend" name="state" type="text" value="<?=$property['state'];?>">
			</div>
			<div class="control-group">
				<label for="type">Type*: </label>
				<select id="input-select-type" class="span4 FieldSend" name="type">
				<?php for($i=0;$i<count($property_type);$i++):?>
					<option value="<?=$property_type[$i]['id'];?>" <?=($property['type'] == $property_type[$i]['id'])?'selected="selected"':''?>><?=$property_type[$i]['title'];?></option>
				<?php endfor;?>
				</select>
			</div>
			<div class="control-group">
				<label for="bathrooms">Bathrooms*: </label>
				<input id="property-bathrooms" class="span2 digital valid-required FieldSend" name="bathrooms" type="text" value="<?=$property['bathrooms'];?>">
			</div>
			<div class="control-group">
				<label for="bedrooms">Bedrooms*: </label>
				<input id="property-bedrooms" class="span2 digital valid-required FieldSend" name="bedrooms" type="text" value="<?=$property['bedrooms'];?>">
			</div>
			<div class="control-group">
				<label for="sqf">Square Feed*: </label>
				<input class="span2 valid-required FieldSend" name="sqf" type="text" value="<?=$property['sqf'];?>">
			</div>
			<div class="control-group">
				<label for="property-lot-size">Loot Size*: </label>
				<input id="property-lot-size" class="span2 valid-required FieldSend" name="lotsize" type="text" value="<?=$property['lotsize'];?>">
			</div>
			<div class="control-group">
				<label for="property-price">Price*: </label>
				<input id="property-price" class="span2 numeric-float valid-required FieldSend" name="price" type="text" value="<?=$property['price'];?>">
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<label for="zip_code">Zip code*: </label>
				<input id="property-zip" class="span2 digital valid-required FieldSend" readonly="readonly" name="zip_code" type="text" value="<?=$property['zip_code'];?>">
			</div>
			<div class="control-group">
				<label for="address1">Address 1*: </label>
				<textarea class="span3 valid-required FieldSend" rows="2" name="address1"><?=$property['address1'];?></textarea>
			</div>
			<div class="control-group">
				<label for="address2">Address 2: </label>
				<textarea class="span3 FieldSend" rows="2" name="address2"><?=$property['address2'];?></textarea>
			</div>
			<div class="control-group">
				<label for="tax">Tax: </label>
				<input id="property-tax" class="span2 digital valid-required FieldSend" name="tax" type="text" value="<?=$property['tax'];?>">
			</div>
			<div class="control-group">
				<label for="mls">Bank price: </label>
				<input id="property-bank-price" class="span2 numeric-float FieldSend" name="bank_price" type="text" value="<?=$property['bank_price'];?>">
			</div>
			<div class="control-group">
				<label for="mls">MLS: </label>
				<input id="property-mls" class="span2 digital FieldSend" name="mls" type="text" value="<?=$property['mls'];?>">
			</div>
			<div class="control-group">
				<label for="description">Description*: </label>
				<textarea class="span3 valid-required FieldSend" rows="3" name="description"><?=$property['description'];?></textarea>
			</div>
		</div>
	</fieldset>
	<div class="clear"></div>
	<div class="form-actions">
		<div class="form-request"></div>
		<span class="wait-request hidden"><img src="<?=site_url('img/loading.gif');?>" alt="" /></span>
		<button class="btn btn-success btn-save-main-property" type="submit" name="submit" value="send">Save main property</button>
	</div>
<?= form_close(); ?>