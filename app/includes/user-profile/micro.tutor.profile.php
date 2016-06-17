<?php
	$query = $app->connect->createQueryBuilder();
	$subjects = $query->select('*')
					 ->from('avid___user_subjects')
					 ->where('email = :email AND status = :status')
					 ->setParameter(':email',$searchResults->email)
					 ->setParameter(':status','verified')
					 ->orderBy('last_modified', 'ASC')
					 ->setMaxResults(7)
					 ->execute()
					 ->fetchAll();
					 if(count($subjects)>0){
						 $searchResults->subjects = $subjects;
					 }

	$test = get_reviewinfo($app->connect,$searchResults->email,$searchResults->usertype);
	$searchResults->reviewinfo = new stdClass();
	$searchResults->reviewinfo->review_average = $test->review_average;
	$searchResults->reviewinfo->star_score = $test->star_score;
	$searchResults->reviewinfo->hours_tutored = $test->hours_tutored;
	$searchResults->reviewinfo->count = $test->count;

?>

<div class="tutor-results">
	<div class="hourly-rate valign-wrapper">
		<span class="valign">$<?php echo $searchResults->hourly_rate; ?></span>
	</div>

	<div class="row">
		<div class="col s12 m12 l4 center-align">

			<div class="user-photograph">
				<a href="<?php echo $searchResults->url; ?>">
					<img src="<?php echo userphotographs($app->user,$searchResults); ?>" />
				</a>
			</div>
			<div class="user-name">
				<a href="<?php echo $searchResults->url; ?>"><?php echo ucwords(short($searchResults)); ?></a>
			</div>

		</div>
		<div class="col s12 m12 l8">
			<?php if(isset($searchResults->short_description_verified)): ?>
				<div class="short-description">
					<?php echo $searchResults->short_description_verified; ?>
				</div>
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
	</div>


</div>
