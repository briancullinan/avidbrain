<div class="compose-box">
	<div class="row">
		<div class="col s12 m4 l4">
			<h3>Your Contacts</h3>
			<?php
				echo 'NEWCOMPOSE-LIST';
				printer($app->alltheusers);
			?>
		</div>
		<div class="col s12 m8 l8">
			<?php if(isset($app->composemessage)): ?>
				<h3>Send <?php echo the_users_name($app->composemessage); ?> a message</h3>
				<?php
					$messagingsystem = new Forms($app->connect);
					$messagingsystem->formname = 'messagingsystem';
					$messagingsystem->url = $app->composemessage->url;
					$messagingsystem->dependents = $app->dependents;
					$messagingsystem->csrf_key = $csrf_key;
					$messagingsystem->csrf_token = $csrf_token;
					$messagingsystem->makeform();
				?>
			<?php elseif(isset($username)): ?>
				<div class="alert red white-text">Invalid User</div>
			<?php else: ?>
				<h3>Send A Message</h3>
				<div>Choose a user from the left to send them a message</div>
			<?php endif; ?>
		</div>
	</div>
</div>
