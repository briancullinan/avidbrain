<?php
	if(DEBUG==true){

		echo '<div class="padd5 red white-text">';
		echo '<p>Test TAX ID: 000000000</p>';
		echo '<p>Test Routing Number: 111000025</p>';
		echo '<p>Test Bank Account Number: 000123456789</p>';
		echo '</div>';
	}
?>

<div class="box">
	<div class="bank-details">
		<div class="bank-errors"></div>
		<div class="bank-details-inputs hide"><input class="form-control" type="text" readonly="readonly" placeholder="Country" id="country" value="US" /></div>
		<div class="bank-details-inputs hide"><input class="form-control" type="text" readonly="readonly" placeholder="Currency" id="currency" value="USD" /></div>

		<div class="row">

			<div class="col-xs-12 col-sm-6 col-md-6">
				<div class="form-group bank-details-inputs input-info">
					<label for="full_legal_name">Full Legal Name <span class="required"><i class="fa fa-asterisk"></i></span></label>
					<input class="form-control" type="text" placeholder="Please Enter Your Full Legal Name" id="full_legal_name" value="<?php echo $app->user->first_name.' '.$app->user->last_name; ?>" />
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6">
				<div class="form-group bank-details-inputs input-info">
					<label for="tax_id">Your Tax ID / SSN <span class="required"><i class="fa fa-asterisk"></i></span></label>
					<input class="form-control" type="text" placeholder="Please Enter Your Tax ID / SSN" id="tax_id" value="" />
				</div>
			</div>

		</div>

		<div class="row">

			<div class="col-xs-12 col-sm-6 col-md-6">
				<div class="form-group bank-details-inputs input-info">
					<label for="routing_number">Routing Number <span class="required"><i class="fa fa-asterisk"></i></span></label>
					<input class="form-control" type="text" placeholder="Please Enter Your Bank's Routing Number" id="routing_number_confirm" value="" />
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6">
				<div class="form-group bank-details-inputs input-info">
					<label for="routing_number">Confirm Routing Number <span class="required"><i class="fa fa-asterisk"></i></span></label>
					<input class="form-control" type="text" placeholder="Please Enter Your Bank's Routing Number" id="routing_number" value="" />
					<div class="error"></div>
				</div>
			</div>

		</div>

		<div class="row">

			<div class="col-xs-12 col-sm-6 col-md-6">
				<div class="form-group bank-details-inputs input-info">
					<label for="account_number">Bank Account Number <span class="required"><i class="fa fa-asterisk"></i></span></label>
					<input class="form-control" type="text" placeholder="Please Enter Your Bank Account Number" id="account_number_confirm" value="" />
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6">
				<div class="form-group bank-details-inputs input-info">
					<label for="account_number">Confirm Bank Account Number <span class="required"><i class="fa fa-asterisk"></i></span></label>
					<input class="form-control" type="text" placeholder="Please Enter Your Bank Account Number" id="account_number" value="" />
					<div class="error"></div>
				</div>
			</div>

		</div>



		<div class="bank-details-inputs"><button type="button" id="save_tok" class="btn btn-default">Save</button></div>
	</div>
</div>


<form method="post" class="hide" id="bank_token" action="/payment/get-paid">
	<?php if(isset($updatebank)): ?>
		<input type="hidden" name="bank_token_update[target]" value="bank_token_update"  />
		<input type="hidden" name="bank_token_update[token]" class="bank_token" />
		<input type="hidden" name="bank_token_update[full_legal_name]" class="full_legal_name" />
		<input type="hidden" name="bank_token_update[tax_id]" class="tax_id" />

			<input type="hidden" name="bank_token[target]" value="bank_token"  />
			<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
	<?php else: ?>
		<input type="hidden" name="bank_token[target]" value="bank_token"  />
		<input type="hidden" name="bank_token[token]" class="bank_token" />
		<input type="hidden" name="bank_token[full_legal_name]" class="full_legal_name" />
		<input type="hidden" name="bank_token[tax_id]" class="tax_id" />

			<input type="hidden" name="bank_token[target]" value="bank_token"  />
			<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
	<?php endif; ?>
</form>
