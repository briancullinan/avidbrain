<div class="row">
	<div class="col s12 m6 l6">
		<p>Welcome to <?php echo $app->dependents->SITE_NAME_PROPPER; ?>, the largest tutoring marketplace of interviewed and background checked tutors! We have created a new account to help you communicate with potential tutors and schedule tutoring lessons.</p>

		<p>
			Please call 1-800-485-3138 to setup an interview
		</p>

		<p><a class="btn blue" href="https://signup.avidbrain.com/interview-schedule.html" target="_blank">View our current interview schedule.</a></p>

	</div>
	<div class="col s12 m6 l6">
		<h2>Resend Email</h2>
		<p>If you never recieved an email confirmation, you can have it resent. Just type in your email address.</p>
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
