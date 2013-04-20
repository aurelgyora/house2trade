<?=form_open('search-properties',array('class'=>'form-horizontal','id'=>'search-properties')); ?>
	<input id="community_id" name="community_id" type="hidden" value="372" />
	<input id="user_username" name="username" type="hidden" value="<?=$this->profile['fname'].' '.$this->profile['lname'];?>" />
	<input id="user_identity_url" name="identity_url" type="hidden" />
	<!--
	<ul class="form-selector">
		<li class="active"><a class="none" href="">For Sale</a></li>
		<li><a class="none" href="">For Rent</a></li>
		<li><a class="none" href="">Sold</a></li>
	</ul>
	-->
	<p>
		<label>Address</label>
		<input id="property_mls" value="<?=(isset($parameters->property_address) && $parameters->property_address)?$parameters->property_address:'';?>" name="property_address" size="" type="text" placeholder="Enter property address">
		<label>City, State, ZIP</label>
		<input id="property_zip" value="<?=(isset($parameters->property_zip) && $parameters->property_zip)?$parameters->property_zip:'';?>" name="property_zip" size="15" type="text" placeholder="City, State and/or ZIP code">
		<label>Price range</label>
		<input id="property_min_price" value="<?=(isset($parameters->property_min_price) && $parameters->property_min_price)?$parameters->property_min_price:'';?>" name="property_min_price" size="30" type="text" placeholder="$ Min"> <span class="decision">to</span>
		<input id="property_max_price" value="<?=(isset($parameters->property_max_price) && $parameters->property_max_price)?$parameters->property_max_price:'';?>" name="property_max_price" size="30" type="text" placeholder="$ Max">  <br/>
		<label>Retail properties</label>
		<select id="property_beds_num" name="beds_num">
			<option value="">Beds</option>
		<?php for($i=1;$i<=5;$i++):?>
			<option value="<?=$i?>" <?=(isset($parameters->beds_num) && ($parameters->beds_num == $i))?'selected="selected"':'';?>><?=$i?></option>
		<?php endfor;?>
		</select>
		<select id="property_baths_num" name="baths_num">
			<option value="">Baths</option>
		<?php for($i=1;$i<=5;$i++):?>
			<option value="<?=$i?>" <?=(isset($parameters->baths_num) && ($parameters->baths_num == $i))?'selected="selected"':'';?>><?=$i?></option>
		<?php endfor;?>
		</select>
		<select id="property_square_feet" name="square_feet" class="tall">
			<option value="">Square Feet</option>
		<?php for($i=250;$i<=1250;$i+=250):?>
			<option value="<?=$i?>" <?=(isset($parameters->square_feet) && ($parameters->square_feet == $i))?'selected="selected"':'';?>><?=$i.' - ';?></option>
		<?php endfor;?>
		</select>
		<select id="property_type" class="tall" name="type">
			<option value="">Property Type</option>
		<?php for($i=0;$i<count($property_type);$i++):?>
			<option value="<?=$property_type[$i]['id'];?>" <?=(isset($parameters->type) && ($parameters->type == $property_type[$i]['id']))?'selected="selected"':'';?>><?=$property_type[$i]['title'];?></option>
		<?php endfor;?>
		</select> 
	</p>
	<p class="button-row">
		<input class="btn btn-success btn-submit" id="search_button" name="commit" type="submit" value="Search">
		<span class="wait-request hidden"><img src="<?=site_url('img/loading.gif');?>" alt="" /></span><span id="form-request"></span>
	</p>
	<div class="clear"> </div>
<?= form_close(); ?>