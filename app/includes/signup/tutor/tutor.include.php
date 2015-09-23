<div class="row">

	<div class="col s12 m6 l6">
        
        <h2>Become a Tutor</h2>
		
		<?php

			$tutorSignup = new Forms($app->connect);
			$tutorSignup->formname = 'becomeatutor';
			$tutorSignup->url = $app->request->getPath();
			$tutorSignup->dependents = $app->dependents;
			$tutorSignup->csrf_key = $csrf_key;
			$tutorSignup->csrf_token = $csrf_token;
			$tutorSignup->killAjax = true;
			if(isset($promocode)){

				$mycode = new stdClass();
				$mycode->promocode = $promocode;
				$tutorSignup->formvalues = $mycode;

			}
			
			$tutorSignup->makeform();

		?>
        
	</div>

	<div class="col s12 m6 l6">
		<h2>Tutor Benefits</h2>
		<ul class="collection">
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> Choose your rate</li>
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> Choose your hours</li>
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> Choose your clients</li>
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> Work remotely or in person</li>
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> Access to teaching resources</li>
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> Network with other tutors</li>
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> <strong>Highest pay percentage in the industry!</strong></li>
		</ul>
		<br/>
		<h2>Application Process</h2>
		<ul class="collection">
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> Submit your application and resume </li>
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> Schedule a phone interview with one of our staff members </li>
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> Mandatory Background Check <span class="green-text">($29.99)</span> </li>
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> Profile Creation </li>
			<li class="collection-item"> <i class="fa fa-check light-green-text accent-2-text"></i> Start Tutoring </li>
		</ul>
		<br>
		<h2>How much can you make?</h2>
		<div class="block">
			<div>Enter a subject and a zip code to find out how much tutors in your area are making.</div>
			<div class="show-prices"></div>
			<?php
				$variablename = new Forms($app->connect);
				$variablename->formname = 'getprices';
				$variablename->url = $app->request->getPath();
				$variablename->dependents = $app->dependents;
				$variablename->csrf_key = $csrf_key;
				$variablename->csrf_token = $csrf_token;
				$variablename->button = 'Get Prices';
				$variablename->classname = 'getprices';
				$variablename->makeform();
			?>
			
		</div>

	</div>

</div>