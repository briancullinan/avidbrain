<div class="row">
	<div class="col s12 m3 l3">
        <?php if(isset($app->setupsessionusers)): ?>
			<div class="new-order-list">
				<?php foreach($app->setupsessionusers as $key=> $item): ?>
					<div class="block-list-user <?php if(isset($username) && $username == $item->username){ echo 'active';} ?>">
						<a class="block-list" href="/sessions/setup-new/<?php echo $item->username; ?>">
							<?php echo $item->first_name.' '.$item->last_name; ?>
							<?php if($item->promocode==$app->user->email){ echo '<span class="badge tooltipped" data-position="bottom" data-delay="50" data-tooltip="Referred Student"><i class="fa fa-user"></i></span>';} ?>
							<?php if(isset($item->customer_id)){ echo '<span class="badge tooltipped green" data-position="bottom" data-delay="50" data-tooltip="Credit Card On File"><i class="fa fa-credit-card"></i></span>';} ?>
						</a>
					</div>
				<?php endforeach; ?>
			</div>
		<?php else: ?>
			You have no students
        <?php endif; ?>
	</div>
	<div class="col s12 m9 l9">
		<?php if(isset($app->thestudent)): ?>

			<h3>Setup a tutoring session with <span class="blue-text"><?php echo the_users_name($app->setupsessionwith); ?></span> </h3>
			<?php
				$formvalues = new stdClass();
				if(isset($app->thestudent->previousrate)){
					$formvalues->session_rate = $app->thestudent->previousrate;
				}
				else{
					$formvalues->session_rate = $app->user->hourly_rate;
				}

				$setupsession = new Forms($app->connect);
				$setupsession->formname = 'setupsession';
				$setupsession->url = '/sessions/setup-new/'.$username;
				$setupsession->dependents = $app->dependents;
				$setupsession->csrf_key = $csrf_key;
				$setupsession->csrf_token = $csrf_token;
				$setupsession->formvalues = $formvalues;

				$setupsession->makeform();
			?>

        <?php else: ?>
            Please choose a student from the left
        <?php endif; ?>
	</div>
</div>
