<div class="container container-nopadd">

	<h1>Welcome to <?php echo SITENAME_PROPPER; ?></h1>

	<p>Thank you for activating your <?php echo SITENAME_PROPPER; ?> account.</p>

	<div>

		<?php if($app->user->usertype=='student'): ?>
			<a class="btn" href="<?php echo $app->user->url; ?>">
				Let's Activate Your Profile
			</a>
		<?php else: ?>
			<a class="btn" href="<?php echo $app->user->url; ?>">Lets create your Tutor Profile</a>
		<?php endif; ?>

	</div>

</div>
