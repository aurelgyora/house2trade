<?php if($owners):?>
<select id="input-select-owner" class="span6" name="current_owner">
<?php if(!$this->session->userdata('current_owner')):?>
	<option value="" selected="selected">Select homeowner</option>
<?php endif;?>
<?php for($i=0;$i<count($owners);$i++):?>
	<option value="<?=$owners[$i]['uid'];?>" <?=($owners[$i]['uid'] == $this->session->userdata('current_owner'))?'selected="selected"':'';?>>
	<?=$owners[$i]['fname'].' '.$owners[$i]['lname'].' '.$owners[$i]['address1'].' $'.$owners[$i]['price'];?>
	</option>
<?php endfor;?>
</select>
<?php endif;?>