<?php

	if(isset($app->user->account_id) && empty($app->user->managed_id)){

		$managed = \Stripe\Account::create(
			array(
				'from_recipient'=>$app->user->account_id
			)
		);

		$app->user->managed_id = $managed->id;
		$app->user->save();

		$app->redirect('/payment/get-paid');
	}

	if(isset($app->user->account_id)){
		try{
			$recipient = \Stripe\Recipient::retrieve($app->user->account_id);
		}
		catch(Exception $e){
			//printer($e);
		}
	}

	if(isset($app->user->account_id)){
		try{
			$account = \Stripe\Account::retrieve($app->user->managed_id);
		}
		catch(Exception $e){
			//printer($e);
		}
	}

	$countNeeded = $account->verification->fields_needed;


?>


<?php if(isset($recipient)): ?>
<?php if(count($countNeeded)>0): ?>
<h3>Verify Your Identity</h3>
<div class="one-last-step">One last step, we just need to verify your identity.</div>
<div class="red white-text one-last-red">
	All fields are required
</div>
<div class="block">

	<form method="post" class="form-post" id="verifyaccount" action="/payment/get-paid">

		<div class="sub-title">Birthday</div>
		<div class="sub-block">
			<div class="row">
				<div class="col s12 m4 l4"id="birthmonth">
					<select name="fields_needed[legal_entity][dob][month]" class="validate   validate-required  browser-default">
						<?php
							$months = array(
								'1'=>'January',
								'2'=>'February',
								'3'=>'March',
								'4'=>'April',
								'5'=>'May',
								'6'=>'June',
								'7'=>'July',
								'8'=>'August',
								'9'=>'September',
								'10'=>'October',
								'11'=>'November',
								'12'=>'Descember'
							);
						?>
						<option value="">
							-- Select Month
						</option>
						<?php foreach($months as $key => $value): ?>
							<option value="<?php echo $key; ?>">
								<?php echo $value; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col s12 m4 l4" id="birthdate">
					<select name="fields_needed[legal_entity][dob][day]" class="validate   validate-required  browser-default">
						<?php
							$days = range(1,31);
						?>
						<option value="">
							-- Select Day
						</option>
						<?php foreach($days as  $value): ?>
							<option value="<?php echo $value; ?>">
								<?php echo $value; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col s12 m4 l4" id="birthyear">
					<select name="fields_needed[legal_entity][dob][year]" class="validate   validate-required  browser-default">
						<?php
							$years = range(1900,date('Y'));
							$years = array_reverse($years);
						?>
						<option value="">
							-- Select Year
						</option>
						<?php foreach($years as  $value): ?>
							<option value="<?php echo $value; ?>">
								<?php echo $value; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		</div>

		<div class="sub-title">Address</div>

		<div class="sub-block">
			<label id="line1">
				Address Line 1
				<input type="text" name="fields_needed[legal_entity][address][line1]" />
			</label>
			<label id="city">
				City
				<input type="text" name="fields_needed[legal_entity][address][city]"  />
			</label>
			<label  id="zipcode">
				Zip Code
				<input type="text" name="fields_needed[legal_entity][address][postal_code]" maxlength="5"  />
			</label>
			<label  id="state">
				State
				<select id="cutchecks_state" name="fields_needed[legal_entity][address][state]" class="validate   validate-required  browser-default">
					<option  value="">Select State</option>
					<option  value="Alabama">Alabama</option>
					<option  value="Alaska">Alaska</option>
					<option  value="American Samoa">American Samoa</option>
					<option  value="Arizona">Arizona</option>
					<option  value="Arkansas">Arkansas</option>
					<option  value="California">California</option>
					<option  value="Colorado">Colorado</option>
					<option  value="Connecticut">Connecticut</option>
					<option  value="Delaware">Delaware</option>
					<option  value="District Of Columbia">District Of Columbia</option>
					<option  value="Federated States Of Micronesia">Federated States Of Micronesia</option>
					<option  value="Florida">Florida</option>
					<option  value="Georgia">Georgia</option>
					<option  value="Guam">Guam</option>
					<option  value="Hawaii">Hawaii</option>
					<option  value="Idaho">Idaho</option>
					<option  value="Illinois">Illinois</option>
					<option  value="Indiana">Indiana</option>
					<option  value="Iowa">Iowa</option>
					<option  value="Kansas">Kansas</option>
					<option  value="Kentucky">Kentucky</option>
					<option  value="Louisiana">Louisiana</option>
					<option  value="Maine">Maine</option>
					<option  value="Marshall Islands">Marshall Islands</option>
					<option  value="Maryland">Maryland</option>
					<option  value="Massachusetts">Massachusetts</option>
					<option  value="Michigan">Michigan</option>
					<option  value="Minnesota">Minnesota</option>
					<option  value="Mississippi">Mississippi</option>
					<option  value="Missouri">Missouri</option>
					<option  value="Montana">Montana</option>
					<option  value="Nebraska">Nebraska</option>
					<option  value="Nevada">Nevada</option>
					<option  value="New Hampshire">New Hampshire</option>
					<option  value="New Jersey">New Jersey</option>
					<option  value="New Mexico">New Mexico</option>
					<option  value="New York">New York</option>
					<option  value="North Carolina">North Carolina</option>
					<option  value="North Dakota">North Dakota</option>
					<option  value="Northern Mariana Islands">Northern Mariana Islands</option>
					<option  value="Ohio">Ohio</option>
					<option  value="Oklahoma">Oklahoma</option>
					<option  value="Oregon">Oregon</option>
					<option  value="Palau">Palau</option>
					<option  value="Pennsylvania">Pennsylvania</option>
					<option  value="Puerto Rico">Puerto Rico</option>
					<option  value="Rhode Island">Rhode Island</option>
					<option  value="South Carolina">South Carolina</option>
					<option  value="South Dakota">South Dakota</option>
					<option  value="Tennessee">Tennessee</option>
					<option  value="Texas">Texas</option>
					<option  value="Utah">Utah</option>
					<option  value="Vermont">Vermont</option>
					<option  value="Virgin Islands">Virgin Islands</option>
					<option  value="Virginia">Virginia</option>
					<option  value="Washington">Washington</option>
					<option  value="West Virginia">West Virginia</option>
					<option  value="Wisconsin">Wisconsin</option>
					<option  value="Wyoming">Wyoming</option>
			</select>
			</label>

		</div>

		<div class="sub-title">Identification</div>
		<div class="sub-block">
			<label  id="ssn">
				SSN Last 4
				<input type="text" name="fields_needed[legal_entity][ssn_last_4]" maxlength="4" />
			</label>
		</div>

		<div class="form-submit">
			<button class="btn blue" type="submit">
				Verify Account
			</button>
		</div>

		<input type="hidden" name="fields_needed[target]" value="fields_needed"  />
		<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

	</form>
</div>


<?php endif; ?>

<h3>Bank Details</h3>
<div class="box">
	<div class="well well-sm">

		<p>
			<strong>
				Description:
			</strong>

			<?php echo $recipient->description; ?>
		</p>

		<p>
			<strong>
				Name:
			</strong>

			<?php echo $recipient->name; ?>
		</p>

		<p>
			<strong>
				Bank Account Number (Last 4):
			</strong>

			<?php echo $recipient->active_account->last4; ?>
		</p>

		<p>
			<strong>
				Country:
			</strong>

			<?php echo $recipient->active_account->country; ?>
		</p>


		<p>
			<strong>
				Routing Number:
			</strong>

			<?php echo $recipient->active_account->routing_number; ?>
		</p>

		<p>
			<strong>
				Bank Name:
			</strong>

			<?php echo $recipient->active_account->bank_name; ?>
		</p>


	</div>
</div>

<form method="post" action="<?php echo $app->request->getPath(); ?>">

	<input type="hidden" name="deletebankinfo[status]" value="delete"  />
	<input type="hidden" name="deletebankinfo[target]" value="deletebankinfo"  />
	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

	<button type="button" class="confirm-submit btn red">Delete Bank Info</button>

</form>


<?php endif; ?>
