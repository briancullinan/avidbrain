<div class="row">
	<div class="col s12 m12 l6">
		<p>Need more help? Fill out our contact us form and we will get back to as soon as possible.</p>

		<?php //<p>Need immediate help? <br> Call us Monday - Friday 8am - 6pm at <a href="tel:1-800-485-3138">1-800-485-3138</a></p> ?>


		<?php
			$variablename = new Forms($app->connect);
			$variablename->formname = 'contactus';
			$variablename->url = $app->request->getPath();
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
	<div class="col s12 m6 l6">

	</div>
</div>
