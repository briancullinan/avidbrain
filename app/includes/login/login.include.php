<div class="row">

	<div class="col s12 m6 l6">
		<?php

			$thelogin = new Forms($app->connect);
			$thelogin->formname = 'login';
			$thelogin->url = '/login';
			$thelogin->csrf_key = $csrf_key;
			$thelogin->csrf_token = $csrf_token;
			$thelogin->button = 'Login';

			if($validation_email = $app->getCookie('validation_email')){
				$validate = new stdClass();
				$validate->email = $validation_email;
				$thelogin->formvalues = $validate;
			}
			$thelogin->makeform();
		?>
	</div>

	<div class="col s12 m6 l6">
		<h2>Login Help</h2>

		<ul class="collection">
			<li class="collection-item"> <a href="/help/forgot-password">Forgot Your Password?</a></li>
			<li class="collection-item"> <a href="/signup">Create An Account</a></li>
			<li class="collection-item"><a href="/how-it-works">How It Works</a></li>
		</ul>

	</div>

</div>
