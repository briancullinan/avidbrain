<div class="student-signup hide">
	<p>Welcome to <?php echo $app->dependents->SITE_NAME_PROPPER; ?>! We are a trusted community marketplace that connects students and qualified tutors for online and in-person tutoring sessions. All tutors are interviewed and background checked to ensure safety and effectiveness. </p>

	<div class="signup-how-it-works center-align">
		<div class="how-it-works" data-status="closed">
	    	<span>How It Works</span>
		</div>
	</div>
</div>

<?php if(isset($app->isvalidpromo)): ?>
<div class="center-align">
	<div class="green white-text signup-promo">
		Signup now with promo code: <span><?php echo $app->isvalidpromo->promocode; ?></span> and get $<?php echo numbers($app->isvalidpromo->value,1); ?> off your next tutoring session.
	</div>
</div>
<?php endif;?>

<div class="row">

	<div class="col s12 m6 l6 <?php if(isset($promocode)){ echo 'active-promo';} ?>">
		<h2>Become A Student</h2>
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
		<h2>Student Benefits</h2>

		<?php include($app->dependents->APP_PATH.'includes/signup/student/student-benefits.php'); ?>

		<br><br>
		<div class="how-it-works center-align" data-status="closed">
	    	<span>How It Works</span>
		</div>

	</div>

</div>

<div class="why-tutoring hide">
	<h2>Why Tutoring</h2>
	<strong>Tutoring provides personalized, one-on-one attention.</strong>
	<p>In today's schools, the majority of teachers are because they enjoy helping students learn. However, teachers are limited by time and resources in regards to how much time they can spend giving attention to individual students. Teachers must show a strong balance between answering individual questions and focusing on the group as a whole. Because of this, your student might not be receiving the individual attention they need. With one-on-one tutoring, the tutor is dedicated 100% to your child's specific needs. Tutors are able to tailor sessions to best be able to help your student with his or her individual goals and challenges.</p>
	<strong>Tutoring creates extra study time (focused and on-task). </strong>
	<p>Another reason tutoring works is that it gives the student a set day or days each week to dedicate extra time to his or her schoolwork.</p>
	<strong>Tutoring provides opportunities for advancement.</strong>
	<p>As globalization increases, it is of the upmost importance that students gain a competitive ad. Some students feel they are already excelling in their classes, yet they want more of a competitive edge. A tutor can help with this.</p>
</div>
