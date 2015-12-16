<?php

	$filtertype = array(
		'closestdistance'=>'Closest Distance',
		'furthestdistance'=>'Furthest Distance',
		'highestrate'=>'Highest Hourly Rate',
		'lowestrate'=>'Lowest Hourly Rate',
		'lastactive'=>'Last Active',
		'higheststarscore'=>'Highest Star Score'
	);

	if(empty($app->getDistance)){
		unset($filtertype['closestdistance']);
		unset($filtertype['furthestdistance']);
	}

	if(empty($app->filterbylocation)){
		notify('needs: filterbylocation');
	}

?>

<?php if(isset($app->searchResults[0])): ?>

	<div class="filter-by right-align">
		<a class="dropdown-button grey btn btn-s" href="#" data-activates="filterby">
			Filter By <i class="fa fa-chevron-down"></i>
		</a>

		<!-- Dropdown Structure -->
		<ul id="filterby" class="dropdown-content">
			<?php foreach($filtertype as $key=>$value): ?>
			<li <?php if(isset($app->filterby) && $app->filterby==$key){ echo 'class="active"';} ?>>
				<a href="<?php echo '/filterby/'.$app->filterbylocation.'/'.$key.'/'.$app->number; ?>">
					<?php echo $value; ?>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>

	<?php foreach($app->searchResults as $searchResults): ?>

		<?php include($app->dependents->APP_PATH."includes/user-profile/mini.tutor.profile.php"); ?>

	<?php endforeach; ?>
	<?php echo $app->pagination; ?>
<?php else: ?>

	<div class="row">
		<div class="col s12 m6 l6">
			<div class="nothing-found">
				<?php
					if(isset($app->search->search)){
						$type = $app->search->search;
					}
					else{
						$type = 'Tutors';
					}
				?>
				<p>There were no tutors found. Would you like us to find one for you?</p>
				<p>Enter your email address to the right and we will find a tutor for you, and then get back to you as soon as possible. </p>

			</div>
		</div>
		<div class="col s12 m6 l6">
			<?php

				$simpleSignup = new Forms($app->connect);
				$simpleSignup->formname = 'studentapplication';
				$simpleSignup->url = $app->request->getPath();
				$simpleSignup->dependents = $app->dependents;
				$simpleSignup->csrf_key = $csrf_key;
				$simpleSignup->csrf_token = $csrf_token;
				$simpleSignup->makeform();

			?>
		</div>
	</div>

<?php endif; ?>
