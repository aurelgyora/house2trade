<?=form_open_multipart('administrator/companies/insert',array('class'=>'form-horizontal','id'=>'form-manage-company'));?>
	<?php if($this->uri->total_segments() == 4):?>
		<input class="" name="id" type="hidden" value="<?=$this->uri->segment(4)?>" />
	<?php endif;?>
	<div class="span4">
		<fieldset>
			<div class="control-group">
				<label for="fname">Title*: </label>
				<input class="span8 valid-required" name="title" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=(isset($company['title']))?$company['title']:'';?>">
			</div>
			<div class="control-group">
				<label for="fname">Logo*: </label>
				<input class="" name="logo" type="file" />
			</div>
			
			<div class="control-group">
				<label for="cmail">Phone*: </label>
				<input class="span8 valid-required" id="company-phone" name="phone" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=(isset($company['phone']))?$company['phone']:'';?>">
			</div>
			<div class="control-group">
				<label for="cmail">E-mail*: </label>
				<input class="span8 valid-email valid-required" id="company-email" name="email" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=(isset($company['email']))?$company['email']:'';?>">
			</div>
			<div class="control-group">
				<label for="cmail">Website*: </label>
				<input class="span8 valid-required" name="website" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=(isset($company['website']))?$company['website']:'';?>">
			</div>
			<div class="control-group">
				<label for="cmail">Address 1*: </label>
				<textarea class="span8 valid-required" rows="2" name="address1" <?=TOOLTIP_FIELD_BLANK;?>><?=(isset($company['address1']))?$company['address1']:'';?></textarea>
			</div>
			<div class="control-group">
				<label for="cmail">Address 2: </label>
				<textarea class="span8" rows="2" name="address2" <?=TOOLTIP_FIELD_BLANK;?>><?=(isset($company['address2']))?$company['address2']:'';?></textarea>
			</div>
			<div class="control-group">
				<label for="cmail">City*: </label>
				<input class="span8 valid-required" name="city" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=(isset($company['city']))?$company['city']:'';?>">
			</div>
			<div class="control-group">
				<label for="cmail">State*: </label>
				<input class="span8 valid-required" name="state" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=(isset($company['state']))?$company['state']:'';?>">
			</div>
			<div class="control-group">
				<label for="cmail">Zip_code*: </label>
				<input class="span8 valid-required" name="zip_code" <?=TOOLTIP_FIELD_BLANK;?> type="text" value="<?=(isset($company['zip_code']))?$company['zip_code']:'';?>">
			</div>
		</fieldset>
	</div>
	<div class="clear"></div>
	<div id="block-message"></div>
	<div class="form-actions">
		<button class="btn btn-success" type="submit" name="submit" value="send">Save information</button>
	</div>
<?= form_close(); ?>