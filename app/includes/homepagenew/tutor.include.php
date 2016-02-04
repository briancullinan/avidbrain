<div class="row">
	<div class="col s12 m4 l4">

		<?php if(isset($settings) && $settings->affiliateprogram == 'yes'): ?>
			<h3>Affiliate Program</h3>
			<div class="block">
				Thank you for activating your affiliate account, you may now visit <a href="/affiliates">Affiliates</a>
			</div>
		<?php endif; ?>

		<?php if(isset($app->user->needs_bgcheck)): ?>
			<h3>Background Check</h3>
			<div class="block">
				<p>Before you can tutor a student you have to complete a background check. While it's not required to apply to job posts, it is required to message a student, or setup a tutoring session.</p>

				<a href="background-check" class="btn green white-text btn-block">Background Check</a>
			</div>
		<?php endif; ?>

		<h3>Profile Info</h3>
		<div class="block">
			<div class="page-views">Total Page Views <span><?php echo page_views($app); ?></span></div>
		</div>
	</div>

	<div class="col s12 m4 l4">
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

	<div class="col s12 m4 l4">
			<?php if(isset($app->mystudents)): ?>
				<h3>Your Students</h3>

				<div class="new-order-list">
					<?php foreach($app->mystudents as $item): ?>
						<div class="block-list-user">
							<a class="block-list" href="<?php echo $item->url; ?>" target="_blank">
								<?php echo $item->first_name.' '.$item->last_name; ?>
								<?php if($item->promocode==$app->user->email){ echo '<span class="badge tooltipped" data-position="bottom" data-delay="50" data-tooltip="Referred Student"><i class="fa fa-user"></i></span>';} ?>
								<?php if(isset($item->customer_id)){ echo '<span class="badge tooltipped green" data-position="bottom" data-delay="50" data-tooltip="Credit Card On File"><i class="fa fa-credit-card"></i></span>';} ?>
							</a>
						</div>
					<?php endforeach; ?>
				</div>

			<?php else: ?>
				You have no students, <a href="/students">find one now</a>.
			<?php endif; ?>

	</div>

</div>
