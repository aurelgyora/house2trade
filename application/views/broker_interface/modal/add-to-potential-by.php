<div id="addToPotentialBy" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="addToPotentialBy" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Add to potential buy</h3>
	</div>
	<div class="modal-body">
		<p>Have you seen this property?</p>
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
		<button data-target="null" data-src="" class="btn btn-primary btn-comfirm-add-potential-by">Yes</button>
		<button class="btn" data-dismiss="modal" aria-hidden="true">No</button>
	</div>
</div>