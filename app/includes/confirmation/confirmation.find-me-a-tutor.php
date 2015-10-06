<div class="row">
	<div class="col s12 m6 l6">
		<p>Welcome to <?php echo $app->dependents->SITE_NAME_PROPPER; ?>, the largest tutoring marketplace of interviewed and background checked tutors! We have created a new account to help you communicate with potential tutors and schedule tutoring lessons.</p>
		<p>Please be sure to check your email to authenticate your account.</p>
		<p>If you have not received an email, you can have it resent. </p>
		<p>You may also want to check your spam folder.</p>
	</div>
	<div class="col s12 m6 l6">
		<h2>Resend Email</h2>
		<?php
			$resetpass = new Forms($app->connect);
			$resetpass->formname = 'resetpassword';
			$resetpass->url = '/confirmation/student-signup';
			$resetpass->dependents = $app->dependents;
			$resetpass->csrf_key = $csrf_key;
			$resetpass->csrf_token = $csrf_token;
			$resetpass->makeform();
		?>
	</div>
</div>
