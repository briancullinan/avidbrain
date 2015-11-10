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

<div class="container notoppadd subjects-we-offer">
	<h2 class="center-align">What Subjects Do We Offer?</h2>
	<div class="the-subjects-we-offer">

		<div class="row">

			<?php
				$swo = array();
				$swo[] = (object)array(
					'title'=>'English',
					'mainlink'=>'/english-tutors',
					'class'=>'liberalarts',
					'links'=>array(
						'/categories/english/literature'=>'English Literature',
						'/categories/language'=>'Modern Languages',
						'/history-tutors'=>'History',
						'/categories/science/philosophy'=>'Philosophy',
						'/categories/history/anthropology'=>'Anthropology',
						'/categories/business/economics'=>'Economics',
						'/categories/history/geography'=>'Geography',
						'/categories/business/economics'=>'Economics',
						'/categories/science/sociology'=>'Sociology',
						'/categories/art'=>'and many more!'
					)
				);

				$swo[] = (object)array(
					'title'=>'Science',
					'mainlink'=>'/science-tutors',
					'class'=>'science',
					'links'=>array(
						'/categories/science/biology'=>'Biology',
						'/categories/science/chemistry'=>'Chemistry',
						'/categories/science/organic-chemistry'=>'Organic Chemistry',
						'/categories/science/physics'=>'Physics',
						'/categories/science/geology'=>'Geology',
						'/categories/science/act-science'=>'ACT Science',
						'/categories/science/nutrition'=>'Nutrition',
						'/categories/science/neuroscience'=>'Neuroscience',
						'/categories/science'=>'and many more!'
					)
				);

				$swo[] = (object)array(
					'title'=>'Math',
					'mainlink'=>'/math-tutors',
					'class'=>'math',
					'links'=>array(
						'/categories/math/algebra-1'=>'Algebra',
						'/categories/math/trigonometry'=>'Trigonometry',
						'/categories/math/calculus'=>'Calculus',
						'/categories/math/sat-math'=>'SAT Math',
						'/categories/math/statistics'=>'Statistics',
						'/categories/math/probability'=>'Probability',
						'/categories/math/differential-equations'=>'Differential Equations',
						'/categories/business/finance'=>'Finance',
						'/categories/math'=>'and many more!'
					)
				);

				$swo[] = (object)array(
					'title'=>'Test Prep',
					'mainlink'=>'/test-preparation-tutors',
					'class'=>'testprep',
					'links'=>array(
						'/categories/test-preparation/gre'=>'GRE',
						'/categories/test-preparation/gmat'=>'GMAT',
						'/categories/test-preparation/lsat'=>'LSAT',
						'/categories/test-preparation/mcat'=>'MCAT',
						'/categories/test-preparation/ssat'=>'SSAT',
						'/categories/test-preparation/act-math'=>'ACT Math',
						'/categories/test-preparation/toefl'=>'TOEFL',
						'/categories/test-preparation/ged'=>'GED',
						'/categories/test-preparation/psat'=>'PSAT',
						'/categories/test-preparation'=>'and many more!'
					)
				);

			?>

			<?php foreach($swo as $swoitems): ?>
			<div class="col s12 m12 l6">
				<div class="block">
					<div class="row">
						<div class="col s12 m6 l6">
							<div class="tswo-title valign-wrapper <?php echo $swoitems->class; ?>">
								<div class="valign">
									<a href="<?php echo $swoitems->mainlink; ?>">
										<?php echo $swoitems->title; ?>
									</a>
								</div>
							</div>
						</div>
						<div class="col s12 m6 l6">
							<div class="tswo-text">
								<?php
									$counting = count($swoitems->links);
									$start = 1;
								?>
								<?php foreach($swoitems->links as $key=> $sublink): ?>
								<a href="<?php echo $key; ?>">
									<?php echo $sublink; ?><?php if($counting!=$start){echo ',';} ?>
								</a>
								<?php
									$start++;
								?>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php endforeach; ?>

		</div>

	</div>

	<div class="view-more"><a href="/categories">More Subjects</a></div>

</div>

<div class="homepage-wide">
	<div class="container notoppadd center-align white-text">
		<div class="wide-copy">AvidBrain is the leader in on-demand tutoring where all of our tutors are both interviewed and background checked.  We’ll have you learning what you want to learn in no time at all.</div>

		<div class="row">
			<div class="col s12 m6 l6">
				<div class="info-block">
					Trusted Instructors
				</div>
			</div>
			<div class="col s12 m6 l6">
				<div class="info-block">
					Available When Needed
				</div>
			</div>
			<div class="col s12 m6 l6">
				<div class="info-block">
					Affordable Pricing
				</div>
			</div>
			<div class="col s12 m6 l6">
				<div class="info-block">
					Friendly Customer Service
				</div>
			</div>
			<div class="col s12 m6 l6">
				<div class="info-block">
					Money-back Guarantee
				</div>
			</div>
			<div class="col s12 m6 l6">
				<div class="info-block">
					Flexible Scheduling
				</div>
			</div>
		</div>

	</div>
</div>

<?php if(isset($postajob)): ?>
	<div class="container signup-post-a-job">
		<div class="row">
			<div class="col s12 m6 l6">
				<h2>Post A Job</h2>
				<div class="block">
					<?php include($app->dependents->APP_PATH.'includes/jobs/postajob.php'); ?>
				</div>
			</div>
			<div class="col s12 m6 l6">
				<h2>Find A Tutor</h2>
				<div class="block">
					Show Advanced Find A Tutor
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<div class="fullsize featured-tutor valign-wrapper">


</div>

<?php if(isset($app->featuredhomepagetutor->url)): ?>
<div class="fullsize featured-tutor">
	<div class="row ">
		<div class="col s12 m4 l3">
			<div class="featured-tutor-text">
				<h2>Featured Tutor</h2>
			</div>
		</div>
		<div class="col s12 m8 l9 featured-col">
			<div class="featured-tutor-container">
				<div class="featured-tutor-inside">
					<div class="row">
						<div class="col s12 m4 l4">
							<div class="user-photograph">
								<a href="<?php echo $app->featuredhomepagetutor->url; ?>"><img class="avatarbg responsive-img " src="<?php echo $app->featuredhomepagetutor->myphoto; ?>" /></a>
							</div>
							<?php if(isset($app->featuredhomepagetutor->starscore)): ?>
							<div class="featured-tutor-score">
								<?php echo average_stars($app->featuredhomepagetutor->starscore); ?>
							</div>
							<?php endif; ?>
						</div>
						<div class="col s12 m8 l8">
							<div class="featured-tutor-name"><a href="<?php echo $app->featuredhomepagetutor->url; ?>"><?php echo short($app->featuredhomepagetutor); ?></a></div>
							<div class="featured-tutor-location"><?php echo ucwords($app->featuredhomepagetutor->city); ?> <span><?php echo ucwords($app->featuredhomepagetutor->state_long); ?></span></div>
							<div class="featured-tutor-subjects">
								<?php foreach($app->featuredhomepagetutor->subjects as $sub): ?>
									<?php echo $sub->subject_name; ?>,
								<?php endforeach; ?>
							</div>
							<div class="featured-tutor-about">
								<?php echo truncate($app->featuredhomepagetutor->personal_statement_verified,500); ?>
							</div>
							<div class="featured-tutor-link">
								<a href="<?php echo $app->featuredhomepagetutor->url; ?>">View Full Profile</a>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
