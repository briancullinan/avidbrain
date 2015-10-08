<?php
	function applied_already($connect,$email,$id){
		$sql = "SELECT id FROM avid___jobs_applicants WHERE email = :email AND jobid = :jobid";
		$prepeare = array(':email'=>$email,':jobid'=>$id);
		return $connect->executeQuery($sql,$prepeare)->rowCount();
	}
?>
<?php if(isset($app->alljobs[0])): ?>
	<?php foreach($app->alljobs as $job): ?>

		<div class="block block-inside jobs-block">

			<div class="title">
				<a href="/jobs/apply/<?php echo $job->id; ?>">
					<strong><?php echo $job->subject_name; ?></strong>
					<span>Student in <?php echo $job->city; ?> <?php echo ucwords($job->state_long); ?>,  <?php echo $job->zipcode; ?></span>
				</a>
				<?php if(isset($job->distance)): ?>
					<div><div class="miles-away blue white-text"><?php echo str_replace('.00','',numbers($job->distance)); ?> Miles Away</div></div>
				<?php endif; ?>
			</div>

			<div class="description">
				<?php echo truncate($job->job_description,350); ?>
			</div>

			<div class="block-bottom">
				<div class="row">
					<div class="col s12 m6 l6">
						<?php if(isset($job->type)): ?>
							<div>
								I'm looking for <strong><?php echo strtolower(online_tutor($job->type)); ?></strong> tutoring
							</div>
							<?php endif; ?>

							<?php if(isset($job->skill_level)): ?>
							<div>
								My Skill Level: <?php echo $job->skill_level; ?>
							</div>
							<?php endif; ?>

							<?php if(isset($job->price_range_low)): ?>
							<div>
								My Price Range: <strong class="green-text">$<?php echo $job->price_range_low; ?> - $<?php echo $job->price_range_high; ?></strong>
							</div>
							<?php endif; ?>

							<div>
								Posted by ~
								<?php if(isset($app->user->email)): ?>
								<a href="<?php echo $job->url; ?>">
									<?php
										if($job->showfullname=='yes'){
											echo $job->first_name.' '.$job->last_name;
										}
										else{
											echo short($job);
										}

									?>
								</a>
								<?php else: ?>
								<?php
									if($job->showfullname=='yes'){
										echo $job->first_name.' '.$job->last_name;
									}
									else{
										echo short($job);
									}

								?>
								<?php endif; ?>

								<span class="date"><?php echo formatdate($job->date, 'M. jS, Y @ g:i a'); ?></span>
							</div>
					</div>
					<div class="col s12 m6 l6">
						<div class="row">
							<div class="col s12 m8 l8">
								<?php if(isset($job->applicants)): ?>
									<div><span class="notice blue white-text"><?php echo $job->applicants; ?></span> Tutor<?php if(count($job->applicants)!=1){ echo 's';} ?> has applied for this job</div>
								<?php endif; ?>
								<div class="view-more-jobs">
								<?php if(isset($job->subject_slug)): ?>
										<div>
											<a href="/jobs/<?php echo $job->parent_slug; ?>">
												<?php echo fix_parent_slug($job->parent_slug); ?> Jobs
											</a>
										</div>
										<div>
											<a href="/jobs/<?php echo $job->subject_slug; ?>">
												<?php echo $job->subject_name; ?> Jobs
											</a>
										</div>

								<?php endif; ?>

									<?php if(isset($job->state_slug)): ?>
									<div>
										<a href="/jobs/location/<?php echo $job->state_slug; ?>">
											<?php echo ucwords($job->state_long); ?> Jobs
										</a>
									</div>
									<div>
										<a href="/jobs/location/<?php echo $job->state_slug; ?>/<?php echo $job->city_slug; ?>">
											<?php echo $job->city; ?> Jobs
										</a>
									</div>
									<?php endif; ?>
								</div>
								&nbsp;
							</div>
							<div class="col s12 m4 l4 right-align">
								<?php if(isset($job->applicants) && isset($app->user->email) && applied_already($app->connect,$app->user->email,$job->id)>0): ?>
									<a href="/jobs/apply/<?php echo $job->id; ?>" class="btn  waves-effect">
										View Application
									</a>
								<?php else: ?>
									<a href="/jobs/apply/<?php echo $job->id; ?>" class="btn blue waves-effect">
										Apply For Job
									</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	<?php endforeach; ?>

	<?php echo $app->pagination; ?>

<?php else: ?>
	There are no jobs available
<?php endif; ?>
