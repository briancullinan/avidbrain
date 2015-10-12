<div class="row">
	<div class="col s12 m6 l6">
		<?php

			$studentSignup = new Forms($app->connect);
			$studentSignup->formname = 'signup';
			$studentSignup->url = $app->request->getPath();
			$studentSignup->dependents = $app->dependents;
			$studentSignup->csrf_key = $csrf_key;
			$studentSignup->csrf_token = $csrf_token;
			$studentSignup->formvalues = $app->activateprofile;
			$studentSignup->makeform();

		?>
	</div>
	<div class="col s12 m6 l6">
		<div>Almost there, just a couple things left before you can sign into your account.</div>
		

	</div>
</div>
