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

<?php if(isset($app->purechat)): ?>
	<script type='text/javascript' data-cfasync='false'>window.purechatApi = { l: [], t: [], on: function () { this.l.push(arguments); } }; (function () { var done = false; var script = document.createElement('script'); script.async = true; script.type = 'text/javascript'; script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) { if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { var w = new PCWidget({c: 'a450183c-ea47-4537-89d4-f8b55a44e006', f: true }); done = true; } }; })();</script>
<?php endif; ?>
