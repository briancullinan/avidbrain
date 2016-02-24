<?php if(isset($app->user->email) && isset($app->user->creditcardonfile) && isset($app->user->status)): ?>

	<div class="row">
		<div class="col s12 m6 l6">
			All tutors and students must have their profile verified before you can send messages.
		</div>
		<div class="col s12 m6 l6">
			<a href="/request-profile-review" class="btn red">Request Profile Review</a>
		</div>
	</div>
<?php elseif(isset($app->user->needs_bgcheck)): ?>

	<p>AvidBrain Requires that all tutors have a background check before they are allowed to interact with students. You may apply to a job post, but you can't read or reply to the student if they agree to tutoring.</p>

	<a href="/background-check" class="btn green">
		Complete Your Background Check
	</a>

<?php elseif(isset($app->user->email) && isset($app->user->creditcardonfile) && empty($app->user->status) || isset($app->user->validateactive)): ?>
	<?php

		$messagingsystem = new Forms($app->connect);
		$messagingsystem->formname = 'messagingsystem';
		$messagingsystem->url = $app->request->getPath();
		$messagingsystem->csrf_key = $csrf_key;
		$messagingsystem->csrf_token = $csrf_token;
		if(isset($app->sendwhiteboard)){

			$whiteboard = new stdClass();
			$whiteboard->subject = 'Join my Whiteboard Session';
			$whiteboard->message = 'Hi '.short($app->currentuser).' come over to '.SITENAME_PROPPER.' and join my Scheduled Whiteboard Session.'."\n".DOMAIN.'/resources/whiteboard/'.$app->sendwhiteboard->roomid;
			$messagingsystem->formvalues = $whiteboard;
		}

		$messagingsystem->makeform();

	?>
<?php elseif(isset($app->user->email) && empty($app->user->creditcardonfile)): ?>

	<div class="row">
		<div class="col s12 m6 l6">
			<div class="block">
				<div class="title">Credit Card Verification</div>
				<p>Authenticate yourself by entering your credit card. It won't be charged, we just use it to verify your account.</p>
				<?php
					//We required that all student's have a credit card on file before they can send out messages. We don't charge your card, it's only used for Authenticating that you are a student who is looking for tutors.
				?>
				<a href="/payment/credit-card" class="btn blue">Activate via Credit Card</a>
			</div>
		</div>
		<div class="col s12 m6 l6">
			<div class="block">
				<div class="title">Phone Verification</div>
				<p>Enter your phone number and you will get a call with instructions on verifying your account.</p>
				<a href="/payment/phone" class="btn green">Activate via Phone</a>
			</div>
		</div>
	</div>


<?php else: ?>

	<div class="block">
		<div class="row">
			<div class="col s12 m6 l6">
				<p>Found the perfect tutor? Login and start learning.</p>
				<p>Don't have an account? Signup Now, it will only take 5 minutes.</p>
			</div>
			<div class="col s12 m6 l6 right-align">
				<a class="modal-trigger btn blue" href="#loginModule">Please Log In To Message</a>
				<a class="modal-trigger btn green" href="/signup/student">Signup</a>
			</div>
		</div>
	</div>

<?php endif; ?>
