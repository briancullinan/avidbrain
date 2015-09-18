<div class="row">
	<div class="col s12 m6 l6">
		<p>You may now change your password. Please enter a new password, then confirm it.</p>
		<p>Please use a strong password, to guarantee your accounts security.</p>
	</div>
	<div class="col s12 m6 l6">
		<?php
	
			$resetpass = new Forms($app->connect);
			$resetpass->formname = 'passwordrecoverycenter';
			$resetpass->url = '/help/forgot-password/recovery/'.$validationcode;
			$resetpass->dependents = $app->dependents;
			$resetpass->csrf_key = $csrf_key;
			$resetpass->csrf_token = $csrf_token;
			$resetpass->makeform();
		?>
	</div>
</div>