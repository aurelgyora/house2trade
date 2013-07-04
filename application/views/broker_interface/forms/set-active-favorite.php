<?php if($select):?>
<select id="input-select-favorite" class="span6" name="current_property">
<?php if(!$this->session->userdata('current_property') == FALSE):?>
	<option value="" selected="selected">Select property</option>
<?php endif;?>
<?php for($i=0;$i<count($select);$i++):?>
	<option value="<?=$select[$i]['id'];?>" <?=($select[$i]['id'] == $this->session->userdata('current_property'))?'selected="selected"':'';?>>
	<?=$select[$i]['fname'].' '.$select[$i]['lname'].', '.$select[$i]['address1'].', '.$select[$i]['state'].' '.$select[$i]['zip_code'].', $'.$select[$i]['price'];?>
	</option>
<?php endfor;?>
</select>
<?php endif;?>