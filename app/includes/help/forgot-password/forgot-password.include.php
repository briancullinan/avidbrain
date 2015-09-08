<div class="row">
	<div class="col s12 m6 l6">
		<?php
			$resetpass = new Forms($app->connect);
			$resetpass->formname = 'resetpassword';
			$resetpass->url = '/help/forgot-password';
			$resetpass->dependents = $app->dependents;
			$resetpass->csrf_key = $csrf_key;
			$resetpass->csrf_token = $csrf_token;
			$resetpass->makeform();
		?>
	</div>
	<div class="col s12 m6 l6">
		<ul class="collection">
			<li class="collection-item">xxx</li>
		</ul>
	</div>
</div>