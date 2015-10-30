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


<div class="college-tutors">
	<div class="row">
		<div class="col s12 m6 l4">
			<div class="valign-wrapper">
				<a class="economics valign" href="/categories/business/economics">Economics</a>
			</div>
		</div>
		<div class="col s12 m6 l4">
			<div class="valign-wrapper">
				<a class="biology valign" href="/categories/science/biology">Biology</a>
			</div>
		</div>
		<div class="col s12 m6 l4">
			<div class="valign-wrapper">
				<a class="writing valign" href="/categories/english/literature">English</a>
			</div>
		</div>
		<div class="col s12 m6 l4">
			<div class="valign-wrapper">
				<a class="philosophy valign" href="/categories/science/philosophy">Philosophy</a>
			</div>
		</div>
		<div class="col s12 m6 l4">
			<div class="valign-wrapper">
				<a class="chemistry valign" href="/categories/science/chemistry">Chemistry</a>
			</div>
		</div>
		<div class="col s12 m6 l4">
			<div class="valign-wrapper">
				<a class="psychology valign" href="/categories/science/psychology">Psychology</a>
			</div>
		</div>
	</div>

	<a class="view-more" href="/categories">View More Subjects</a>

</div>


<div class="row">
	<div class="col s12 m6 l6">
		<h2>Student Signup</h2>
		<?php


			$studentSignup = new Forms($app->connect);
			if(isset($promocode) && $promocode=='promocode'){
				$studentSignup->classname = 'promocode';
				//unset($promocode);
				$promocode = 'Enter Your Promo Code';
			}
			$studentSignup->formname = 'signup';
			$studentSignup->url = '/signup/student';
			$studentSignup->dependents = $app->dependents;
			$studentSignup->csrf_key = $csrf_key;
			$studentSignup->csrf_token = $csrf_token;
			if(isset($promocode)){

				$mycode = new stdClass();
				$mycode->promocode = $promocode;

			}

			if(isset($app->mylocation->zipcode)){
				if(empty($mycode)){
					$mycode = new stdClass();
				}
				$mycode->zipcode = $app->mylocation->zipcode;
			}

			if(isset($mycode)){
				$studentSignup->formvalues = $mycode;
			}

			$studentSignup->makeform();

		?>
	</div>
	<div class="col s12 m6 l6">
		<h2>Benefits</h2>
		<?php include($app->dependents->APP_PATH.'includes/signup/student/student-benefits.php'); ?>
	</div>
</div>
