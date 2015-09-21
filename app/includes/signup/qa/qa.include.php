<div class="row qa-signup">

	<div class="col s12 m6 l6">
		<?php

			$studentSignup = new Forms($app->connect);
			$studentSignup->formname = 'signup';
			$studentSignup->url = '/signup/student';
			$studentSignup->dependents = $app->dependents;
			$studentSignup->csrf_key = $csrf_key;
			$studentSignup->csrf_token = $csrf_token;
				$mycode = new stdClass();
				$mycode->promocode = 'qa-signup';
				$studentSignup->formvalues = $mycode;
			$studentSignup->makeform();

		?>
	</div>

	<div class="col s12 m6 l6">
		<h2>Get Answers to all your questions</h2>
		<p>Ask a Question and get an answer from a knowledgable tutor.</p>
		<p>Only our tutors can answer questions, so you don't have to worry about getting a wrong answer. </p>
		
	</div>

</div>