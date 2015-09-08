<?php if(isset($app->currentuser->my_reviews[0])): ?>
	<?php foreach($app->currentuser->my_reviews as $review): ?>
		<div class="block review">
			<div class="row">
				<div class="col s12 m3 l3">
					<?php
						$userinfo = $review;
						$userinfo->dontshow = 1;
						include($app->dependents->APP_PATH."includes/user-profile/user-block.php"); ?>
				</div>
				<div class="col s12 m9 l9">
					<?php if(isset($review->session_subject)): ?>
					<div class="title">
						<?php echo $review->session_subject; ?>
					</div>
					<?php endif; ?>
					
					<?php if(isset($review->review_score)): ?>
					<div class="my-stars"><div class="the-star-score"><?php echo get_stars($review->review_score)->icons; ?></div></div>
					<?php endif; ?>
					
					<?php if(isset($review->review_text)): ?>
					<div class="description"><?php echo nl2br($review->review_text); ?></div>
					<?php endif; ?>
					
					<div class="date right-align"><?php echo formatdate($review->review_date); ?></div>
				</div>
			</div>
		<?php // printer($review); ?>
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
	?> has no reviews at this time
<?php endif; ?>