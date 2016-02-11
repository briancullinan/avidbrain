<div class="row">
	<div class="col s12 m6 l6">

		<div>Did you forget your password? You can reset your password for your AvidBrain account by entering your email address.</div>


	</div>
	<div class="col s12 m6 l6">
		<?php
			$resetpass = new Forms($app->connect);
			$resetpass->formname = 'resetpassword';
			$resetpass->url = '/help/forgot-password';
			$resetpass->csrf_token = $csrf_token;
			$resetpass->makeform();
		?>
	</div>
</div>
