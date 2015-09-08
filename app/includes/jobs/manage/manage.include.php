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
			
		</div>
		
		<?php if(empty($app->job->active_applicant_id)): ?>
		<div>
			<h2>Update Your Job</h2>
			<div class="block">
				<form class="form-post" method="post" action="<?php echo $app->request->getPath(); ?>" id="updatejob-<?php echo $app->job->id; ?>">
					
					<div class="input-field">
						<input type="text" name="updatejob[subject_name]" id="findasubject<?php echo $app->job->id; ?>" class="autogenerate--subject" data-name="updatejob" value="<?php echo $app->job->subject_name; ?>" />
						<label for="findasubject">
							Find The Subject You Want To Learn
						</label>
					</div>
				
					<div class="input-field">
						<textarea id="job_description" name="updatejob[job_description]" class="materialize-textarea"><?php echo $app->job->job_description; ?></textarea>
						<label for="job_description">
							Please explain why you need help with this subject
						</label>
					</div>
					
					<div class="row">
						<div class="col s12 m6 l6">
							<div class="input-field">
								<label class="select-label" for="textarea1">
									What type of tutor are you looking for?
								</label>
								<select name="updatejob[type]" class="browser-default">
									<?php foreach($app->jobOptions['type'] as $key => $type): ?>
									<option <?php if($type==$app->job->type){ echo 'selected="selected"';} ?> value="<?php echo $type; ?>"><?php echo $key; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col s12 m6 l6">
							<div class="input-field">
								<label class="select-label" for="textarea1">
									What is your skill level?
								</label>
								<select name="updatejob[skill_level]" class="browser-default">
									<option value="">Select Skill Level</option>
									<?php foreach($app->jobOptions['skill_level'] as  $skill_level): ?>
									<option <?php if($skill_level==$app->job->skill_level){ echo 'selected="selected"';} ?> value="<?php echo $skill_level; ?>"><?php echo $skill_level; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
					
					<input class="suggest" type="hidden" name="updatejob[subject_slug]" value="<?php echo $app->job->subject_slug; ?>"  />
					<input class="suggest" type="hidden" name="updatejob[parent_slug]" value="<?php echo $app->job->parent_slug; ?>"  />
					<input class="suggest" type="hidden" name="updatejob[subject_id]" value="<?php echo $app->job->subject_id; ?>"  />
					<input type="hidden" name="updatejob[target]" value="updatejob"  />
					<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
					
					<p></p>
					<div>
						<button class="btn waves-effect " type="submit">
							Update Job
						</button>
						<button type="button" class="btn red confirm-submit" data-value="closejob" data-name="updatejob">
							Delete Job
						</button>
					</div>
					
				</form>
				
			</div>
		</div>
		<?php endif; ?>
		
	</div>
	<div class="col s12 m4 l4">
		
		<?php if(isset($app->job->session) && empty($app->job->session->jobsetup)): ?>
			<h2>Sessions</h2>
			
			<div class="block">
				<p>There is a scheduled session setup for this job</p>
				<a href="/sessions/view/<?php echo $app->job->session->id; ?>" class="btn blue btn-block">View Session Info</a>
			</div>
			
		<?php elseif(isset($app->job->applicants[0])): ?>
			<h2>Job Applicants</h2>
			<?php foreach($app->job->applicants as $applicants): ?>
				<div class="block">
					<div class="title">
						<?php if(isset($app->job->active_applicant_id) && $app->job->active_applicant_id==$applicants->id){ echo '<i class="fa fa-check"></i>';} ?>
						<a href="<?php echo $applicants->url; ?>" target="_blank"><?php echo the_users_name($applicants); ?></a>
					</div>
					<div class="description"><?php echo nl2br($applicants->message) ?></div>
					<div class="date"><?php echo formatdate($applicants->date) ?></div>
					<div class="hr"></div>
					
					<?php if(isset($app->user->creditcardonfile)): ?>
						<?php if(isset($app->job->active_applicant_id) && $app->job->active_applicant_id==$applicants->id): ?>
						<form method="post" action="<?php echo $app->request->getPath(); ?>">
							
							<input type="hidden" name="redactapplication[target]" value="redactapplication"  />
							<input type="hidden" name="redactapplication[id]" value="<?php echo $applicants->id; ?>"  />
							<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
							
							<button class="btn red confirm-submit" data-value="redact" data-name="redactapplication" type="button">
								Redact Application
							</button>
							
						</form>
						<?php elseif(empty($app->job->active_applicant_id)): ?>
						<form method="post" action="<?php echo $app->request->getPath(); ?>">
							
							<input type="hidden" name="acceptapplication[target]" value="acceptapplication"  />
							<input type="hidden" name="acceptapplication[id]" value="<?php echo $applicants->id; ?>"  />
							<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
							
							<button class="btn blue confirm-submit" data-value="accept" data-name="acceptapplication" type="button">
								Accept Application
							</button>
							
						</form>
						<?php endif; ?>
					<?php else: ?>
						<p>You must first have a credit card on file, to accept a job application</p>
						<a class="btn blue" href="/payment">Add Payment Method</a>
					<?php endif; ?>
					
				</div>
			<?php endforeach; ?>
		<?php else: ?>
			There are no applicants right now
		<?php endif; ?>
		
	</div>
</div>