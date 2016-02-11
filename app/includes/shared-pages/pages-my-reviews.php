<?php
	function disply_star_things($counts,$number,$totals){

		$scoreCountPercent = 0;
		$scoreCount = 0;
		if(isset($counts[$number])){
			$score = $counts[$number];
			$scoreCount = count($score);
			$scoreCountPercent = (($scoreCount / $totals)* 100);
		}

		?>
		<div class="display-stars">
			<div class="row">
				<div class="col s3 m3 l3">
					<?php echo $number; ?> Stars
				</div>
				<div class="col s7 m7 l7">
					<div class="wide-count-total"><div class="wide-count" style="width: <?php echo $scoreCountPercent; ?>%;"></div></div>
				</div>
				<div class="col s2 m2 l2 right-align">
					<?php echo $scoreCount; ?>
				</div>
			</div>
		</div>
		<?php
	}
?>

<?php if(isset($app->currentuser->my_reviews) && $app->currentuser->usertype=='tutor'): ?>
	<?php foreach($app->currentuser->my_reviews as $my_reviews): ?>
		<?php
			$counts[$my_reviews->review_score][] = 1;
		?>
	<?php endforeach; ?>

	<div class="block">
		<div class="title">My Reviews Overview </div>
		<div class="description">
			<span class="grey-text"><?php echo $app->currentuser->reviewinfo->count; ?> Review<?php if($app->currentuser->reviewinfo->count!=1){echo 's';} ?> Total</span>
		</div>
		<?php
			disply_star_things($counts,5,$app->currentuser->reviewinfo->count);
			disply_star_things($counts,4,$app->currentuser->reviewinfo->count);
			disply_star_things($counts,3,$app->currentuser->reviewinfo->count);
			disply_star_things($counts,2,$app->currentuser->reviewinfo->count);
			disply_star_things($counts,1,$app->currentuser->reviewinfo->count);
		?>

	</div>

<?php endif; ?>



<?php if(isset($app->currentuser->my_testimonials)): ?>
	<h2>My Latest Testimonials</h2>
	<?php foreach($app->currentuser->my_testimonials as $my_testimonials): ?>

		<div class="block review">
			<div class="row">
				<div class="col s12 m3 l3">

					<?php
					    $results = NULL;
					    $fromuser = $my_testimonials->to_user;
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
				<div class="col s12 m9 l9">
					<?php if(isset($my_testimonials->session_subject)): ?>
					<div class="title">
						<?php echo $my_testimonials->session_subject; ?>
					</div>
					<?php endif; ?>

					<?php if(isset($my_testimonials->review_text)): ?>
					<div class="description"><?php echo nl2br($my_testimonials->review_text); ?></div>
					<?php endif; ?>

					<div class="date right-align"><?php echo formatdate($my_testimonials->review_date); ?></div>
				</div>
			</div>
		</div>

	<?php endforeach; ?>
<?php else: ?>
<?php
		if(isset($app->currentuser->settings) && $app->currentuser->settings->showfullname=='yes'){
			echo $app->currentuser->first_name.' '.$app->currentuser->last_name;
		}
		else{
			echo short($app->currentuser);
		}
	?> has no testimonials at this time
<?php endif; ?>
