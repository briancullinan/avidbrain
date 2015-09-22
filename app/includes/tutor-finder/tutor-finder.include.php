<div class="homepageslide">
	
	<div class="homepage-items">

	    <h1>Teach Something. Learn Anything.</h1>
	    <div class="how-it-works" data-status="closed">
	        <span>How It Works</span>
	    </div>
	
	</div>

	<div class="slider">
		<ul class="slides">
			<li>
				<img src="/images/subs/find-a-tutor-1.jpg">
			</li>
			<li>
				<img src="/images/subs/find-a-tutor-2.jpg">
			</li>
			<li>
				<img src="/images/subs/find-a-tutor-3.jpg">
			</li>
			<li>
				<img src="/images/subs/find-a-tutor-4.jpg">
			</li>
			<li>
				<img src="/images/subs/find-a-tutor-5.jpg">
			</li>
		</ul>
	</div>

</div>

<div class="find-a-tutor">
	
	<div class="center-align container">
		<h2>Find <span class="finda">A Tutor</span></h2>
	
		<form method="post" action="/tutors">
		
			<div class="homepage-search">
					<input name="search[search]" class="homepage-typed searchbox"  type="text"  />
					<button class="btn blue btn-s homepage-search-button" type="submit">
						Search
					</button>
			</div>
			<input type="hidden" name="search[target]" value="search"  />
			<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
		</form>
		
	</div>
	
</div>

<div class="row">
	<div class="col s12 m6 l6">
		<h2>Signup Now</h2>
		<?php

			$simpleSignup = new Forms($app->connect);
			$simpleSignup->button = 'Signup';
			//$simpleSignup->classname = 'homepage-signup';
			$simpleSignup->formname = 'studentapplication';
			$simpleSignup->url = '/signup/student';
			$simpleSignup->dependents = $app->dependents;
			$simpleSignup->csrf_key = $csrf_key;
			$simpleSignup->csrf_token = $csrf_token;
			$simpleSignup->makeform();

		?>
	</div>
	<div class="col s12 m6 l6">
		<h2>Student Benefits</h2>
		<?php include($app->dependents->APP_PATH.'includes/signup/student/student-benefits.php'); ?>
	</div>
</div>