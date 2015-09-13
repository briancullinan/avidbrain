<div class="row">
	
	<div class="col s12 m6 l6">
		<h2>Need To Login?</h2>
		<?php
			
			$thelogin = new Forms($app->connect);
			$thelogin->formname = 'login';
			$thelogin->url = '/login';
			$thelogin->dependents = $app->dependents;
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
			<li class="collection-item">  <a href="/help/forgot-password">Forgot Your Password?</a></li>
			<li class="collection-item"><a href="/signup">Need To Signup?</a></li>
			<li class="collection-item">xxx</li>
			<li class="collection-item">xxx</li>
			<li class="collection-item">xxx</li>
		</ul>
		
	</div>
	
</div>

<?php if(isset($special_login)): ?>
	<!-- Special Login -->
<?php endif; ?>