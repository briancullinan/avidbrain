<p>We offer two methods of payment for our users. You can either get paid via direct deposit or we can mail you a check.</p>

<div class="row">
	<div class="col s12 m6 l6">
		
		<div class="radio-clicks">
			<?php
			
				$getpaidme = new stdClass();
				$getpaidme->getpaid = $app->user->getpaid;
				
				$getpaid = new Forms($app->connect);
				$getpaid->formname = 'getpaid';
				$getpaid->url = '/payment/get-paid';
				$getpaid->dependents = $app->dependents;
				$getpaid->csrf_key = $csrf_key;
				$getpaid->csrf_token = $csrf_token;
				$getpaid->formvalues = $getpaidme;
				$getpaid->makeform();
			?>
		</div>
		
		<div class="hr"></div>
		<?php if(isset($app->user->getpaid) && $app->user->getpaid=='directdeposit'): ?>
			<div class="padd padd5 green white-text center-align">
				You have selected Direct Deposit
			</div>
		<?php elseif(isset($app->user->getpaid) && $app->user->getpaid=='check'): ?>
			<div class="padd padd5 blue white-text center-align">
				You have selected Check
			</div>
		<?php endif; ?>
		
		
	</div>
	<div class="col s12 m6 l6">
		<?php if(isset($app->user->getpaid) && $app->user->getpaid=='directdeposit'): ?>
			<?php
				if(empty($app->user->account_id)){
					include('stripe-add-account.php');
				}else{
					include('stripe-update-account.php');
				}
			?>
		<?php elseif(isset($app->user->getpaid) && $app->user->getpaid=='check'): ?>
			<h2>Mailing Address</h2>
			<p>Please enter your mailing address, so we can send you bi-monthly checks.</p>
			<?php
				
				$getpaid = new Forms($app->connect);
				$getpaid->formname = 'cutchecks';
				$getpaid->url = '/payment/get-paid';
				$getpaid->dependents = $app->dependents;
				$getpaid->csrf_key = $csrf_key;
				$getpaid->csrf_token = $csrf_token;
				$getpaid->formvalues = $getpaidme;
				if(isset($app->cutchecksinfo)){
					$getpaid->formvalues = $app->cutchecksinfo;
				}
				$getpaid->makeform();
			?>
		<?php endif; ?>
	</div>
</div>