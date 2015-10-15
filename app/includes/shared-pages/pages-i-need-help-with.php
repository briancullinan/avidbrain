<?php if(isset($app->user->usertype) && $app->user->usertype=='admin'): ?>
	<h1>Post A Job for <?php echo short($app->currentuser); ?></h1>
	<div class="block">
		<?php
			$jobOptions = array();
			$jobOptions['type'] = (object)array(
				'No Preference'=>'both',
				'Online'=>'online',
				'In Person'=>'offline'
			);
			$jobOptions['skill_level'] = (object)array(
				'Novice','Advanced Beginner','Competent','Proficient','Expert'
			);
			$app->jobOptions = $jobOptions;
		?>
		<form class="form-post" method="post" action="/jobs">

			<input type="hidden" name="postjob[user][email]" value="<?php echo $app->currentuser->email; ?>"  />

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

			<div class="input-field input-range jobs-range">

				<div class="jobs-price-range">What is your price range?</div>

				<div class="pricerange slidebox"></div>
				<div class="slidebox-inputs">
					<input type="text" name="postjob[price_range_low]" id="pricerangeLower" data-value="<?php if(isset($app->searching->pricerangeLower)){ echo $app->searching->pricerangeLower; }else{ echo '15';} ?>" />
					<input type="text" name="postjob[price_range_high]" id="pricerangeUpper" data-value="<?php if(isset($app->searching->pricerangeUpper)){ echo $app->searching->pricerangeUpper; }else{ echo '65';} ?>" />
				</div>

			</div>
			<p></p>

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
<?php endif; ?>


<?php if(isset($app->currentuser->myjobs[0])): ?>

	<?php if(isset($app->currentuser->thisisme)): ?>
		<h2>My Tutor Requests</h2>
	<?php endif; ?>

	<?php foreach($app->currentuser->myjobs as $myjobs): //printer($myjobs); ?>
		<div class="box">
			<div class="title">
				<?php echo $myjobs->subject_name; ?>
			</div>
			<div class="description">
				<?php echo $myjobs->job_description; ?>
			</div>

			<div class="row">

				<div class="col s12 m8 l8">

					<div><?php echo formatdate($myjobs->date); ?></div>

					<?php if(isset($myjobs->type)): ?>
					<div>
						I'm looking for <strong><?php echo strtolower(online_tutor($myjobs->type)); ?></strong> tutoring
					</div>
					<?php endif; ?>

					<?php if(isset($myjobs->skill_level)): ?>
					<div>
						My Skill Level: <?php echo $myjobs->skill_level; ?>
					</div>
					<?php endif; ?>

					<?php if(isset($myjobs->price_range_low)): ?>
					<div>
						My Price Range: <strong class="green-text">$<?php echo $myjobs->price_range_low; ?> - $<?php echo $myjobs->price_range_high; ?></strong>
					</div>
					<?php endif; ?>

				</div>

				<div class="col s12 m4 l4 right-align">
					<?php if(isset($app->currentuser->thisisme)): ?>
					<a class="btn orange blue" href="/jobs/manage/<?php echo $myjobs->id; ?>">Edit Tutor Request</a>
					<?php else: ?>
					<a class="btn blue" href="/jobs/apply/<?php echo $myjobs->id; ?>">Apply To Job</a>
					<?php endif; ?>
				</div>

			</div>
		</div>
	<?php endforeach; ?>
<?php elseif(isset($app->currentuser->thisisme)): ?>
	You don't have any job posts. <a class="btn btn-s blue" href="/jobs">Add One Now</a>

	<?php
		$sql = "SELECT * FROM avid___user_subjects WHERE email = :email";
		$prepare = array(':email'=>$app->user->email);
		$results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
	?>

	<?php if(isset($results[0])): ?>
	<br>
	<br>
	<div class="alert red white-text">
		We've updated our jobs boards
	</div>
	<div class="center-align"><a class="btn" href="/jobs/import">Import Your Job Posts</a></div>
	<?php endif; ?>


<?php else: ?>
	<?php echo the_users_name($app->currentuser); ?> hasn't listed what they need help with
<?php endif; ?>
