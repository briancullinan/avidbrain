<div class="row">
	<div class="col s12 m4 l4">
		<?php $userinfo = $app->markcomplete; include($app->dependents->APP_PATH."includes/user-profile/user-block.php"); ?>

		<div class="confirm-payment hide"></div>

	</div>
	<div class="col s12 m8 l8">
		<h2>Session Details</h2>

		<?php if($app->markcomplete->session_status=='complete'): ?>
			<div class="block">
				Your session is complete
			</div>
		<?php else: ?>

		<div class="block active-block">

			<div>Now that your session is complete, you just need to confirm the charge below.</div>
		</div>

		<?php

			$app->markcomplete->session_length = $app->markcomplete->proposed_length;

			$setupsession = new Forms($app->connect);
			$setupsession->formname = 'completesession';
			$setupsession->url = '/sessions/complete-active/'.$id;
			$setupsession->dependents = $app->dependents;
			$setupsession->csrf_key = $csrf_key;
			$setupsession->csrf_token = $csrf_token;
				$setupsession->formvalues = $app->markcomplete;
			$setupsession->makeform();
		?>
		<?php endif; ?>
	</div>
</div>

<?php include($app->target->base.'what-is-a-whiteboard.php'); ?>
