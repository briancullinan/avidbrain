<div class="row">
	<div class="col s12 m6 l6">

		<div>Did you forget your password? You can reset your password for your MindSpree account by entering your email address.</div>

		<?php
			$resetpass = new Forms($app->connect);
			$resetpass->formname = 'resetpassword';
			$resetpass->url = '/help/forgot-password';
			$resetpass->csrf_key = $csrf_key;
			$resetpass->csrf_token = $csrf_token;
			$resetpass->makeform();
		?>
	</div>

	<div class="col s12 m6 l6">
	</div>

</div>
