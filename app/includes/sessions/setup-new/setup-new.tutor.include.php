<div class="compose-box">
	<div class="row">
		<div class="col s12 m4 l4">
			<h3>Available Students</h3>
			<div class="confirm-payment hide"></div>
			<?php
				echo 'NEWCOMPOSE-LIST';
				printer($app->alltheusers);
			?>
		</div>
		<div class="col s12 m8 l8">
			<?php if(isset($app->setupsessionwith)): ?>
				<h3>Setup a tutoring session with <span class="blue-text"><?php echo the_users_name($app->setupsessionwith); ?></span> </h3>

				<?php

					$formvalues = new stdClass();
					$formvalues->session_rate = $app->user->hourly_rate;

					$setupsession = new Forms($app->connect);
					$setupsession->formname = 'setupsession';
					$setupsession->url = '/sessions/setup-new/'.$username;
					$setupsession->dependents = $app->dependents;
					$setupsession->csrf_key = $csrf_key;
					$setupsession->csrf_token = $csrf_token;
						$setupsession->formvalues = $formvalues;
					$setupsession->makeform();
				?>

			<?php elseif(isset($username)): ?>
				<div class="alert red white-text">Invalid User</div>
			<?php else: ?>
				<h3>Setup a tutoring session</h3>
				<div>Choose a student from the left to setup a tutoring session</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php include($app->target->base.'what-is-a-whiteboard.php'); ?>
