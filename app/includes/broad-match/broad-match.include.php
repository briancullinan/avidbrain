<?php if(isset($app->broadmatch)): ?>
	<?php foreach($app->broadmatch as $searchResults): ?>
		<?php include($app->dependents->APP_PATH."includes/user-profile/mini.tutor.profile.php"); ?>
	<?php endforeach; ?>
	<?php echo $app->pagination; ?>
<?php else: ?>
	
	<div class="row">
		<div class="col s12 m6 l6">
			<p>There were no <?php echo $app->broadMatchCap; ?> tutors found. </p>
			<p>Enter your email address to the right and we will find a tutor for you, and then get back to you as soon as possible. </p>
		</div>
		<div class="col s12 m6 l6">
			<?php
	
				$simpleSignup = new Forms($app->connect);
				$simpleSignup->formname = 'studentapplication';
				$simpleSignup->url = '/signup/student';
				$simpleSignup->dependents = $app->dependents;
				$simpleSignup->csrf_key = $csrf_key;
				$simpleSignup->csrf_token = $csrf_token;
				$simpleSignup->makeform();
	
			?>
		</div>
	</div>
	
	
<?php endif; ?>