<h1>Add/Edit Credit Card</h1>


<?php if(isset($app->user->creditcard)): ?>
	
	<div class="row">
		<div class="col s12 m6 l6">
			<?php include('credit-safety.php'); ?>
		</div>
		<div class="col s12 m6 l6">
			
			<?php if(isset($doihaveerrors->id)): ?>
				<h2>Payment Errors</h2>
				<div class="block">
					<p><?php echo $doihaveerrors->message; ?></p>
					<p>Please delete your current card from the system and add a current & active credit card.</p>
					<p>If you don't fix this issue within <span class="red-text">7 Days</span> your profile will be locked, and if you owe a tutor any amount of money you will be sent to collections.</p>
					
				</div>
			<?php endif; ?>
			
			<h2>Your Credit Card Info</h2>
			<ul class="collection">
				<li class="collection-item">
					<div class="row">
						<div class="col s6 m6 l6">
							Type
						</div>
						<div class="col s6 m6 l6 right-align">
							<i class="fa fa-<?php echo ccbrand($app->user->creditcard->brand); ?>"></i> <?php echo $app->user->creditcard->brand; ?>
						</div>
					</div>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s6 m6 l6">
							Number
						</div>
						<div class="col s6 m6 l6 right-align">
							**** <?php echo $app->user->creditcard->last4; ?>
						</div>
					</div>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s6 m6 l6">
							Expiration
						</div>
						<div class="col s6 m6 l6 right-align">
							<?php echo $app->user->creditcard->exp_month; ?> / <?php echo $app->user->creditcard->exp_year; ?>
						</div>
					</div>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s6 m6 l6">
							Country
						</div>
						<div class="col s6 m6 l6 right-align">
							<?php echo $app->user->creditcard->country; ?>
						</div>
					</div>
				</li>
			</ul>
			<div class="hr"></div>
			<div>
				<a class="btn red confirm-click" href="#" data-target="/payment/credit-card/deletecard">Delete Card</a>
				<?php //<a class="btn green" id="updatecard" href="#updatecard">Update Card</a> ?>
			</div>
			

				<form class="hide" id="updatecreditcard" action="" method="POST">
					<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
					<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
						data-email = "<?php echo $app->user->email; ?>"
						data-key = "<?php echo $app->dependents->stripe->STRIPE_PUBLIC; ?>"
						data-amount = "00"
						data-panel-label = "Update Credit Card"
						data-label = "Update Credit Card"
						data-name = "<?php echo $app->dependents->SITE_NAME_PROPPER; ?> Authorization"
						data-description = "Update Credit Card"
						data-allow-remember-me = "false"
					></script>
				</form>
			
			
		</div>
	</div>
	
<?php else: ?>

	<div class="row">
		<div class="col s12 m6 l6">
			<?php include('credit-safety.php'); ?>
		</div>
		<div class="col s12 m6 l6">
			
			<h2>Authorize A Credit Card</h2>
			<div class="block">
				<div>Click the authorize card to add your credit card to the secure online payment system.</div> <br>
				<?php
					$prepaiderror = $app->getCookie('prepaid');
					if($prepaiderror!=NULL){
						echo '<div class="alert red white-text">'.$prepaiderror.'</div>';
					}
				?>
				<form action="" method="post">
					<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
					<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
						data-email = "<?php echo $app->user->email; ?>"
						data-key = "<?php echo $app->dependents->stripe->STRIPE_PUBLIC; ?>"
						data-amount = "00"
						data-panel-label = "Authorize Card"
						data-label = "Authorize Card"
						data-name = "<?php echo $app->dependents->SITE_NAME_PROPPER; ?> Authorization"
						data-description = "Authorize Credit Card"
						data-allow-remember-me = "false"
					></script>
				</form>
			</div>
		</div>
	</div>
	
<?php endif; ?>