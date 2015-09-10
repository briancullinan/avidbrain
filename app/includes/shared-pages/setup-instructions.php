<div class="attention-overlay">
	
	<div class="container">
		<h2>Let's Get Started</h2>
		<p>Welcome to the new <?php echo $app->dependents->SITE_NAME_PROPPER; ?> Profile.... From here you can edit your profile as you need.</p>
		
		<?php if($app->user->usertype=='tutor'): ?>		
			<div class="row">
				<div class="col s12 m6 l6">
					<p>Thank you for deciding to become a tutor with <?php echo $app->dependents->SITE_NAME; ?>! In order to make sure you have the best experience tutoring with us we are going to walk you through how <?php echo $app->dependents->SITE_NAME; ?> works. </p>
					
					<p>
						<a class="btn waves-effect" href="<?php echo $app->currentuser->url; ?>/okgotit">Ok, I Got It, skip to the good stuff</a>
					</p>
					<p>
						<a class="btn blue waves-effect" href="/help/tutor-walkthrough">View Walkthrough</a>
					</p>
					
				</div>
				<div class="col s12 m6 l6">
					<ul class="collection">
						<li class="collection-item">
							<i class="fa fa-dollar blue-text"></i> Add your Hourly Rate
						</li>
						<li class="collection-item">
							<i class="fa fa-photo blue-text"></i> Add A Photo
						</li>
						<li class="collection-item">
							<i class="fa fa-book blue-text"></i> Set what subjects you tutor
						</li>
						<li class="collection-item">
							<i class="fa fa-map-marker blue-text"></i> Change your location
						</li>
						<li class="collection-item">
							<i class="fa fa-plus blue-text"></i> And Much Much More
						</li>
					</ul>
				</div>
			</div>
		<?php elseif($app->user->usertype=='student'): ?>
		<ul class="collection">
			<li class="collection-item">
				<i class="fa fa-photo blue-text"></i> Add A Photo
			</li>
			<li class="collection-item">
				<i class="fa fa-book blue-text"></i> Add A Job Post
			</li>
			<li class="collection-item">
				<i class="fa fa-map-marker blue-text"></i> Change your location
			</li>
			<li class="collection-item">
				<i class="fa fa-plus blue-text"></i> And Much Much More
			</li>
		</ul>
		
			<p>
				<a class="btn waves-effect" href="<?php echo $app->currentuser->url; ?>/okgotit">Ok, I Got It, skip to the good stuff</a>
			</p>
			<p>
				<a class="btn blue waves-effect" href="/help/student-walkthrough">View Walkthrough</a>
			</p>
		
		
		<?php endif; ?>
	</div>
	
</div>