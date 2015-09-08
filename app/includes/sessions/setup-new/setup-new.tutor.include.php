<div class="compose-box">
	<div class="row">
		<div class="col s12 m4 l4">
			<h3>Available Students</h3>
			<div class="confirm-payment hide"></div>
			<div class="compose-list center-align white">
				<?php if(count($app->alltheusers)>0): ?>
				<?php foreach($app->alltheusers as $compose): ?>
					<div class="compose-item <?php if(isset($username) && $compose->username==$username){ echo 'active'; } ?>" id="/sessions/setup-new/<?php echo $compose->username; ?>">
						<div class="row">
							<div class="col s12 m3 l3">
								<div class="avatar">
									<?php echo show_avatar($compose,$user=$app->user,$app->dependents); ?>
								</div>
							</div>
							<div class="col s12 m9 l9">
								<div class="user-name">
									<?php echo the_users_name($compose); ?>
								</div>
								<?php
									if(empty($compose->promocode) && $compose->usertype=='student'){
										echo '<div class="badge grey white-text">Student</div>';
									}
									elseif(isset($compose->promocode) && $compose->promocode==$app->user->email  && $compose->usertype=='student'){
										echo '<div class="badge blue white-text">Your Student</div>';
									}
									elseif($compose->usertype=='student'){
										echo '<div class="badge grey white-text">Student</div>';
									}
									elseif($compose->usertype=='tutor'){
										echo '<div class="badge light-green accent-4 white-text">Tutor</div>';
									}								
								?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
				<?php else: ?>
					You have no contacts
				<?php endif; ?>
			</div>
		</div>
		<div class="col s12 m8 l8">
			<?php if(isset($app->setupsessionwith)): ?>
				<h3>Setup a tutoring session with <?php echo the_users_name($app->setupsessionwith); ?> </h3>
				
				<?php
					
					$formvalues = new stdClass();
					$formvalues->session_rate = $app->user->hourly_rate;
					
					$setupsession = new Forms($app->connect);
					$setupsession->formname = 'setupsession';
					$setupsession->url = '/sessions/setup-new/'.$username;
					$setupsession->dependents = $app->dependents;
					$setupsession->csrf_key = $csrf_key;
					$setupsession->csrf_token = $csrf_token;
						$setupsession->formvalues = $formvalues;
					$setupsession->makeform();
				?>	
				
			<?php elseif(isset($username)): ?>
				<div class="alert red white-text">Invalid User</div>
			<?php else: ?>
				<h3>Setup a tutoring session</h3>
				<div>Choose a student from the left to setup a tutoring session</div>
			<?php endif; ?>
		</div>
	</div>
</div>