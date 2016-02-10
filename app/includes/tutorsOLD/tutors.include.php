<?php if(isset($app->searchResults)): ?>

	<?php if(isset($app->filtertype)): ?>
		<div class="filter-by right-align">
			<a class="dropdown-button grey btn btn-s" href="#" data-activates="filterby">
				Filter By <i class="fa fa-chevron-down"></i>
			</a>


			<ul id="filterby" class="dropdown-content">
				<?php foreach($app->filtertype as $key=>$value): ?>
				<li <?php if(isset($app->filterby) && $app->filterby==$key){ echo 'class="active"';} ?>>
					<a href="<?php echo '/filterby/'.$app->filterbylocation.'/'.$key.'/'.$app->number; ?>">
						<?php echo $value; ?>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

	<h1><?php echo $app->metah1; ?></h1>

	<?php foreach($app->searchResults as $searchResults):?>
		<?php include($app->dependents->APP_PATH.'includes/tutors/search.results.php'); ?>
	<?php endforeach; ?>

	<?php echo $app->pagination; ?>

<?php else: ?>
	<?php if(isset($app->search->search)): ?>

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
<?php endif; ?>




<div class="hide" id="csrf_key"><?php echo $csrf_key; ?></div>
<div class="hide" id="csrf_token"><?php echo $csrf_token; ?></div>
