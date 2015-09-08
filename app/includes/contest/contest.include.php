<div class="row">
	<div class="col s12 m7 l6">
		
		<h3>Win one of 3 iPad Minis</h3>
		
		<p>Just signup, create a profile and post a job.</p>
		
		<?php

			$studentSignup = new Forms($app->connect);
			$studentSignup->formname = 'signup';
			$studentSignup->url = '/signup/student';
			$studentSignup->dependents = $app->dependents;
			$studentSignup->csrf_key = $csrf_key;
			$studentSignup->csrf_token = $csrf_token;
			if(isset($promocode)){

				$mycode = new stdClass();
				$mycode->promocode = $promocode;
				$studentSignup->formvalues = $mycode;

			}
			$studentSignup->makeform();

		?>
		
	</div>
	<div class="col s12 m5 l5">
		<h3>Free iPad Mini 3</h3>
		<img src="/images/contest/ipad-giveaway.png" class="responsive-img" />
	</div>
</div>