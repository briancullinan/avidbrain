<div class="row">
	<div class="col s12 m4 l4">

		<?php
			$results = NULL;
			$fromuser = $app->setup->to_user;
			$sql = "SELECT user.username,user.url,user.first_name,user.last_name,profile.my_avatar,profile.my_upload,profile.my_upload_status FROM avid___user user INNER JOIN avid___user_profile profile on profile.email = user.email WHERE user.email = :email LIMIT 1";
			$prepare = array(':email'=>$fromuser);
			$results = $app->connect->executeQuery($sql,$prepare)->fetch();
		?>

		<?php if(isset($results->username)): ?>
			<div class="user-photograph">
				<a href="<?php echo $results->url; ?>">
					<img src="<?php echo userphotographs($app->user,$results); ?>" />
				</a>
			</div>
			<div class="user-name">
				<a href="<?php echo $results->url; ?>"><?php echo ucwords(short($results)); ?></a>
			</div>
		<?php endif; ?>

		<div class="center-align">
			<?php if(isset($app->setup->dateDiff) && $app->setup->dateDiff->invert==1): ?>
				<div class="hr"></div>
				<p>It looks like your session occurred <br> <span class="notice red white-text"><?php echo $app->setup->dateDiff->text; ?> ago </span> </p>

				<?php

					$sessionCost = ($app->setup->session_rate * ($app->setup->proposed_length/60));

				?>

				<?php if($sessionCost >= MinimumSessionRate): ?>
					<a class="btn blue btn-l btn-block btn-notice" href="/sessions/complete-active/mark-complete/<?php echo $app->setup->id; ?>">
						Click To Complete Session
					</a>
				<?php else: ?>
					<div class="alert purple white-text">
						You session must be at least $<?php echo MinimumSessionRate; ?> to continue. <br> Right now it's estimated at $<?php echo numbers($sessionCost); ?>
					</div>
				<?php endif; ?>

				<?php if(!empty($app->setup->roomid)): ?>
				<a href="/resources/whiteboard/<?php echo $app->setup->roomid; ?>" class="btn btn-block">
					View Whiteboard Session
				</a>
				<div class="hr"></div>
				<br>
				<?php endif; ?>

				<?php if(isset($app->user->cancellation_rate) && $app->user->cancellation_rate>0): ?>
				<br>
				<p class="alert orange white-text">If your student didn't show, you can cancel the session and get $<?php echo $app->user->cancellation_rate; ?></p>

				<a href="#" data-target="<?php echo $app->request->getPath(); ?>/cancel" class="confirm-click btn red btn-block" >Cancel Session for $<?php echo $app->user->cancellation_rate; ?></a>


				<?php endif; ?>

			<?php elseif(isset($app->setup->dateDiff->text)): ?>
				<p>Your session will occur in <br> <span class="notice blue white-text"><?php echo $app->setup->dateDiff->text; ?></span></p>

				<?php if(!empty($app->setup->roomid)): ?>
				<a href="/resources/whiteboard/<?php echo $app->setup->roomid; ?>" class="btn btn-block">
					View Whiteboard Session
				</a>
				<div class="hr"></div>
				<br>
				<?php endif; ?>

			<?php endif; ?>
			<?php if(isset($app->setup->session_timestamp)): ?>
			<br>
			<a href="#" data-target="<?php echo $app->request->getPath(); ?>/cancelnocharge" class="confirm-click btn orange btn-block" >Cancel Session with No Charge</a>
			<?php endif; ?>

		</div>

		<div class="confirm-payment hide"></div>

	</div>
	<div class="col s12 m8 l8">
		<h2>Session Details</h2>

		<?php if(isset($app->setup->payment_details) && $app->setup->payment_details=='Credit Card Error'): ?>
			<div class="credit-errors">
				<div><?php echo short($app->setup); ?>'s <span>credit card was declined</span>.</div>
				<div>Please contact let them know, so you can proceed.</div>
			</div>
		<?php endif; ?>

		<?php

			if(!empty($app->setup->roomid)){
				$app->setup->whiteboard = 'yes';
			}
			else{
				$app->setup->whiteboard = 'no';
			}

			$setupsession = new Forms($app->connect);
			$setupsession->formname = 'setupsession';
			$setupsession->url = '/sessions/setup/'.$id;
			$setupsession->csrf_key = $csrf_key;
			$setupsession->csrf_token = $csrf_token;
				$setupsession->formvalues = $app->setup;
			$setupsession->makeform();
		?>
	</div>
</div>

<?php include($app->target->base.'what-is-a-whiteboard.php'); ?>
