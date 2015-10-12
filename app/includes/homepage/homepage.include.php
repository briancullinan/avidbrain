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
					'title'=>'Liberal Arts',
					'mainlink'=>'/liberal-arts-tutors',
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
							<div class="profile-image center-align avatar">
								<a href="/tutors/idaho/moscow/31303039"><img class="avatarbg responsive-img " src="/images/featured-tutors/ross-m.jpg" /></a>
							</div>
							<div class="featured-tutor-score">
								<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
							</div>
						</div>
						<div class="col s12 m8 l8">
							<div class="featured-tutor-name"><a href="/tutors/idaho/moscow/31303039">Ross M</a></div>
							<div class="featured-tutor-location">Moscow <span>Idaho</span></div>
							<div class="featured-tutor-subjects">
								Physics, Calculus, Geometry, Prealgebra, Precalculus, Trigonometry, Statistics, SAT Math, Probability, Elementary Math, ACT Math, Study Skills, Algebra 1, Algebra 2
							</div>
							<div class="featured-tutor-about">
								I love tutoring! I enjoy helping others learn new skills and gain more knowledge. I personalize instruction for every individual I work with and focus on encouraging independent learning skills to ensure a life-long ability to learn. I have five years experience tutoring algebra, calculus, and physics! I have spent the last two years tutoring at Allan Hancock College discovering different learning styles and helping students increase their understanding and their grades. I have flexible rates for individuals and groups so don't be afraid to ask. I can't wait to help you succeed today!
							</div>
							<div class="featured-tutor-link">
								<a href="/tutors/idaho/moscow/31303039">View Full Profile</a>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
