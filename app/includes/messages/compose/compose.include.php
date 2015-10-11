<div class="compose-box">
	<div class="row">
		<div class="col s12 m4 l4">
			<h3>Your Contacts</h3>

			<?php if(isset($app->alltheusers)): ?>

				<div class="new-order-list">
					<?php foreach($app->alltheusers as $item): ?>
						<div class="block-list-user">
							<a class="block-list" href="<?php echo $item->url; ?>" target="_blank">
								<?php echo $item->first_name.' '.$item->last_name; ?>
								<?php if($item->promocode==$app->user->email){ echo '<span class="badge tooltipped" data-position="bottom" data-delay="50" data-tooltip="Active Student"><i class="fa fa-user"></i><span>';} ?>
							</a>
						</div>
					<?php endforeach; ?>
				</div>

			<?php else: ?>
				You have no contacts
			<?php endif; ?>


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
