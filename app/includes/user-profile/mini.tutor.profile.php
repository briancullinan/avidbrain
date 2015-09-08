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
					 
	$sql = "SELECT round(avg(review_score)) as star_score, (sum(session_length) / 60) as hours_tutored FROM avid___sessions WHERE from_user = :email AND session_status = :session_status";
	$prepeare = array(':email'=>$searchResults->email,':session_status'=>'complete');
	$reviewinfo = $app->connect->executeQuery($sql,$prepeare)->fetch();
	
		$sql = "SELECT * FROM avid___sessions WHERE from_user = :email AND session_status = 'complete' AND review_score IS NOT NULL OR from_user = :email AND session_status = 'complete' AND review_text IS NOT NULL ";
		$prepeare = array(':email'=>$searchResults->email);
		$reviewinfo->count = $app->connect->executeQuery($sql,$prepeare)->rowCount();
		$reviewinfo->student_count = $app->connect->executeQuery('SELECT id FROM avid___sessions WHERE from_user = :myemail AND session_status = "complete" GROUP BY to_user ',array(':myemail'=>$searchResults->email))->rowCount();
		
		if(empty($reviewinfo->star_score)){
			unset($reviewinfo->star_score);
		}
		if(empty($reviewinfo->hours_tutored)){
			unset($reviewinfo->hours_tutored);
		}
		if(empty($reviewinfo->count)){
			unset($reviewinfo->count);
		}
		if(empty($reviewinfo->student_count)){
			unset($reviewinfo->student_count);
		}
		
		$searchResults->reviewinfo = $reviewinfo;
	
?>

<div class="tutor-results">
	<div class="hourly-rate">
		$<?php echo $searchResults->hourly_rate; ?>
	</div>
	
	<div class="row">
		<div class="col s12 m3 l3 center-align">
			<?php
				$userinfo = $searchResults;
				include($app->dependents->APP_PATH.'includes/user-profile/user-block.php');
			?>
			
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
		<div class="col s12 m9 l9">
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
	
	<div class="badges">
		<?php
			echo badge('background_check',$searchResults);
			echo badge('average_score',$searchResults);
			echo badge('review_count',$searchResults);
			echo badge('hours_tutored',$searchResults);
			echo badge('student_count',$searchResults);
			echo badge('fancy_hours_badge',$searchResults);
		?>
	</div>
	
	
</div>