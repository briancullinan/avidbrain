<?php if(isset($app->jobsessions[0])): ?>

	<?php foreach($app->jobsessions as $jobsessions): #printer($jobsessions);  ?>
		<div class="block message-blocks">	
			<div class="in-box">
				<div class="row">
					<div class="col s12 m2 l2">
						<?php $userinfo = $jobsessions; include($app->dependents->APP_PATH."includes/user-profile/user-block.php"); ?>
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
							<a class="btn blue" href="/sessions/setup/<?php echo $jobsessions->id; ?>">Setup Tutoring Session</a>
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