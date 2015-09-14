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
				<img src="/images/homepage-slides/city.jpg">
			</li>
			<li>
				<img src="/images/homepage-slides/fog.jpg">
			</li>
			<li>
				<img src="/images/homepage-slides/forest.jpg">
			</li>
			<li>
				<img src="/images/homepage-slides/golden-gate.jpg">
			</li>
			<li>
				<img src="/images/homepage-slides/hilltop.jpg">
			</li>
			<li>
				<img src="/images/homepage-slides/mountains.jpg">
			</li>
			<li>
				<img src="/images/homepage-slides/plains.jpg">
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

<?php if(isset($app->contest->ipadgiveaway)): ?>
<div class="win-an-ipad-mini">
	<?php
		$todaysdate = thedate();
		$conestdate = '2015-11-21 11:00:00';
		$contestinhowmany = sessionDateDiff($conestdate);
	?>

	<div class="row">
		<div class="col s12 m8 l8">
			<div class="waim-title">iPad Mini Giveaway</div>
			<div class="waim-countdown"><?php echo ucwords($contestinhowmany->text); ?> Till Drawing</div>
			
			<div class="waim-button">
				<a class="btn orange" href="/contest">Signup Now</a>
			</div>
			<div class="waim-deadline">
				
				<p>Terms & Conditions Apply</p>
				<p>Something Something Text</p>
				<p>Deadline & Drawing November 21, 2015 @ 11:00 AM Arizona Mountain Time</p>
				
			</div>
		</div>
		<div class="col s12 m4 l4">
			<img src="/images/contest/ipad-giveaway.png" class="responsive-img" />
		</div>
	</div>
	
	
</div>
<?php endif; ?>

<div class="homepage-benefits">
	
	<div class="row">
		<div class="col s12 m6 l6">
		<h2>Why <?php echo $app->dependents->SITE_NAME_PROPPER; ?>?</h2>
			<ul class="collection">
				<li class="collection-item">
					<div class="row">
						<div class="col s1 m1 l1 ">
							<i class="fa fa-shield"></i>
						</div>
						<div class="col s11 m11 l11">
							All of our tutors are interviewed and background checked
						</div>
					</div>
				</li>
				
				<li class="collection-item">
					<div class="row">
						<div class="col s1 m1 l1 ">
							<i class="fa fa-dollar"></i>
						</div>
						<div class="col s11 m11 l11">
							We pay our tutors the most, so we have the best tutors
						</div>
					</div>
				</li>
				
				<li class="collection-item">
					<div class="row">
						<div class="col s1 m1 l1 ">
							<i class="fa fa-users"></i>
						</div>
						<div class="col s11 m11 l11">
							We stand behind both our students and our tutors
						</div>
					</div>
				</li>
				
				<li class="collection-item">
					<div class="row">
						<div class="col s1 m1 l1 ">
							<i class="fa fa-book"></i>
						</div>
						<div class="col s11 m11 l11">
							We enable more than just academic learning, we offer <span class="green-text">anything-learning</span>
						</div>
					</div>
				</li>
				
				<li class="collection-item">
					<div class="row">
						<div class="col s1 m1 l1 ">
							<i class="fa fa-question"></i>
						</div>
						<div class="col s11 m11 l11">
							<a href="/how-it-works">Find Out More</a>
						</div>
					</div>
				</li>
				
				<li class="collection-item homepage-signup">
					<div class="signup-today">Signup Today</div>
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
				</li>
				
			</ul>
		</div>
		<div class="col s12 m6 l6">
	
			<h2>Top Tutored Subjects</h2>
			<ul class="collection">
				<?php foreach($app->topsubjects as $topsubjects): ?>
					<li class="collection-item">
						<a href="/categories/<?php echo $topsubjects->parent_slug; ?>/<?php echo $topsubjects->subject_slug; ?>"><?php echo $topsubjects->subject_name; ?></a>
						<span class="badge blue white-text"><?php echo $topsubjects->count; ?></span>
					</li>
				<?php endforeach; ?>
				<li class="collection-item">
					<a href="/categories/">
						View All Categories
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>

<?php if(isset($app->toptutors)): ?>
<div class="top-tutors">
	<h2 class="center-align">Top <?php if(isset($app->topsubjectname)){ echo $app->topsubjectname;} ?> Tutors</h2>
	
	<div class="row">
		
		<?php foreach($app->toptutors as $toptutors):
			
			$query = $app->connect->createQueryBuilder();
			$subjects = $query->select('*')
				->from('avid___user_subjects')
				->where('email = :email')
				->setParameter(':email',$toptutors->email)
				->orderBy('last_modified', 'ASC')
				->setMaxResults(7)
				->execute()
				->fetchAll();
				if(count($subjects)>0){
					$toptutors->subjects = $subjects;
				}
			
		?>
		
		<div class="col s12 m6 l4 center-align">
			<div class="row">
				<div class="col s12 m3 l4">
					<?php
						$userinfo = $toptutors;
						include($app->dependents->APP_PATH.'includes/user-profile/user-block.php');
					?>
				</div>
				<div class="col s12 m9 l8 left-align">
					<?php if(isset($toptutors->subjects[0])): ?>
					<div class="short-description">My Areas of Expertise</div>
					<div class="tutor-results-subjects">
						<?php echo showsubjects($toptutors->subjects,5); ?>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		
		<?php endforeach; ?>
	
		<div class="center-align"><a class="btn" href="<?php echo $app->topsuburl; ?>">View More <?php if(isset($app->topsubjectname)){ echo $app->topsubjectname;} ?> Tutors</a></div>
		
	</div>
	
</div>
<?php endif; ?>

<?php if(isset($app->students)): ?>
<div class="homepagewide open-jobs">
	<h2 class="center-align">Open Tutoring Jobs</h2>
	
	<div class="row">
		<?php foreach($app->students as $job): ?>
		
			<div class="col s12 m6 l4">
				
				<div class="block block-inside jobs-block">
				
					<div class="title">
						<a href="/jobs/apply/<?php echo $job->id; ?>">
							<strong><?php echo $job->subject_name; ?> Job</strong>
						</a>
					</div>
					
					<div class="description">
						<?php echo truncate($job->job_description,80); ?>
					</div>
					
					<div class="block-bottom">
						<?php if(isset($job->type)): ?>
						<div>
							I'm looking for <strong><?php echo strtolower(online_tutor($job->type)); ?></strong> tutoring
						</div>
						<?php endif; ?>
						
						
						<div>
							<?php echo $job->city; ?> <?php echo ucwords($job->state_long); ?>,  <?php echo $job->zipcode; ?>
						</div>
						
						<?php if(isset($job->skill_level)): ?>
						<div>
							My Skill Level: <?php echo $job->skill_level; ?>
						</div>
						<?php endif; ?>
						
						<div>
							Posted by ~
							<?php if(isset($app->user->email)): ?>
							<a href="<?php echo $job->url; ?>">
								<?php
									if($job->showfullname=='yes'){
										echo $job->first_name.' '.$job->last_name;
									}
									else{
										echo short($job);	
									}
									
								?>
							</a>
							<?php else: ?>
							<?php
								if($job->showfullname=='yes'){
									echo $job->first_name.' '.$job->last_name;
								}
								else{
									echo short($job);	
								}
								
							?>
							<?php endif; ?>
							
							<span class="date"><?php echo formatdate($job->date, 'M. jS, Y @ g:i a'); ?></span>
						</div>
					</div>
					
				</div>
				
			</div>
		
		<?php endforeach; ?>
		<div class="homepagewide center-align"><a class="btn" href="/jobs">View More Jobs</a></div>
	</div>
</div>
<?php endif; ?>

<div class="row">
	<div class="col s12 m6 l6">
		<?php if(isset($app->feed->items[0])): ?>
			<div class="homepagewide">
				<h2>Questions & Answers</h2>	
				<ul class="collection">
					<?php foreach($app->feed->items as $key=> $item):  ?>
					<li class="collection-item">
						<a href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
					</li>
					<?php if($key==4){break;} ?>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
		<div>&nbsp;<br> <div class="center-align"><a class="btn qa-btn" href="<?php echo $app->dependents->social->qa; ?>/">View More Questions & Answers</a></div></div>
	</div>
	<div class="col s12 m6 l6">
		<h2>Motivation</h2>
		<div class="motivation blue">
			<div class="motivation-quote"><i class="fa fa-quote-left"></i><?php echo $app->cachedmotivation->quote; ?><i class="fa fa-quote-right"></i></div>
			<div class="motivation-author"><?php echo $app->cachedmotivation->author; ?></div>
		</div>
	</div>
</div>


<style type="text/css">
.collection .homepage-signup{
	padding: 10px;
}
.homepage-signup .form-parent{
	float: none;
}
.homepage-signup .form-parent form{
	border: none;
	margin: 0px;
	padding: 0px;
}
.signup-today{
	font-weight: bold;
	margin-bottom: 5px;
}
.homepage-signup .notify-user{
	display: none !important;
}
</style>