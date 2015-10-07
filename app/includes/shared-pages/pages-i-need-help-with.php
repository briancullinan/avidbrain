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
