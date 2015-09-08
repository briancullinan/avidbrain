<?php if(isset($app->user->email) && $app->user->usertype=='student'): ?>
	
	<p>Looking for a tutor, a teacher, or just someone who knows what they are talking about? Post a job and they will find you, no more searching.</p>
	
	<div class="row">
		<div class="col s12 m6 l6">
			
			<h2>Post A Job</h2>
			<div class="block">
				<form class="form-post" method="post" action="<?php echo $app->request->getPath(); ?>">
				
					<div class="input-field">
						<input type="text" name="postjob[subject_name]" id="findasubject" class="autogenerate--subject" data-name="postjob" />
						<label for="findasubject">
							Find The Subject You Want To Learn
						</label>
					</div>
				
					<div class="input-field">
						<textarea id="job_description" name="postjob[job_description]" class="materialize-textarea"></textarea>
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
								<select name="postjob[type]" class="browser-default">
									<?php foreach($app->jobOptions['type'] as $key => $type): ?>
									<option <?php if(isset($app->user->online_tutor) && $app->user->online_tutor == $type){ echo 'selected="selected"';} ?> value="<?php echo $type; ?>"><?php echo $key; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col s12 m6 l6">
							<div class="input-field">
								<label class="select-label" for="textarea1">
									What is your skill level?
								</label>
								<select name="postjob[skill_level]" class="browser-default">
									<option value="">Select Skill Level</option>
									<?php foreach($app->jobOptions['skill_level'] as  $skill_level): ?>
									<option value="<?php echo $skill_level; ?>"><?php echo $skill_level; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
					
					<input type="hidden" name="postjob[target]" value="postjob"  />
					<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
					
					<p></p>
					<div class="form-submit">
						<button class="btn blue" type="submit">
							Post Job
						</button>
					</div>
					
				</form>
					
			</div>
		</div>
		<div class="col s12 m6 l6">
			
			<?php if(isset($app->contest->ipadgiveaway)): ?>
				<?php if(empty($app->contestApplication)): ?>
				<div class="win-an-ipad-mini">
					<h2>Win an iPad Mini</h2>
					<p>Post a job, then enter to win an iPad. You must have a valid job posting to enter.</p>
					<p><a href="/contest/rules" class="btn orange">Learn More</a></p>
				</div>
				<?php else: ?>
				<div class="win-an-ipad-mini">
					Thank you for entering the iPad Mini Giveaway Contest Extravaganza
				</div>
				<?php endif; ?>
			<?php endif; ?>
			
			<h2>Your Job Posts</h2>
			<?php if(isset($app->my_jobs)): ?>
			
				<ul class="collection">
					<?php foreach($app->my_jobs as $job): ?>
						<li class="collection-item">
							<a href="/jobs/manage/<?php echo $job->id; ?>">
								<?php echo $job->subject_name; ?>
							</a>
							<?php if(isset($job->applicants)): ?>
								<span class="badge <?php if(isset($job->open)){ echo 'blue';}else{ echo 'green';} ?> white-text"><?php echo $job->applicants; ?></span>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php else: ?>
			<div class="block">
				You have no job posts
			</div>
			<?php endif; ?>
		</div>
	</div>
	
		
		
</div>

<?php if(isset($app->my_jobs) && empty($app->contestApplication) && isset($app->contest->ipadgiveaway)): ?>
	<div id="contest" class="modal">
		<div class="modal-content">
			<h4>iPad Mini Contest</h4>
	
			<div>
			<?php
				
				$contestinfo = new stdClass();
				$contestinfo->first_name = $app->user->first_name;
				$contestinfo->last_name = $app->user->last_name;
				$contestinfo->city = $app->user->city;
				$contestinfo->state = $app->user->state_long;
				$contestinfo->zipcode = $app->user->zipcode;
				
				$contestform = new Forms($app->connect);
				$contestform->formname = 'contestform';
				$contestform->url = '/jobs';
				$contestform->dependents = $app->dependents;
				$contestform->csrf_key = $csrf_key;
				$contestform->csrf_token = $csrf_token;
				$contestform->formvalues = $contestinfo;
				$contestform->makeform();
			?>
			</div>
	
		</div>
	
		<div class="modal-footer">
			<a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Close</a>
		</div>
	</div>
	<script type="text/javascript">
		
		$(document).ready(function() {
			$('#contest').openModal();
		});
		
	</script>
<?php endif; ?>

<?php else: ?>

	<?php include($app->target->base.'jobs.results.php'); ?>

<?php endif; ?>