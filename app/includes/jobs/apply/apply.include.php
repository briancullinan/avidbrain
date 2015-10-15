<div class="row apply-to-job">
	<div class="col s12 m8 l8">
		<h1> <?php echo $app->job->subject_name; ?> Student </h1>
		<div class="row row-fix">
			<div class="col s12 m8 l8">
				<h2><?php echo $app->job->city; ?>, <?php echo $app->job->state; ?></h2>
			</div>
			<div class="col s12 m4 l4 right-align">
				<span class="date"><?php echo formatdate($app->job->date, 'M. jS, Y @ g:i a'); ?></span>
			</div>
		</div>
		<div class="block block-inside jobs-block">

			<div class="description">
				<?php echo nl2br($app->job->job_description); ?>
			</div>

			<div class="block-bottom">
				<div class="row">
					<div class="col s12 m6 l6">
							<?php if(isset($app->job->type)): ?>
							<div>
								I'm looking for <strong><?php echo strtolower(online_tutor($app->job->type)); ?></strong> tutoring
							</div>
							<?php endif; ?>

							<?php if(isset($app->job->skill_level)): ?>
							<div>
								My Skill Level: <?php echo $app->job->skill_level; ?>
							</div>
							<?php endif; ?>

							<?php if(isset($app->job->price_range_low)): ?>
							<div>
								My Price Range: <strong class="green-text">$<?php echo $app->job->price_range_low; ?> - $<?php echo $app->job->price_range_high; ?></strong>
							</div>
							<?php endif; ?>

							<div>
								Posted by ~
								<?php if(isset($app->user->email)): ?>
								<a href="<?php echo $app->job->url; ?>">
									<?php echo the_users_name($app->job); ?>
								</a>
								<?php else: ?>
									<?php echo the_users_name($app->job); ?>
								<?php endif; ?>
							</div>
					</div>
					<div class="col s12 m6 l6">

						<?php if(isset($app->job->applicants)): ?>
							<div><span class="notice blue white-text"><?php echo $app->job->applicants; ?></span> Tutor<?php if($app->job->applicants!=1){ echo 's have';}else{ echo ' has ';} ?>  applied for this job</div>
						<?php endif; ?>
						<div class="view-more-jobs">
						<?php if(isset($app->job->subject_slug)): ?>

								<div>
									<a href="/jobs/<?php echo $app->job->parent_slug; ?>">
										<?php echo fix_parent_slug($app->job->parent_slug); ?> Jobs
									</a>
								</div>
								<div>
									<a href="/jobs/<?php echo $app->job->subject_slug; ?>">
										<?php echo $app->job->subject_name; ?> Jobs
									</a>
								</div>

						<?php endif; ?>

						<?php if(isset($app->job->state_slug)): ?>
							<div>
								<a href="/jobs/location/<?php echo $app->job->state_slug; ?>">
									<?php echo $app->job->state_long; ?> Jobs
								</a>
							</div>
							<div>
								<a href="/jobs/location/<?php echo $app->job->state_slug; ?>/<?php echo $app->job->city_slug; ?>">
									<?php echo $app->job->city; ?> Jobs
								</a>
							</div>
						<?php endif; ?>

						</div>
						&nbsp;

					</div>
				</div>
			</div>

		</div>
	</div>
	<div class="col s12 m4 l4 jobs-page-right">
		<?php if(isset($app->job->myapplication)): ?>
			<h3>Thank you for applying</h3>
		<?php elseif(empty($app->job->open)): ?>
			<h3>
				Job Post Closed
			</h3>
		<?php else: ?>
			<h3>Apply For Job</h3>
		<?php endif; ?>

		<div class="block">

			<?php if(empty($app->job->open)): ?>
				<?php echo the_users_name($app->job); ?> has found an <?php echo $app->job->subject_name; ?> tutor.
			<?php elseif(isset($app->user->status)): ?>
				<div>You must have your profile approved before you can apply to this job.</div>
				<pview-user.tutor.post.php><a class="btn red white-text" href="/request-profile-review">Request Profile Review</a></p>
			<?php elseif(isset($app->user->usertype) && $app->user->usertype=='tutor'): ?>

				<?php if(isset($app->job->myapplication)): ?>

					<div class="title">Your Message:</div>
					<div class="description">
						<?php echo $app->job->myapplication->message; ?>
					</div>

				<?php else: ?>
					<form method="post" class="form-post" action="<?php echo $app->request->getPath(); ?>">

						<div class="input-field">
							<textarea id="applicationmessage" name="application[message]" class="materialize-textarea" placeholder="Explain why you would be the perfect candidate to teach  <?php echo $app->job->subject_name; ?> to <?php echo the_users_name($app->job); ?> "></textarea>
							<label for="applicationmessage">Message</label>
						</div>

						<input type="hidden" name="application[target]" value="application"  />
						<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

						<p></p>
						<div class="form-submit">
							<button class="btn" type="submit">
								Apply To Job
							</button>
						</div>

					</form>
				<?php endif; ?>

			<?php elseif(isset($app->user->email) && $app->user->email == $app->job->email): ?>
				<a class="btn btn-block blue" href="/jobs/manage/<?php echo $app->job->id; ?>">Manage Job Posting</a>
			<?php elseif(isset($app->user->usertype) && $app->user->usertype!='tutor'): ?>
				Only tutors can apply to jobs.
			<?php else: ?>
				<a class="modal-trigger modal-login btn blue btn-block" href="#loginModule">  Please Login To Apply</a>
			<?php endif; ?>

		</div>
	</div>
</div>
