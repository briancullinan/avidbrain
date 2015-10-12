<div class="homepage-logged-in">

	<h1>Welcome to <?php echo $app->dependents->SITE_NAME_PROPPER; ?></h1>

	<div class="row">

		<div class="col s12 m6 l4">

				<?php if(isset($app->mytutors)): ?>
				<h3>Your Tutors</h3>

				<div class="new-order-list">
					<?php foreach($app->mytutors as $mytutors): ?>
						<div class="block-list-user">
							<a class="block-list" href="<?php echo $mytutors->url; ?>" target="_blank">
								<?php echo short($mytutors); ?>
							</a>
						</div>
					<?php endforeach; ?>
				</div>

				<?php else: ?>
					<div class="block">You have no tutors, <a href="/tutors">find one now</a>.</div>
				<?php endif; ?>

				<?php if(empty($app->my_jobs)): ?>
					<div class="block">You haven't posted a job yet, it's the easiest way to find a tutor. <a href="/jobs">Try It Now</a></div>
				<?php endif; ?>


			<?php
				$sql = "SELECT id FROM avid___user_subjects WHERE email = :email";
				$prepare = array(':email'=>$app->user->email);
				$import = $app->connect->executeQuery($sql,$prepare)->rowCount();
				if($import!=0):
			?>
			<div class="alert red white-text">
				We've updated our jobs boards
			</div>
			<div class="center-align"><a class="btn" href="/jobs/import">Import Your Job Posts</a></div>
			<?php endif; ?>

			<?php if(isset($app->needsreview)): ?>
				<?php
					$neeedss=NULL;
					if(count($app->needsreview)!=1){$neeedss='s';}
				?>
				<h3>Past Session<?php echo $neeedss; ?></h3>
				<?php foreach($app->needsreview as $needsreview): ?>
					<div class="block">
						<div class="title">
							<?php echo $needsreview->session_subject; ?>
						</div>
						<div class="description">
							<div><a href="/sessions/view/<?php echo $needsreview->id; ?>">Review Session</a></div>
						</div>
						<div class="date">
							With: <a href="<?php echo $needsreview->url; ?>" target="_blank"><?php echo short($needsreview); ?></a> @ <?php echo formatdate($needsreview->session_timestamp); ?>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>

		</div>

		<div class="col s12 m6 l4">
			<?php if(isset($app->my_tweets)): ?>
				<h3> News from <?php echo str_replace('https://twitter.com/','@',$app->dependents->social->twitter); ?></h3>
				<?php foreach($app->my_tweets as $tweet):# printer($tweet); ?>

				<div class="block tweets">
					<div class="row">
						<div class="col s2 m3 l2">
							<a href="https://twitter.com/<?php echo $tweet->user->screen_name; ?>" target="_blank"><img src="<?php echo str_replace('http://','https://',$tweet->user->profile_image_url); ?>" class="responsive-img" /></a>
						</div>
						<div class="col s10 m9 l10">
							<div class="description"><?php echo linkify_tweet($tweet->text); ?></div>
							<div class="date"><?php echo formatdate($tweet->created_at,'M. jS, Y @ g:i a'); ?></div>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
				<div class="more-tweets"><a target="_blank" href="https://twitter.com/<?php echo $tweet->user->screen_name; ?>">View More Tweets</a></div>
			<?php endif; ?>

		</div>

		<div class="col s12 m12 l4">

			<?php
				if( isset($app->freesessions->enabled) && $app->freesessions->enabled==true ){
					include('homepage-free-sessions.php');
				}
				else{
					include('homepage-regular-sessions.php');
				}
			?>

			<?php if(isset($app->myrewards)): ?>
				<h2>Your Rewards</h2>
				<div class="all-my-rewards">
					<?php foreach($app->myrewards as $myrewards):  ?>
						<div class="block my-reward">
							<div class="row">
								<div class="col s12 m6 l6">
									<div class="my-reward-value">

										<div><span>$<?php echo numbers($myrewards->value,1); ?></span> Off Your Next Tutoring Session.</div>
										<div class="grey-text">Automatically applied after your next session</div>

									</div>
								</div>
								<div class="col s12 m6 l6">
									<div class="my-reward-promo">Promo Code: <span><?php echo $myrewards->promocode; ?></span></div>
									<div>Activated: <?php echo formatdate($myrewards->date); ?></div>

									<?php if(isset($myrewards->url)): ?>
									<div>Shared With: <a href="<?php echo $myrewards->url; ?>" target="_blank"><?php echo short($myrewards); ?></a></div>
									<?php endif; ?>

								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

		</div>
	</div>

</div>
