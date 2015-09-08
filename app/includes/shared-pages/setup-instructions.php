<div class="attention-overlay">
	
	<div class="container">
		<h2>Let's Get Started</h2>
		<p>Welcome to the new <?php echo $app->dependents->SITE_NAME_PROPPER; ?> Profile.... From here you can edit your profile as you need.</p>
		
		<?php if($app->user->usertype=='tutor'): ?>
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
		<?php endif; ?>
		
		<p>
			<a class="btn waves-effect" href="<?php echo $app->currentuser->url; ?>/okgotit">Ok, I Got It</a>
		</p>
	</div>
	
</div>