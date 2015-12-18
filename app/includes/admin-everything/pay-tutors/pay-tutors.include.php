<?php
// if($app->user->email!='david@avidbrain.com'){
// 	notify('Please Wait For Dave');
// }
// $stripeIssues = array(
// 	'dr.thatch.talking@gmail.com'=>array(
// 		'account'=>'acct_16vzFYKAiuA7CLtd',
// 		'birthday'=>array('month'=>9,'day'=>9,'year'=>1967)
// 	),
// 	'hidehi.rosenberg@gmail.com'=>array(
// 		'account'=>'acct_16vzERFRj0DrWOq5',
// 		'birthday'=>array('month'=>11,'day'=>2,'year'=>1975)
// 	),
// 	'mosam@inbox.com'=>array(
// 		'account'=>'acct_16vzBQIAEn4zTliH',
// 		'birthday'=>array('month'=>11,'day'=>11,'year'=>1911)
// 	),
// 	'erica.ryke@gmail.com'=>array(
// 		'account'=>'acct_16vYUuITpNhzet8i',
// 		'birthday'=>array('month'=>1,'day'=>3,'year'=>1989)
// 	),
// 	'whereiskatima@gmail.com'=>array(
// 		'account'=>'acct_16vFmlEYL90jX4on',
// 		'birthday'=>array('month'=>9,'day'=>28,'year'=>1963)
// 	)
// );
// foreach($stripeIssues as $verifyaccount){
// 	//printer($verifyaccount);
// 	$account = \Stripe\Account::retrieve($verifyaccount['account']);
// 	if(is_array($account->verification->fields_needed)){
// 		$account->legal_entity->dob->day = $verifyaccount['birthday']['day'];
// 		$account->legal_entity->dob->month = $verifyaccount['birthday']['month'];
// 		$account->legal_entity->dob->year = $verifyaccount['birthday']['year'];
// 		$account->tos_acceptance->date = time();
// 		$account->tos_acceptance->ip = $_SERVER['REMOTE_ADDR'];
// 		$account->save();
// 	}
//
// }

	#$sql = "SELECT * FROM avid___user WHERE managed_id IS NOT NULL";
	#$prepare = array();
	#$results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
	#notify($results);

	// $robin = 'acct_16ySpHAEITngTKg6';
	// $account = \Stripe\Account::retrieve($robin);
	// function stripeField($stringDots){
	// 	$stringDots = explode('.',$stringDots);
	// 	$return = '';
	// 	foreach($stringDots as $dots){
	// 		$return.='['.$dots.']';
	// 	}
	// 	return $return;
	// }

	//legal_entity.address., legal_entity.., legal_entity.address.postal_code, legal_entity.address.state, legal_entity.ssn_last_4
?>


<div class="row">
	<div class="col s12 m3 l3">

		<?php if(isset($app->tutorswithsessions)): ?>
			<div>Tutors Who Need Paid</div>
			<div class="block block-list">
				<?php $total = array(); ?>
				<?php foreach($app->tutorswithsessions as $tutorswithsessions): ?>
					<a class="<?php if(isset($id) && $id==$tutorswithsessions->id){ echo 'active';} ?>" href="/admin-everything/pay-tutors/<?php echo $tutorswithsessions->id; ?>">
						<?php echo $tutorswithsessions->first_name.' '.$tutorswithsessions->last_name; ?>:
						<span class="green-text">$<?php echo numbers(($tutorswithsessions->cost/100)); ?></span>
						<?php
							$total[] = $tutorswithsessions->cost;
						?>
					</a>
				<?php endforeach; ?>
			</div>

			<div>Total Ammount Due</div>
			<div class="block green white-text">
				$<?php echo numbers((array_sum($total)/100)); ?>
			</div>

			<div>Available Balance</div>
			<div class="block red white-text">
				$<?php echo $app->availableBalance; ?>
			</div>
		<?php else: ?>
			There are no tutors who need paid
		<?php endif; ?>
	</div>
	<div class="col s12 m9 l9">
		<?php if(isset($id)): ?>

			<h1><?php echo $app->paytutor->first_name.' '.$app->paytutor->last_name; ?></h1>
			<div><a href="<?php echo $app->paytutor->url; ?>" target="_blank">View User</a></div>

			<?php
				$totalgross = array();
				$totalpay = array();
			?>
			<table class="bordered striped hoverable responsive-table">
				<tr class="blue white-text">
					<td>
						Rate
					</td>
					<td>
						Length
					</td>
					<td>
						Status
					</td>
					<td>
						Pay Rate
					</td>
					<td>
						Money Made
					</td>
					<td>
						Cost
					</td>
					<td>
						Subject
					</td>
					<td>
						Date
					</td>
				</tr>
				<?php $finaltotalpay = 0; ?>
				<?php foreach($app->paytutor->sessions as $sessionpay): ?>
				<?php
					#printer($sessionpay);
					if(empty($sessionpay->payrate)){
						$sessionpay->payrate = 70;
					}
					$totalgross[] = $sessionpay->session_cost;
					$totalpay[] = ($sessionpay->session_cost - ($sessionpay->session_cost * ('.'.$sessionpay->payrate)));

				?>
				<tr>
					<td>
						$<?php echo $sessionpay->session_rate; ?>
					</td>
					<td>
						<?php echo $sessionpay->session_length; if(isset($sessionpay->session_length)){ echo ' Minutes ';} ?>
					</td>
					<td>
						<?php echo $sessionpay->session_status; ?>
					</td>
					<td>
						<?php echo $sessionpay->payrate; if(!empty($sessionpay->payrate)){ echo '%';} ?>
					</td>
					<td>
						<?php
						    if(isset($sessionpay->taxes)){
						        $taxremoval = (((stripe_transaction($sessionpay->session_cost)) - $sessionpay->session_cost)/100);
						        $totalCost = $sessionpay->session_cost/100;
						        $final = ceil($totalCost - $taxremoval);
						        $finalPercent = (($final * $sessionpay->payrate)/100);
						    }
						    else{
						        $finalPercent = (($sessionpay->amount * $sessionpay->payrate)/10000);
						    }
							$finaltotalpay = ($finaltotalpay + $finalPercent);
						?>

						$<?php echo numbers($finalPercent); ?>
					</td>
					<td>
						$<?php echo ($sessionpay->session_cost/100); ?>
					</td>
					<td>
						<?php echo $sessionpay->session_subject; ?>
					</td>
					<td>
						<?php echo formatdate($sessionpay->session_timestamp); ?>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php $additional = NULL; ?>
				<?php if(empty($app->bgcheckrefund)): ?>
				<tr class="green white-text">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>$30</td>
					<td>Background Check</td>
					<td><?php echo formatdate(thedate()); ?></td>
				</tr>
				<?php
					$additional = 30;
					#$totalgross[] = 3000;
					#$totalpay[0] = $totalpay[0] - 3000;
				?>
				<?php endif; ?>
			</table>

			<?php

				$total = (array_sum($totalgross) / 100);
				$totalpayout = (array_sum($totalpay) / 100);
			?>
			<p></p>
			<div class="row">
				<div class="col s12 m4 l4">
					<div class="alert grey white-text">
						Total Gross: $<?php echo numbers($total); ?>
					</div>
				</div>
				<div class="col s12 m4 l4">
					<div class="alert blue white-text">
						Total Net: $<?php echo $finaltotalpay; ?>
					</div>
				</div>
				<div class="col s12 m4 l4">
					<div class="alert green white-text">
						AvidBrain Profit: $<?php echo ($total-$finaltotalpay) ?>
					</div>
				</div>
			</div>

			<?php ?>

			<?php if($app->paytutor->getpaid=='check'): ?>

				<div>Pay VIA Check</div>
				<div class="block">
					<div class="title">Make Check Out To:</div>
					<div class="row">
					<?php
						if(isset($app->paytutor->check)){
							foreach($app->paytutor->check as $key => $value):
								echo '<div class="col s12 m4 l4">'.ucwords(str_replace('_',' ',$key)).':</div>';
								echo '<div class="col s12 m8 l8">'.$app->crypter->decrypt($value).' &nbsp; </div>';
								//echo ucwords(str_replace('_',' ',$key)).': '.$app->crypter->decrypt($value).'<br>';
							endforeach;
						}
					?>
					</div>

				</div>

				<form method="post" action="<?php echo $app->request->getPath(); ?>">

					<?php foreach($app->paytutor->sessions as $sessionpay): ?>
						<input type="hidden" name="paytutorcheck[sessionid][<?php echo $sessionpay->id; ?>]" value="1" />
					<?php endforeach; ?>

					<?php if(isset($additional)): ?>
						<input type="hidden" name="paytutorcheck[paybgcheck]" value="1" />
					<?php endif; ?>

					<input type="hidden" name="paytutorcheck[type]" value="check" />
					<input type="hidden" name="paytutorcheck[email]" value="<?php echo $app->paytutor->email; ?>" />
					<input type="hidden" name="paytutorcheck[amount]" value="<?php echo $finaltotalpay;  ?>" />

					<input type="hidden" name="paytutorcheck[target]" value="paytutorcheck"  />
					<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

					<button type="button" class="btn blue confirm-submit">
						Pay $<?php echo $finaltotalpay; ?> via Snail Mail <i class="fa fa-envelope"></i>
					</button>

				</form>

			<?php elseif($app->paytutor->getpaid=='directdeposit' && isset($app->paytutor->account_id)): ?>

				<form method="post" action="<?php echo $app->request->getPath(); ?>">


					<?php foreach($app->paytutor->sessions as $sessionpay): ?>
						<input type="hidden" name="paytutorsessioninfo[sessionid][<?php echo $sessionpay->id; ?>]" value="1" />
					<?php endforeach; ?>

					<?php if(isset($additional)): ?>
						<input type="hidden" name="paytutorsessioninfo[paybgcheck]" value="1" />
					<?php endif; ?>

					<input type="hidden" name="paytutorsessioninfo[type]" value="directdeposit" />
					<input type="hidden" name="paytutorsessioninfo[email]" value="<?php echo $app->paytutor->email; ?>" />
					<input type="hidden" name="paytutorsessioninfo[account_id]" value="<?php echo $app->paytutor->account_id; ?>" />
					<input type="hidden" name="paytutorsessioninfo[amount]" value="<?php echo ($finaltotalpay*100); ?>" />

					<input type="hidden" name="paytutorsessioninfo[target]" value="paytutorsessioninfo"  />
					<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">


					<button type="button" class="btn green confirm-submit">
						Pay $<?php echo $finaltotalpay; ?> via Direct Deposit
					</button>

				</form>

			<?php else: ?>
				No Payment on File
			<?php endif; ?>
		<?php else: ?>
			Please select a tutor from the left
		<?php endif; ?>
	</div>
</div>
