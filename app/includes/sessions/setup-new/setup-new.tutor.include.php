<div class="compose-box">
	<div class="row">
		<div class="col s12 m4 l4">
			<h3>Available Students</h3>
			<div class="confirm-payment hide"></div>

			<?php if(isset($app->alltheusers)): ?>
				<div class="new-order-list">
					<?php foreach($app->alltheusers as $key=> $item): ?>
						<div class="block-list-user <?php if(isset($username) && $username == $item->username){ echo 'active';} ?>">
							<a class="block-list" href="/sessions/setup-new/<?php echo $item->username; ?>">
								<?php echo $item->first_name.' '.$item->last_name; ?>
								<?php if($item->promocode==$app->user->email){ echo '<span class="badge tooltipped" data-position="bottom" data-delay="50" data-tooltip="Active Student"><i class="fa fa-user"></i></span>';} ?>
								<?php if(isset($item->customer_id)){ echo '<span class="badge tooltipped green" data-position="bottom" data-delay="50" data-tooltip="Credit Card On File"><i class="fa fa-credit-card"></i></span>';} ?>
							</a>
						</div>
					<?php endforeach; ?>
				</div>
			<?php else: ?>
				You have no students
			<?php endif; ?>

		</div>
		<div class="col s12 m8 l8">
			<?php if(isset($app->setupsessionwith)): ?>
				<h3>Setup a tutoring session with <span class="blue-text"><?php echo the_users_name($app->setupsessionwith); ?></span> </h3>

				<?php
					$formvalues = new stdClass();
					$formvalues->session_rate = $app->user->hourly_rate;

					$setupsession = new Forms($app->connect);
					$setupsession->formname = 'setupsession';
					$setupsession->url = '/sessions/setup-new/'.$username;
					$setupsession->dependents = $app->dependents;
					$setupsession->csrf_key = $csrf_key;
					$setupsession->csrf_token = $csrf_token;
						$setupsession->formvalues = $formvalues;
					$setupsession->makeform();
				?>

			<?php elseif(isset($username)): ?>
				<div class="alert red white-text">Invalid User</div>
			<?php else: ?>
				<h3>Setup a tutoring session</h3>
				<div>Choose a student from the left to setup a tutoring session</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php

	$loadModal = 'what-is-a-whiteboard';

?>
