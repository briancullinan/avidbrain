<div class="row">
	<div class="col s12 m6 l6">
		<p>Need more help? Find a bug? Fill out our contact us form and we will get back to as soon as possible.</p>

		<p>Need immediate help? <br> Call us Monday - Friday 8am - 6pm at <a href="tel:1-800-485-3138">1-800-485-3138</a></p>

	</div>
	<div class="col s12 m6 l6">
		<?php
			$variablename = new Forms($app->connect);
			$variablename->formname = 'contactus';
			$variablename->url = $app->request->getPath();
			$variablename->dependents = $app->dependents;
			if(isset($app->user->email)){
				$myemail = new stdClass();
				$myemail->name = short($app->user);
				$myemail->email = $app->user->email;
				$variablename->formvalues = $myemail;
			}
			$variablename->csrf_key = $csrf_key;
			$variablename->csrf_token = $csrf_token;
			$variablename->makeform();
		?>
	</div>
</div>
