<?php
	$sitemap = array(
		'/'=>'Homepage',
		'/tutors'=>'Tutors',
		'/jobs'=>'Jobs',
		'/login'=>'Login',
		'/signup/student'=>'Student Signup',
		'/signup/tutor'=>'Tutor Signup',
		'/help'=>'Help',
		'/help/faqs'=>'FAQs',
		//'/help/what-is-amozek'=>'What is Amozek?',
		'/help/how-to-videos'=>'How To Videos',
		'/help/forgot-password'=>'Forgot Password',
		'/help/contact'=>'Contact Us',
		'/help/safety-center'=>'Safety Center',
		'/how-it-works'=>'How It Works',
		'/how-it-works/students'=>'How It Works for <strong>Students</strong>',
		'/how-it-works/tutors'=>'How It Works for <strong>Tutors</strong>',
		'/how-it-works/organizations'=>'How It Works for <strong>Organizations</strong>',
		'/how-it-works/a-message-from-our-ceo'=>'A Message From our CEO',
		'/categories/'=>$app->dependents->SITE_NAME_PROPPER.' Tutored Categories',
		$app->dependents->social->qa.'/'=>'Questions & Answers',
		$app->dependents->social->blog=>'Our Blog',
		'/terms-of-use'=>'Terms of Use',
		'/terms-of-use/privacy-policy'=>'Privacy Policy',
		'/terms-of-use/student-payment-policy'=>'Student Payment Policy',
		'/reviews'=>$app->dependents->SITE_NAME_PROPPER.' Tutoring Reviews',
		'/staff'=>'Our Staff',
		'/find-a-tutor'=>'Find A Tutor',
		'/find-me-a-tutor'=>'Find Me A Tutor',
		'/tutor-finder'=>'Tutor Finder'
	);
?>

<div class="row sitemap">

	<div class="col s12 m4 l4">
		<ul>
			<?php foreach($sitemap as $key => $value): ?>
					<li>
						<a  href="<?php echo $key; ?>"><?php echo $value; ?></a>
					</li>
			<?php endforeach; ?>
		</ul>
	</div>

	<div class="col s12 m4 l4">
		<ul>
			<li><a href="/tutors-by-location"> Tutoring Locations </a></li>
			<li><a href="/tutors-by-city"> Tutors In Your City </a></li>
			<li><a href="/tutors/alabama"> Alabama Tutors </a></li>
			<li><a href="/tutors/alaska"> Alaska Tutors </a></li>
			<li><a href="/tutors/arizona"> Arizona Tutors </a></li>
			<li><a href="/tutors/arkansas"> Arkansas Tutors </a></li>
			<li><a href="/tutors/california"> California Tutors </a></li>
			<li><a href="/tutors/colorado"> Colorado Tutors </a></li>
			<li><a href="/tutors/connecticut"> Connecticut Tutors </a></li>
			<li><a href="/tutors/delaware"> Delaware Tutors </a></li>
			<li><a href="/tutors/district-of-columbia"> District Of Columbia Tutors </a></li>
			<li><a href="/tutors/florida"> Florida Tutors </a></li>
			<li><a href="/tutors/georgia"> Georgia Tutors </a></li>
			<li><a href="/tutors/hawaii"> Hawaii Tutors </a></li>
			<li><a href="/tutors/idaho"> Idaho Tutors </a></li>
			<li><a href="/tutors/illinois"> Illinois Tutors </a></li>
			<li><a href="/tutors/indiana"> Indiana Tutors </a></li>
			<li><a href="/tutors/iowa"> Iowa Tutors </a></li>
			<li><a href="/tutors/kansas"> Kansas Tutors </a></li>
			<li><a href="/tutors/kentucky"> Kentucky Tutors </a></li>
			<li><a href="/tutors/louisiana"> Louisiana Tutors </a></li>
			<li><a href="/tutors/maine"> Maine Tutors </a></li>
			<li><a href="/tutors/maryland"> Maryland Tutors </a></li>
			<li><a href="/tutors/massachusetts"> Massachusetts Tutors </a></li>
			<li><a href="/tutors/michigan"> Michigan Tutors </a></li>
			<li><a href="/tutors/minnesota"> Minnesota Tutors </a></li>
			<li><a href="/tutors/mississippi"> Mississippi Tutors </a></li>
			<li><a href="/tutors/missouri"> Missouri Tutors </a></li>
			<li><a href="/tutors/montana"> Montana Tutors </a></li>
			<li><a href="/tutors/nebraska"> Nebraska Tutors </a></li>
			<li><a href="/tutors/nevada"> Nevada Tutors </a></li>
			<li><a href="/tutors/new-hampshire"> New Hampshire Tutors </a></li>
			<li><a href="/tutors/new-jersey"> New Jersey Tutors </a></li>
			<li><a href="/tutors/new-mexico"> New Mexico Tutors </a></li>
			<li><a href="/tutors/new-york"> New York Tutors </a></li>
			<li><a href="/tutors/north-carolina"> North Carolina Tutors </a></li>
			<li><a href="/tutors/north-dakota"> North Dakota Tutors </a></li>
			<li><a href="/tutors/ohio"> Ohio Tutors </a></li>
			<li><a href="/tutors/oklahoma"> Oklahoma Tutors </a></li>
			<li><a href="/tutors/oregon"> Oregon Tutors </a></li>
			<li><a href="/tutors/pennsylvania"> Pennsylvania Tutors </a></li>
			<li><a href="/tutors/puerto-rico"> Puerto Rico Tutors </a></li>
			<li><a href="/tutors/rhode-island"> Rhode Island Tutors </a></li>
			<li><a href="/tutors/south-carolina"> South Carolina Tutors </a></li>
			<li><a href="/tutors/tennessee"> Tennessee Tutors </a></li>
			<li><a href="/tutors/texas"> Texas Tutors </a></li>
			<li><a href="/tutors/utah"> Utah Tutors </a></li>
			<li><a href="/tutors/virginia"> Virginia Tutors </a></li>
			<li><a href="/tutors/washington"> Washington Tutors </a></li>
			<li><a href="/tutors/west-virginia"> West Virginia Tutors </a></li>
			<li><a href="/tutors/wisconsin"> Wisconsin Tutors </a></li>
			<li><a href="/tutors/wyoming"> Wyoming Tutors </a></li>
		</ul>
	</div>

	<div class="col s12 m4 l4">
		<ul>
			<li><a href="/art-tutors">Art Tutors</a></li>
			<li><a href="/business-tutors">Business Tutors</a></li>
			<li><a href="/college-prep-tutors">College Prep Tutors</a></li>
			<li><a href="/computer-tutors">Computer Tutors</a></li>
			<li><a href="/elementary-education-tutors">Elementary Education Tutors</a></li>
			<li><a href="/english-tutors">English Tutors</a></li>
			<li><a href="/games-tutors">Game Tutors</a></li>
			<li><a href="/history-tutors">History Tutors</a></li>
			<li><a href="/language-tutors">Language Tutors</a></li>
			<li><a href="/math-tutors">Math Tutors</a></li>
			<li><a href="/music-tutors">Music Tutors</a></li>
			<li><a href="/science-tutors">Science Tutors</a></li>
			<li><a href="/special-needs-tutors">Special Needs Tutors</a></li>
			<li><a href="/sports-and-recreation-tutors">Sports And Recreation Tutors</a></li>
			<li><a href="/test-preparation-tutors">Test Preparation Tutors</a></li>
		</ul>
		<ul>
			<li><a href="/categories/art">Art Categories</a></li>
			<li><a href="/categories/business">Business Categories</a></li>
			<li><a href="/categories/college-prep">College Prep Categories</a></li>
			<li><a href="/categories/computer">Computer Categories</a></li>
			<li><a href="/categories/elementary-education">Elementary Education Categories</a></li>
			<li><a href="/categories/english">English Categories</a></li>
			<li><a href="/categories/games">Game Categories</a></li>
			<li><a href="/categories/history">History Categories</a></li>
			<li><a href="/categories/language">Language Categories</a></li>
			<li><a href="/categories/math">Math Categories</a></li>
			<li><a href="/categories/music">Music Categories</a></li>
			<li><a href="/categories/science">Science Categories</a></li>
			<li><a href="/categories/special-needs">Special Needs Categories</a></li>
			<li><a href="/categories/sports-and-recreation">Sports And Recreation Categories</a></li>
			<li><a href="/categories/test-preparation">Test Preparation Categories</a></li>
		</ul>

		<?php if(isset($app->searchresults)): ?>
			<ul>
				<?php foreach($app->searchresults as $searchresults): ?>
					<li>
						<a href="<?php echo $searchresults->link; ?>">
							<?php echo $searchresults->text; ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

	</div>

</div>
