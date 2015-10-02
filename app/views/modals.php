<?php if(empty($app->user->email)): ?>
<div id="loginModule" class="modal">
	<div class="modal-content">
		<h4><?php echo $app->dependents->SITE_NAME_PROPPER; ?> Login</h4>
	</div>

		<div class="row">
			<div class="col s12 m8 l8">
				<?php
					$thelogin = new Forms($app->connect);
					$thelogin->formname = 'login';
					$thelogin->url = '/login';
					$thelogin->dependents = $app->dependents;
					$thelogin->csrf_key = $csrf_key;
					$thelogin->csrf_token = $csrf_token;
					$thelogin->button = 'Login';
					$thelogin->makeform();
				?>
			</div>
			<div class="col s12 m4 l4">
				<a href="/help/forgot-password" class="btn red btn-block">Forgot Password?</a>
				<a href="/signup" class="btn btn-block blue">Signup</a>
			</div>
		</div>

	<div class="modal-footer">
		<a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat "> <i class="fa fa-times"></i> Dismiss </a>
	</div>
</div>
<?php endif; ?>


<div id="bgcheck_modal" class="modal">
	<div class="modal-content">
		<h4> <i class="mdi-action-assignment-ind"></i> Background Checks</h4>
		
		<p>At <?php echo $app->dependents->SITE_NAME_PROPPER; ?>, we require all of our tutors to be background checked to ensure the safety of our students. By requiring all tutors to go through a thorough background check, we create a place that is both safe and an effective environment for our students.</p>
		
	</div>

	<div class="modal-footer">
		<a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">OK, Thanks</a>
	</div>
</div>

<div id="myrank" class="modal">
	<div class="modal-content">
		
		<h4><?php echo $app->dependents->SITE_NAME_PROPPER; ?> Ranking</h4>
		
		<div class="row">
			<div class="col s12 m4 l4">
				<p>At <?php echo $app->dependents->SITE_NAME_PROPPER; ?>, we rank all of our tutors with ranks and ranks and ranks and ranks.</p>
				<p><a href="/signup/tutor">Get Ranked</a></p>
			</div>
			<div class="col s12 m8 l8">
				<ul class="collection">
					<li class="collection-item badge-new-user">
						<div class="row">
							<div class="col s12 m6 l6">
								
								<div class="row">
									<div class="col s2 m2 l2">
										<i class="fa fa-check"></i>
									</div>
									<div class="col s10 m10 l10">
										New User
									</div>
								</div>
								
							</div>
							<div class="col s12 m6 l6">
								0 - 50 Hours
							</div>
						</div>
					</li>
					<li class="collection-item badge-instructor">
						<div class="row">
							<div class="col s12 m6 l6">
								
								<div class="row">
									<div class="col s2 m2 l2">
										<i class="fa fa-certificate"></i>
									</div>
									<div class="col s10 m10 l10">
										Instructor
									</div>
								</div>
								
							</div>
							<div class="col s12 m6 l6">
								51 - 200 Hours
							</div>
						</div>
					</li>
					<li class="collection-item badge-teachers-assistant">
						<div class="row">
							<div class="col s12 m6 l6">
								<div class="row">
									<div class="col s2 m2 l2">
										<i class="fa fa-bolt"></i>
									</div>
									<div class="col s10 m10 l10">
										Teacher's Assistant
									</div>
								</div>
							</div>
							<div class="col s12 m6 l6">
								201 - 1,000 Hours
							</div>
						</div>
					</li>
					<li class="collection-item badge-teacher">
						<div class="row">
							<div class="col s12 m6 l6">
								
								<div class="row">
									<div class="col s2 m2 l2">
										<i class="fa fa-rocket"></i>
									</div>
									<div class="col s10 m10 l10">
										Teacher
									</div>
								</div>
								
							</div>
							<div class="col s12 m6 l6">
								1,001 - 2,000 Hours
							</div>
						</div>
					</li>
					<li class="collection-item badge-assistant-professor">
						<div class="row">
							<div class="col s12 m6 l6">
								
								<div class="row">
									<div class="col s2 m2 l2">
										<i class="fa fa-trophy"></i>
									</div>
									<div class="col s10 m10 l10">
										Assistant Professor
									</div>
								</div>
								
							</div>
							<div class="col s12 m6 l6">
								2,001 - 4,000 Hours
							</div>
						</div>
					</li>
					<li class="collection-item badge-associate-professor">
						<div class="row">
							<div class="col s12 m6 l6">
								
								<div class="row">
									<div class="col s2 m2 l2">
										<i class="fa fa-star"></i>
									</div>
									<div class="col s10 m10 l10">
										Associate Professor
									</div>
								</div>
								
							</div>
							<div class="col s12 m6 l6">
								4,001 - 6,000 Hours
							</div>
						</div>
					</li>
					<li class="collection-item badge-professor">
						<div class="row">
							<div class="col s12 m6 l6">
								
								<div class="row">
									<div class="col s2 m2 l2">
										<i class="fa fa-university"></i>
									</div>
									<div class="col s10 m10 l10">
										Professor
									</div>
								</div>
								
							</div>
							<div class="col s12 m6 l6">
								6,001 - 12,000 Hours
							</div>
						</div>
					</li>
					<li class="collection-item badge-mad-scientist">
						<div class="row">
							<div class="col s12 m6 l6">
								
								<div class="row">
									<div class="col s2 m2 l2">
										<i class="fa fa-flask"></i>
									</div>
									<div class="col s10 m10 l10">
										Mad Scientist
									</div>
								</div>
								
							</div>
							<div class="col s12 m6 l6">
								12,001+ Hours
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
		
	</div>

	<div class="modal-footer">
		<a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">OK, Thanks</a>
	</div>
</div>