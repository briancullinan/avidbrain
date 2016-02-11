<div class="row">
	<div class="col s12 m4 l4">


		<?php
		    $results = NULL;
		    $fromuser = $app->viewsession->to_user;
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

			<?php if($app->viewsession->session_status=='canceled-session'): ?>
				<div class="alert red white-text">Canceled Session</div>
			<?php elseif(isset($app->viewsession->dispute_response)): ?>

				<!-- Nothing Here But Code -->

			<?php elseif(isset($app->viewsession->contest_dispute)): ?>
				<div class="alert blue white-text">You have contested a dispute, we will contact you shortly to try and resolve the issue.</div>
			<?php elseif(isset($app->viewsession->dispute)): ?>
				<p><?php echo short($app->viewsession); ?> has disputed your last tutoring session.</p>

				<p>You can do the following to remedy the situation:</p>

				<button class="btn btn-block waves-effect blue data-unlock" data-target="#refunds">
					Refund <?php echo short($app->viewsession); ?>
				</button>

				<button class="btn btn-block waves-effect red data-unlock" data-target="#contestdispute">
					Contest Dispute
				</button>
			<?php else: ?>
				<!-- <?php echo SITENAME_PROPPER; ?> -->
			<?php endif; ?>
		</div>

	</div>
	<div class="col s12 m8 l8">
		<h2>Session Details</h2>

		<?php
			$showsession = $app->viewsession;
			include($app->target->base.'show-session.php');
		?>

		<div class="data-unlock-group">
			<div class="unlock-block block" id="refunds">
				<form class="form-post" method="post" id="refundme" action="<?php echo $app->request->getPath(); ?>">

					<?php
						$cost = ($app->viewsession->session_cost/100);
						$range = range(1,floor($cost));
					?>

					<div class="row">
						<div class="col s12 m6 l6">
							How much would you like to refund <?php echo short($app->viewsession); ?>? <br>
							You can refund <span class="notice blue white-text">$1 or $<?php echo numbers($cost); ?></span>, it's up to you. If your student still has problems with the session cost, <?php echo SITENAME_PROPPER; ?> will have to mediate the situation.
						</div>
						<div class="col s12 m6 l6">
							<p>
								<label for="refund_amount">Select Refund Amount</label>
								<select id="refund_amount" name="refundme[amount]" class="browser-default">
									<?php foreach($range as $refund): ?>
									<option value="<?php echo $refund; ?>">
										$<?php echo $refund; ?>
									</option>
									<?php endforeach; ?>
									<option value="<?php echo numbers($cost); ?>">
										$<?php echo numbers($cost); ?>
									</option>
								</select>
							</p>
							<p>
								<label for="dispute_response">Dispute Response</label>
								<textarea class="materialize-textarea" name="refundme[dispute_response]" id="dispute_response"></textarea>
							</p>
						</div>
					</div>

					<input type="hidden" name="refundme[target]" value="refundme"  />
					<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

					<br>
					<div class="form-submit">
						<button class="btn " type="submit">
							Submit
						</button>
					</div>

				</form>

			</div>
			<div class="unlock-block" id="contestdispute">

				<p>If you think you charged the correct amount, or there is another issue, please contact us and we will mediate...</p>

				<?php
					$sessionreviews = new Forms($app->connect);
					$sessionreviews->formname = 'contactus';
					$sessionreviews->url = $app->request->getPath();
					$sessionreviews->csrf_key = $csrf_key;
					$sessionreviews->csrf_token = $csrf_token;

					$myinfo = new stdClass();
					$myinfo->name = the_users_name($app->user);
					$myinfo->email = $app->user->email;
					$myinfo->message = 'I would like to contest a dispute for my tutoring session with '.the_users_name($app->viewsession).'. '."\n".'Please help me out.';

					$sessionreviews->formvalues = $myinfo;
					$sessionreviews->makeform();
				?>

			</div>
		</div>

	</div>
</div>
