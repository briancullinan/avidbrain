<div class="compose-box">
	<div class="row">
		<div class="col s12 m4 l4">
			<h3>Your Contacts</h3>
			<div class="compose-list center-align white">
				<?php if(count($app->alltheusers)>0): ?>
				<?php foreach($app->alltheusers as $compose): ?>
					<div class="compose-item <?php if(isset($username) && $compose->username==$username){ echo 'active'; } ?>" id="/messages/compose/<?php echo $compose->username; ?>">
						<div class="row">
							<div class="col s12 m3 l3">
								<div class="avatar">
									<?php echo show_avatar($compose,$user=$app->user,$app->dependents); ?>
								</div>
							</div>
							<div class="col s12 m9 l9">
								<div class="user-name">
									<?php echo the_users_name($compose); ?>
								</div>
								<?php
									if(empty($compose->promocode) && $compose->usertype=='student'){
										echo '<div class="badge grey white-text">Student</div>';
									}
									elseif(isset($compose->promocode) && $compose->usertype=='student'){
										echo '<div class="badge blue white-text">Your Student</div>';
									}
									elseif($compose->usertype=='tutor'){
										echo '<div class="badge light-green accent-4 white-text">Tutor</div>';
									}								
								?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
				<?php else: ?>
					You have no contacts
				<?php endif; ?>
			</div>
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