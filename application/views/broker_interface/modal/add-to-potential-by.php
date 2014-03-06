<div id="addToPotentialBy" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="addToPotentialBy" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Add to potential buy</h3>
	</div>
	<div class="modal-body">
		<p id="seen_property">Have you seen this property?</p>
		<p id="not_seen_property">This very important that you see this property if you really want to buy it. Too many homeowners will relay on your decision.</p>
		<p class="hidden">
			Attention. Another user will depend on your decision, and it is important that you do it consciously.<br/>
			Please  specify down payment:
		</p>
		<div id="hidden-block" class="hidden">
			<div class="input-prepend input-append">
				<input class="input-mini valid-numeric valid-max-value" data-max-value="100" id="down-payment" placeholder="Down Payment" type="text">
				<span class="add-on">%</span>
			</div>
			<div class="alert alert-info">
				<p>
					<strong>Attention.</strong> The down payment is not required, but the value of the down payment is very important for sales. 
					All participants in the transaction are dependent on this payment and can not agree if the payment is too small.
				</p>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button id="modal-btn-yes" data-target="null" data-src="" class="btn btn-primary btn-comfirm-add-potential-by">Yes</button>
		<button id="modal-btn-no" class="btn">No</button>
		<button id="modal-btn-cancel" class="btn" style="display: none;" data-dismiss="modal" aria-hidden="true">Close</button>
	</div>
</div>