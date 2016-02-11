<div class="row">
	<div class="col s12 m6 l6">
        <?php
            $thelogin = new Forms($app->connect);
            $thelogin->formname = 'login';
            $thelogin->url = '/login/affiliates';
            $thelogin->csrf_key = $csrf_key;
            $thelogin->csrf_token = $csrf_token;
            $thelogin->button = 'Login';
            $thelogin->makeform();
        ?>

	</div>
	<div class="col s12 m6 l6">
		<p>Don't have an affiliate account? Signup now, it's fast and it's easy.</p>

        <a class="btn blue" href="/signup/affiliate">Affiliate Signup</a>

	</div>
</div>
