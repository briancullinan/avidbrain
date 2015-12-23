<?php if(isset($app->foundusers)): ?>
	<h2>Maybe you were looking for one of these tutors?</h2>
	<ul>
		<?php foreach($app->foundusers as $foundusers): ?>
			<li>
				<a href="<?php echo $foundusers->url; ?>">
					<?php echo short($foundusers); ?> - <?php echo $foundusers->city; ?> <?php echo ucwords($foundusers->state_long); ?> Tutor
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
<?php else: ?>
	<br><br>
	<div class="row">
		<div class="col s12 m4 l4">
			<p>Sorry that you can't find the page you are looking for. Maybe we can help you.</p>
			<div><strong>Possible Solutions:</strong></div>
			<ul class="collection">
				<li class="collection-item">
					<div class="row">
						<div class="col s1 m1 l1">
							<i class="fa fa-search green-text"></i>
						</div>
						<div class="col s11 m11 l11">
							<a href="/tutors">Search for a tutor</a>
						</div>
					</div>
				</li>

				<li class="collection-item">
					<div class="row">
						<div class="col s1 m1 l1">
							<i class="fa fa-search green-text"></i>
						</div>
						<div class="col s11 m11 l11">
							<a href="/jobs">
								Find A Tutoring Job
							</a>
						</div>
					</div>
				</li>

				<li class="collection-item">
					<div class="row">
						<div class="col s1 m1 l1">
							<i class="fa fa-search green-text"></i>
						</div>
						<div class="col s11 m11 l11">
							<a href="/help">
								Get Help
							</a>
						</div>
					</div>
				</li>

				<li class="collection-item">
					<div class="row">
						<div class="col s1 m1 l1">
							<i class="fa fa-search green-text"></i>
						</div>
						<div class="col s11 m11 l11">
							<a href="/signup/student">
								Become A Student
							</a>
						</div>
					</div>
				</li>

				<li class="collection-item">
					<div class="row">
						<div class="col s1 m1 l1">
							<i class="fa fa-search green-text"></i>
						</div>
						<div class="col s11 m11 l11">
							<a href="/signup/tutor">
								Become A Tutor
							</a>
						</div>
					</div>
				</li>

				<li class="collection-item">
					<div class="row">
						<div class="col s1 m1 l1">
							<i class="fa fa-search green-text"></i>
						</div>
						<div class="col s11 m11 l11">
							<a href="/how-it-works">
								Learn More About How It Works
							</a>
						</div>
					</div>
				</li>
			</ul>

		</div>
		<div class="col s12 m8 l8">
			<h2>Talk to a tutor</h2>
			<?php
				$searchResults = $app->randomtutor;
				include($app->dependents->APP_PATH.'includes/tutors/search.results.php');
				//include($app->dependents->APP_PATH."includes/user-profile/mini.tutor.profile.php");
			?>
			<div class="hide" id="csrf_key"><?php echo $csrf_key; ?></div>
			<div class="hide" id="csrf_token"><?php echo $csrf_token; ?></div>
		</div>
	</div>

<?php endif; ?>
