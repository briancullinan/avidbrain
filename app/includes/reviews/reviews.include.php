<div class="row">
	<div class="col s12 m6 l6">
		<p>Reviews are an important part in the tutor selection process. Tutor reviews allow students to get a better view on how other students rated their time with their tutor. Reviews can be given for a tutor only after a session has been completed, this allows us to authenticate all of our reviews and guarantee their legitimacy.</p>

		<p>If as a student you are unsure if a tutor will be a good fit for you, make sure to check out their reviews to get a better understanding of what previous students have to say.</p>
	</div>
	<div class="col s12 m6 l6">
		<?php if(isset($app->reviews)): ?>
			<?php foreach($app->reviews as $reviews): ?>
				<div class="block">

					<div class="row">
						<div class="col s12 m3 l3">
							<?php
							    $results = NULL;
							    $fromuser = $reviews->to_user;
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

							<?php if(isset($reviews->session_subject)): ?>
							<div class="title">
								<?php echo $reviews->session_subject; ?>
							</div>
							<?php endif; ?>

							<?php if(isset($reviews->review_text)): ?>
							<div class="description"><?php echo nl2br($reviews->review_text); ?></div>
							<?php endif; ?>

							<div class="date right-align"><?php echo formatdate($reviews->review_date); ?></div>

						</div>
					</div>

				</div>
			<?php endforeach; ?>
			<?php echo $app->pagination; ?>
		<?php endif; ?>
	</div>
</div>
