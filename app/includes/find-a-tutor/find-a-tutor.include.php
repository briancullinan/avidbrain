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
				<a class="writing valign" href="/categories/xxx/xxx">Writing</a>
			</div>
		</div>
		<div class="col s12 m6 l4">
			<div class="valign-wrapper">
				<a class="philosophy valign" href="/categories/xxx/xxx">Philosophy</a>
			</div>
		</div>
		<div class="col s12 m6 l4">
			<div class="valign-wrapper">
				<a class="chemistry valign" href="/categories/xxx/xxx">Chemistry</a>
			</div>
		</div>
		<div class="col s12 m6 l4">
			<div class="valign-wrapper">
				<a class="psychology valign" href="/categories/xxx/xxx">Psychology</a>
			</div>
		</div>
	</div>
	
	<a class="view-more" href="/categories">View More Subjects</a>
	
</div>


<div class="row">
	<div class="col s12 m6 l6">
		<h2>Signup</h2>
		<?php


			$studentSignup = new Forms($app->connect);
			if(isset($promocode) && $promocode=='promocode'){
				$studentSignup->classname = 'promocode';
				//unset($promocode);
				$promocode = 'Enter Your Promo Code';
			}
			$studentSignup->formname = 'signup';
			$studentSignup->url = $app->request->getPath();
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


<style type="text/css">
.college-tutors a.view-more{
	display: inline-block;
	text-align: center;
	padding: 0px;
	font-size: 22px;
	text-shadow: none;
	color: #2196F3;
	margin-top: -25px;
	float: left;
	width: 100%;
}
.main-find-a-tutor{
	padding-left: 0px;
	padding-right: 0px;
	padding-top: 0px;
}
.valign-wrapper{
	width: 100%;
	text-align: center;
}
.college-tutors{
	margin-top: 20px;
	float: left;
	width: 100%;
}
.college-tutors a{
	position: relative;
	padding: 60px;
	text-align: center;
	width: 100%;
	font-family: 'Quicksand';
	font-size: 35px;
	font-weight: 700;
	color: #fff;
	background-size: cover;
	margin-bottom: 25px;
	text-shadow: 2px 2px #000;
}

.college-tutors a.biology{
	background-image: url('/images/subjects/biology.jpg');
}
.college-tutors a.writing{
	background-image: url('/images/subjects/writing.jpg');
}
.college-tutors a.chemistry{
	background-image: url('/images/subjects/chemistry.jpg');
}
.college-tutors a.economics{
	background-image: url('/images/subjects/economics.jpg');
}
.college-tutors a.philosophy{
	background-image: url('/images/subjects/philosophy.jpg');
}
.college-tutors a.psychology{
	background-image: url('/images/subjects/psychology.jpg');
}
</style>