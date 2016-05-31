<?php
	$additionalCSS = NULL;
	$additionalText = NULL;
	$additionalButtonCss = NULL;
	if(isset($jobsessions->dispute)){
		$additionalCSS = 'dispute';
		$additionalText = 'Disputed';
		$additionalButtonCss = 'red';
	}
	elseif($app->user->usertype=='student' && empty($jobsessions->review_score) && $jobsessions->session_status=='complete'){
		$additionalCSS = 'needs-review';
		$additionalText = ' / Review ';
	}

	$setupView = 'setup';
	if($jobsessions->session_status=='complete'){
		$setupView = 'view';
	}

	if(isset($jobsessions->session_status) && $jobsessions->session_status=='canceled-session'){
		$additionalCSS = 'canceled-session';
	}
?>
<div class="block message-blocks <?php echo $additionalCSS; ?>">
	<div class="in-box">
		<div class="row">
			<div class="col s12 m2 l2">

				<?php
					$fromuser = NULL;
				    $results = NULL;
				    $fromuser = correct_email($app->user->email,$jobsessions);
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
					<div class="row row-fix">
						<div class="col s12 m6 l6">
							<div class="message-subject">
								<?php echo $jobsessions->session_subject; ?>
							</div>
						</div>
						<div class="col s12 m6 l6 right-align">
							<div class="date">
								<div><?php echo formatdate($jobsessions->session_date); ?></div>
								<div><?php echo $jobsessions->session_time; ?></div>
							</div>
						</div>
					</div>
				<div class="hr"></div>
				<div class="message-message">
					<div class="row row-fix">
						<div class="col s12 m9 l9">
							<div><strong>Session Details</strong></div>

							<?php if(isset($jobsessions->dispute_text)): ?>
								<div><strong>Dispute Reason:</strong> <span class="red-text"><?php echo $jobsessions->dispute_text; ?></span></div>
							<?php endif; ?>

							<div>
								Rate: $<?php echo $jobsessions->session_rate; ?>
							</div>

							<div>
								Location: <?php echo $jobsessions->session_location; ?>
							</div>

							<div>
								Notes: <?php echo $jobsessions->student_notes; ?>
							</div>

							<div>
								<?php
								$totalMinutes = $jobsessions->proposed_length;
								$hours = intval($totalMinutes/60);
								$minutes = $totalMinutes - ($hours * 60);
								$time = '';
								if($hours==1){
									$time.= $hours.' Hour';
								}
								if($hours>1){
									$time.= $hours.' Hours';
								}
								if($hours>0 && $minutes>0){
									$time.= ' &amp; ';
								}
								if($minutes>0){
									$time.= $minutes.' Minutes';
								}
								?>
								Proposed Length: <span class="blue-text"><?php echo $time; ?></span>
							</div>

							<?php if(isset($jobsessions->session_cost)): ?>
							<div>
								Session Cost: $<?php echo  number_format(($jobsessions->session_cost/100), 2, '.', ','); ?>
							</div>
							<?php else: ?>
							<div>
								Estimated Cost: $<?php echo session_cost($jobsessions) ?>
							</div>
							<?php endif; ?>

							<?php if(isset($jobsessions->review_score) && $jobsessions->review_score>0): ?>
							<div>
								Review Score: <span class="orange-text"><?php echo get_stars($jobsessions->review_score)->icons; ?></span>
							</div>
							<?php endif; ?>

						</div>
						<div class="col s12 m3 l3 right-align">

							<?php if($app->user->usertype=='tutor'): ?>
								<p><a class="btn btn-block <?php echo $additionalButtonCss; ?>" href="/sessions/<?php echo $setupView; ?>/<?php echo $jobsessions->id; ?>">View / Edit Session</a></p>
							<?php else: ?>
								<p><a class="btn btn-block <?php echo $additionalButtonCss; ?>" href="/sessions/view/<?php echo $jobsessions->id; ?>">View <?php echo $additionalText; ?> Session</a></p>
							<?php endif; ?>

							<!-- <?php if(!empty($jobsessions->roomid)): ?>
								<a class="btn btn-s" href="/resources/whiteboard/<?php echo $jobsessions->roomid; ?>">View Whiteboard</a>
							<?php endif; ?> -->

							<?php if($jobsessions->session_status=='canceled-session' || $jobsessions->session_status=='complete' || empty($jobsessions->jobid)):else: ?>
							<p><a class="btn btn-s blue" href="/jobs/apply/<?php echo $jobsessions->jobid; ?>">View Job Posting</a></p>
							<?php endif; ?>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
