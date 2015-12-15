<?php
	$message = '<p>Please verify your account by supplying your phone number. You must be able to receive SMS text messages for this to work.</p>';
	$message.='<p>If you can\'t receive text messages, you can verify your account by using a <a href="/payment/credit-card">credit card</a>.</p>';
?>

<?php if(isset($app->phonevalidation->active)): ?>
	<p>Thank you for verifying your account, you can now send and receive messsages from tutors and students.</p>
	<p>If you have any questions of comments please visit our <a href="/help">Help</a> page.</p>
<?php elseif(isset($app->phonevalidation->id)): ?>
	<div class="row">
		<div class="col s12 m6 l6">
			<?php echo $message; ?>
		</div>
		<div class="col s12 m6 l6">

			<p>Please enter the SMS code you recieved on your phone</p>

			<form method="post" class="form-post block" action="<?php echo $app->request->getPath(); ?>" id="validatephonewithcode">

				<div class="input-field">
					<input id="code" type="tel" name="igotmycode[code]" class="validate" value="">
					<label for="code">
						SMS Code
					</label>
				</div>

				<input type="hidden" name="igotmycode[target]" value="igotmycode"  />
				<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

				<div class="form-submit">
					<button class="btn blue" type="submit">
						Submit
					</button>
				</div>

			</form>
		</div>
	</div>
<?php else: ?>
	<div class="row">
		<div class="col s12 m6 l6">
			<?php echo $message; ?>
		</div>
		<div class="col s12 m6 l6">

			<p>Enter your phone number and get an SMS code for validation.</p>

			<form method="post" class="form-post block" action="<?php echo $app->request->getPath(); ?>" id="validatephone">

				<div class="input-field">
					<input id="phone" type="tel" name="validatephone[number]" class="validate" value="<?php echo $app->user->phone; ?>">
					<label for="phone">
						Phone Number
					</label>
				</div>

				<input type="hidden" name="validatephone[target]" value="validatephone"  />
				<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

				<div class="form-submit">
					<button class="btn blue" type="submit">
						Submit
					</button>
				</div>

			</form>
		</div>
	</div>
<?php endif; ?>
