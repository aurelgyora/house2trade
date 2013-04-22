<?php if($select):?>
<select id="input-select-property" class="span6 input-select-property" name="current_property">
<?php if(!$this->session->userdata('current_property')):?>
	<option value="" selected="selected">Select property</option>
<?php endif;?>
<?php if($this->uri->segment(2) == 'properties' && $this->session->userdata('current_property')):?>
	<option value="0">View Full List</option>
<?php endif;?>
<?php for($i=0;$i<count($select);$i++):?>
	<option value="<?=$select[$i]['id'];?>" <?=($select[$i]['id'] == $this->session->userdata('current_property'))?'selected="selected"':'';?>>
	<?=$select[$i]['fname'].' '.$select[$i]['lname'].', '.$select[$i]['address1'].', '.$select[$i]['state'].' '.$select[$i]['zip_code'].', $'.$select[$i]['price'];?>
	</option>
<?php endfor;?>
</select>
<?php endif;?>