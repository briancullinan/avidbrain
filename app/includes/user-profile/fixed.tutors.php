<?php

	$fixedInfo = new stdClass();
	if(isset($searchResults->count)){
		$fixedInfo->count = $searchResults->count;
	}
	if(isset($searchResults->score)){
		$fixedInfo->star_score = $searchResults->score;
	}
	if(isset($searchResults->average)){
		$fixedInfo->review_average = $searchResults->average;
	}
	if(isset($searchResults->hours)){
		$fixedInfo->hours_tutored = $searchResults->hours;
	}

	$cachedStudentCountKey = "cached-student-count".$searchResults->email;
	$student_count = $app->connect->cache->get($cachedStudentCountKey);
	if($student_count == null) {
		$sql = "SELECT COUNT(sessions.paidout) FROM avid___sessions sessions WHERE sessions.from_user = :email GROUP BY sessions.to_user ORDER BY count(sessions.id) DESC";
		$prepare = array(':email'=>$searchResults->email);
		$student_count = $app->connect->executeQuery($sql,$prepare)->rowCount();
	    $returnedData = $student_count;
	    $student_count = $returnedData;
	    $app->connect->cache->set($cachedStudentCountKey, $returnedData, 3600);
	}

	if($student_count>0){
		$fixedInfo->student_count = $student_count;
	}

	$searchResults->reviewinfo = $fixedInfo;

?>

<div class="tutor-results <?php if(activenow($searchResults)){ echo 'active-now';} ?>">
	<div class="hourly-rate valign-wrapper <?php if(isset($searchResults->negotiableprice) && $searchResults->negotiableprice=='yes'){ echo 'negotiable-price';} ?>">
		<span class="valign">
			$<?php echo $searchResults->hourly_rate; ?> <?php if(isset($searchResults->negotiableprice) && $searchResults->negotiableprice=='yes'){ echo '<span class="asterisk"><i class="fa fa-asterisk"></i></span>';} ?>
		</span>
	</div>

	<div class="row">
		<div class="col s12 m4 l3 center-align">


			<?php
			    $results = NULL;
			    $fromuser = $searchResults->email;
			    $sql = "SELECT user.username,user.url,user.first_name,user.last_name,profile.my_avatar,profile.my_upload,profile.my_upload_status FROM avid___user user INNER JOIN avid___user_profile profile on profile.email = user.email WHERE user.email = :email LIMIT 1";
			    $prepare = array(':email'=>$fromuser);
			    $results = $app->connect->executeQuery($sql,$prepare)->fetch();
			?>

			<?php if(isset($results->username)): ?>
			    <div class="user-photograph">
			        <a href="<?php echo $results->url; ?>">
			            <img src="<?php echo userphotographs($app->user,$results,$app->dependents); ?>" />
			        </a>
			    </div>
			    <div class="user-name">
			        <a href="<?php echo $results->url; ?>"><?php echo ucwords(short($results)); ?></a>
			    </div>
			<?php endif; ?>

			<?php if(isset($searchResults->city)): ?>
			<div class="tutor-location">
				<i class="mdi-action-room"></i>
				<a href="/tutors/<?php echo $searchResults->state_slug; ?>/<?php echo $searchResults->city_slug; ?>"><?php echo $searchResults->city; ?></a>, <a href="/tutors/<?php echo $searchResults->state_slug; ?>"><?php echo ucwords($searchResults->state_long); ?></a>
			</div>
			<?php endif; ?>
			<?php if(isset($searchResults->distance)): ?>
			<div class="tutor-distance">
				<?php echo number_format(round($searchResults->distance), 0, '', ','); ?> Miles Away
			</div>
			<?php endif; ?>

		</div>
		<div class="col s12 m8 l9">
			<div class="row">
				<div class="col s12 m7 l9">

					<?php if(isset($searchResults->short_description_verified)): ?>
						<div class="short-description"><?php echo $searchResults->short_description_verified; ?></div>
					<?php endif; ?>
					<?php if(isset($searchResults->personal_statement_verified)): ?>
						<div class="personal-statement"><?php echo truncate($searchResults->personal_statement_verified,300); ?></div>
					<?php endif; ?>

					<?php if(empty($searchResults->short_description_verified) && empty($searchResults->personal_statement_verified)): ?>

					<?php endif; ?>

					<?php if(isset($searchResults->subjects[0])): ?>
					<div class="short-description">My Areas of Expertise</div>
						<div class="tutor-results-subjects">
							<?php echo showsubjects($searchResults->subjects,10); ?>
						</div>
					<?php endif; ?>

				</div>
				<div class="col s12 m5 l3">
					<?php if(isset($app->user->email) && $app->user->email == $searchResults->email): ?>
						<div class="view-profile"><a class="btn orange btn-block" href="<?php echo $searchResults->url; ?>">Edit Your Profile</a></div>
					<?php else: ?>
						<div class="view-profile"><a class="btn btn-block" href="<?php echo $searchResults->url; ?>">View Profile</a></div>
						<div class="view-profile"><a class="btn btn-block blue" href="<?php echo $searchResults->url; ?>/send-message">Send Message</a></div>
					<?php endif; ?>
				</div>
			</div>
		</div>

	</div>

	<div class="badges mini-badges">
		<?php
			echo badge('background_check',$searchResults);
			if(activenow($searchResults)){
				echo badge('imonline',$searchResults);
			}
			echo badge('average_score',$searchResults);
			echo badge('review_count',$searchResults);
			echo badge('hours_tutored',$searchResults);
			echo badge('student_count',$searchResults);
			echo badge('fancy_hours_badge',$searchResults);
			echo badge('negotiable_rate',$searchResults);
		?>
	</div>


</div>
