<?php
	$selected = FALSE;
	if($this->input->get('property') !== FALSE && is_numeric($this->input->get('property'))):
		$selected = $this->input->get('property');
	endif;
?>
<select class="span7 chosen-property" autocomplete="off" data-placeholder="Select property" name="property">
	<option value="0" selected="selected">All property<option>
<?php for($i=0;$i<count($properties_titles);$i++):?>
	<option <?=($properties_titles[$i]['id'] == $selected)? 'selected="selected"':''?> value="<?=$properties_titles[$i]['id'];?>"><?=$properties_titles[$i]['address1'].', '.$properties_titles[$i]['city'].' '.$properties_titles[$i]['state'];?></option>
<?php endfor;?>
</select>
<button type="button" class="btn btn-mini btn-set-chosen-property">SHOW</button>
<div class="clear"></div>