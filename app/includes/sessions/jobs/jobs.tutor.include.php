<?php if(isset($app->jobsessions[0])): ?>

	<?php foreach($app->jobsessions as $jobsessions): //printer($jobsessions,1);  ?>
		<div class="block message-blocks">
			<div class="in-box">
				<div class="row">
					<div class="col s12 m2 l2">

						<?php
						    $results = NULL;
						    $fromuser = $jobsessions->to_user;
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

					</div>
					<div class="col s12 m10 l10">
						<div class="message-subject">
							<?php echo $jobsessions->session_subject; ?>
						</div>
						<div class="hr"></div>
						<div class="message-message">
							<p><?php echo the_users_name($jobsessions); ?> has agreed to a tutoring session with you, now you just need to set it up.</p>
							<p><a href="/jobs/apply/<?php echo $jobsessions->jobid; ?>">View Job Posting</a></p>
						</div>
						<div>
							<?php if(isset($app->user->needs_bgcheck)): ?>
								Please complete your <a href="/background-check" class="green-text">background check</a>, to setup a session with <?php echo short($results); ?>
							<?php else: ?>
								<a class="btn blue" href="/sessions/setup/<?php echo $jobsessions->id; ?>">Setup Tutoring Session</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
	<?php echo $app->pagination; ?>
<?php else: ?>
	You have no job sessions to setup, <a href="/jobs">find another job</a>
<?php endif; ?>
