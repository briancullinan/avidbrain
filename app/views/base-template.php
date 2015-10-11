<!DOCTYPE html>
<!-- <?php echo $app->dependents->headerinfo; ?>

-->
<html>
<head>
	<title><?php if(isset($app->meta->title)){ echo strip_tags($app->meta->title);}else{ echo $app->dependents->SITE_NAME; } ?></title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="application-name" content="<?php echo $app->dependents->SITE_NAME; ?>" />
	<meta name="description" content="<?php if(isset($app->meta->description)){echo $app->meta->description;}else{ echo $app->dependents->SITE_NAME_PROPPER.' Tutoring. Find A Tutor. Become a Tutor.'; } ?>" />
	<meta name="keywords" content="<?php if(isset($app->meta->keywords)){echo $app->meta->keywords;}else{echo $app->dependents->SITE_NAME_PROPPER.','.$app->dependents->SITE_NAME.',avid,brain,tutor,tutoring,education';} ?>" />

	<meta name="author" content="<?php echo $app->dependents->SITE_NAME_PROPPER; ?> inc." />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<link rel="icon" type="image/png" href="/images/favicon.ico" />
<?php

// CDN CSS
foreach($app->header->cdncss as $cdncss){
	echo "\t".'<link rel="stylesheet" href="'.$cdncss.'">'."\n";
}

if(isset($app->minify)):
	echo "\t".'<link rel="stylesheet" href="/css/final.'.$app->dependents->VERSION.'.css">'."\n";
else:
	foreach($app->header->localcss as $localcss){
		echo "\t".'<link rel="stylesheet" href="/css/'.$localcss.'">'."\n";
	}
endif;

// Header JS
foreach($app->header->headjs as $localjs){
	echo "\t".'<script src="'.$localjs.'"></script>'."\n";
}

echo '	<script type="text/javascript">Stripe.setPublishableKey("'.$app->dependents->stripe->STRIPE_PUBLIC.'");</script>'."\n";

	$openClosed = NULL;
	$hideSearch = $app->getCookie('hideSearch');
	if(empty($hideSearch)){
		$openClosed = "open";
	}
	elseif(isset($hideSearch) && $hideSearch=='true'){
		$openClosed = 'closed';
	}
	elseif(isset($hideSearch) && $hideSearch=='false'){
		$openClosed = 'open';
	}
	$app->mylocation = json_decode($app->getCookie('mylocation'));
?>
</head>
<body class="<?php if(isset($app->secondary) && file_exists($app->secondary)){ echo 'sub-active';} if(isset($app->user->email)){ echo ' active-user ';} echo ' page--'.str_replace('-','',$app->target->css).' '; ?>">
	<?php if(empty($app->mylocation)){ echo '<div class="getgeoloc"></div>';} ?>
	<navigation>

		<div class="navigation-left">
			<?php if($app->dependents->SITE_NAME=='amozek'): ?>
			<logo>
				<a href="/">
					<span class="icon amozek"></span>
					<span class="logo">am<span>o</span>zek</span>
				</a>
			</logo>
			<?php elseif($app->dependents->SITE_NAME=='avidbrain'): ?>
			<logo class="avidbrain">
				<a href="/">
					avidbrain
				</a>
			</logo>
			<?php endif; ?>
			<?php include($app->dependents->APP_PATH.'navigation/navigation.basics.php'); ?>
			<ul>
				<?php foreach($app->leftnav as $key=> $navitem): ?>
				<li>
					<a class="<?php if(myrootisyourroot($app->request->getPath(),$key)){ echo ' active ';} if(isset($navitem->class)){ echo $navitem->class; } ?>" href="<?php echo $key; ?>">
						<?php echo $navitem->name; ?>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
			<div class="global-search left">
				<form method="post" action="/tutors">
					<div class="input-field"><input type="text" name="search[search]" id="globalsearch" placeholder="Search for a tutor" value="<?php if(isset($app->search->search)){ echo $app->search->search; } ?>" class="search-bar" /></div>
					<button type="submit" class="btn-floating btn-small waves-effect waves-light blue"><i class="fa fa-search"></i></button>
					<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
					<input type="hidden" name="search[target]" value="search">
				</form>
			</div>
		</div>

		<?php if(isset($app->secondary) && file_exists($app->secondary)): ?>
		<div class="navigation-right">
			<?php include($app->secondary); ?>
		</div>
		<?php if(isset($app->tertiary) && file_exists($app->tertiary)): ?>
		<div class="navigation-right tertiary">
			<?php include($app->tertiary); ?>
		</div>
		<?php endif; ?>
		<?php elseif(isset($app->secondary) && $app->dependents->DEBUG==true): ?>
			<?php coder($app->secondary); ?>
		<?php endif; ?>

	</navigation>

	<main>

		<?php if(isset($app->howitworks)){ include($app->dependents->APP_PATH.'includes/how-it-works/how-it-works.php'); } ?>
		<?php if(isset($_SESSION['slim.flash']['error'])): ?>
			<div class="say-message"><div class="the-message show-message"><?php echo $_SESSION['slim.flash']['error']; ?></div></div>
			<?php
				unset($_SESSION['slim.flash']['error']);
				$_SESSION['slim.flash']['error'] = NULL;
			?>
		<?php endif; ?>
		<div class="main-content <?php echo $app->target->css; ?>">
			<div class="inside-content">
				<?php if(isset($app->user->email) && $doihaveerrors = crediterror($app->connect,$app->user->email,true)): ?>
				<div class="credit-errors">
					<?php if(isset($doihaveerrors->message)):?>
						<?php echo $doihaveerrors->message; ?>
					<?php endif; ?>
					<?php if(isset($doihaveerrors->date)):?>
						<span><?php echo formatdate($doihaveerrors->date); ?></span>
					<?php endif; ?>
					<div><a class="btn btn-s red white-text" href="/payment/credit-card">Update Payment Info</a></div>

				</div>
				<?php endif; ?>

				<?php if(isset($app->meta->h1) && $app->meta->h1==false): ?>

				<?php elseif(isset($app->meta->h1)): ?>
					<h1><?php echo $app->meta->h1; ?></h1>
				<?php elseif(isset($app->meta->title)): ?>
					<h1><?php echo $app->meta->title; ?></h1>
				<?php endif; ?>
				<?php
					if(isset($app->target->include) && file_exists($app->target->include)){
						include($app->target->include);
					}
					elseif(isset($app->target->include) && !file_exists($app->target->include) && $app->dependents->DEBUG==true){
						include($app->dependents->APP_PATH.'debug/makeme.php');
					}
					else{
						echo 'makeme';
					}
				?>
			</div>
		</div>

		<footer>
			<div class="row">
					<div class="col s12 m3 l3">
						<h5 class="white-text">Important Things</h5>
						<?php if(isset($app->footerlinks)): ?>
						<ul class="footer-li">
							<?php foreach($app->footerlinks as $key=> $navitem): ?>
							<li>
								<a class="<?php if(myrootisyourroot($app->request->getPath(),$key)){ echo ' active ';} if(isset($navitem->class)){ echo $navitem->class; } ?>" href="<?php echo $key; ?>">
									<?php echo $navitem->name; ?>
								</a>
							</li>
							<?php endforeach; ?>
						</ul>
						<?php endif; ?>
					</div>
					<div class="col s12 m3 l3">
						<h5 class="white-text">Find Out More</h5>
						<?php if(isset($app->leftnav)): ?>
						<ul class="footer-li">
							<?php foreach($app->leftnav as $key=> $navitem): ?>
							<li>
								<a class="<?php if(myrootisyourroot($app->request->getPath(),$key)){ echo ' active ';} if(isset($navitem->class)){ echo $navitem->class; } ?>" href="<?php echo $key; ?>">
									<?php echo $navitem->name; ?>
								</a>
							</li>
							<?php endforeach; ?>
						</ul>
						<?php endif; ?>
					</div>
					<div class="col s12 m3 l3">
						<h5 class="white-text"><?php echo $app->dependents->SITE_NAME_PROPPER; ?> Headquarters</h5>
						<div class="grey-text">
							<a href="https://www.google.com/maps/place/Regus+Scottsdale/@33.495696,-111.924473,17z/data=!4m6!1m3!3m2!1s0x872b0bbf1d86c0fd:0xae8864ada3178e8f!2sRegus+Scottsdale!3m1!1s0x872b0bbf1d86c0fd:0xae8864ada3178e8f" target="_blank">7272 E. Indian School Rd. Suite 540  <br>
							Scottsdale, AZ 85251</a>
						</div>
					</div>
					<div class="col s12 m3 l3">
						<h5 class="white-text">Follow Us</h5>
						<ul class="follow-us">
							<li>
								<a href="<?php echo $app->dependents->social->facebook; ?>" target="_blank"><i class="fa fa-facebook"></i></a>
							</li>
							<li>
								<a href="<?php echo $app->dependents->social->twitter; ?>" target="_blank"><i class="fa fa-twitter"></i></a>
							</li>
							<li>
								<a href="<?php echo $app->dependents->social->linkedin; ?>" target="_blank"><i class="fa fa-linkedin"></i></a>
							</li>
							<li>
								<a href="<?php echo $app->dependents->social->pinterest; ?>" target="_blank"><i class="fa fa-pinterest"></i></a>
							</li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col s12 m6 l6">
						<div class="av-versioning">
							<?php echo $app->dependents->SITE_NAME_PROPPER; ?> inc. &copy; All rights reserved <?php echo date('Y'); ?>
							<span class="version">Version <?php echo $app->dependents->VERSION; ?></span>
						</div>
					</div>
					<div class="col s12 m6 l6 right-align">
						<span class="godaddy">
							<img src="/images/godaddy.gif"/>
						</span>
					</div>
				</div>
			</div>
		</footer>
	</main>

	<div class="trigger<?php if(isset($app->user->email)){ echo '-user';} ?>">
		<div class="activate-mobile" data-status="closed"><i class="fa fa-bars"></i></div>
		<?php if(isset($app->user->email)): ?>
		<?php include('user-dropdown.php'); ?>
		<?php else: ?>
		<div class="mobile-logo"><a href="/"><?php echo $app->dependents->SITE_NAME_PROPPER; ?></a></div>
		<?php endif; ?>
	</div>

	<?php if(empty($app->user->email)): ?>

		<div id="loginModule" class="modal">
			<div class="modal-content">
				<h4><?php echo $app->dependents->SITE_NAME_PROPPER; ?> Login</h4>
			</div>

				<div class="row">
					<div class="col s12 m8 l8">
						<?php
							$thelogin = new Forms($app->connect);
							$thelogin->formname = 'login';
							$thelogin->url = '/login';
							$thelogin->dependents = $app->dependents;
							$thelogin->csrf_key = $csrf_key;
							$thelogin->csrf_token = $csrf_token;
							$thelogin->button = 'Login';
							$thelogin->makeform();
						?>
					</div>
					<div class="col s12 m4 l4">
						<a href="/help/forgot-password" class="btn orange btn-block">Forgot Password?</a>
						<a href="/signup" class="btn btn-block blue">Signup</a>
					</div>
				</div>

			<div class="modal-footer">
				<a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat "> <i class="fa fa-times"></i> Dismiss </a>
			</div>
		</div>

	<?php endif; ?>

	<div id="bgcheck_modal" class="modal">
		<div class="modal-content">
			<h4> <i class="mdi-action-assignment-ind"></i> Background Checks</h4>

			<p>At <?php echo $app->dependents->SITE_NAME_PROPPER; ?>, we require all of our tutors to be background checked to ensure the safety of our students. By requiring all tutors to go through a thorough background check, we create a place that is both safe and an effective environment for our students.</p>

		</div>

		<div class="modal-footer">
			<a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">OK, Thanks</a>
		</div>
	</div>

	<div id="myrank" class="modal">
		<div class="modal-content">

			<h4><?php echo $app->dependents->SITE_NAME_PROPPER; ?> Ranking</h4>

			<div class="row">
				<div class="col s12 m4 l4">
					<p>At <?php echo $app->dependents->SITE_NAME_PROPPER; ?>, we rank all of our tutors with ranks and ranks and ranks and ranks.</p>
					<p><a href="/signup/tutor">Get Ranked</a></p>
				</div>
				<div class="col s12 m8 l8">
					<ul class="collection">
						<li class="collection-item badge-new-user">
							<div class="row">
								<div class="col s12 m6 l6">

									<div class="row">
										<div class="col s2 m2 l2">
											<i class="fa fa-check"></i>
										</div>
										<div class="col s10 m10 l10">
											New User
										</div>
									</div>

								</div>
								<div class="col s12 m6 l6">
									0 - 50 Hours
								</div>
							</div>
						</li>
						<li class="collection-item badge-instructor">
							<div class="row">
								<div class="col s12 m6 l6">

									<div class="row">
										<div class="col s2 m2 l2">
											<i class="fa fa-certificate"></i>
										</div>
										<div class="col s10 m10 l10">
											Instructor
										</div>
									</div>

								</div>
								<div class="col s12 m6 l6">
									51 - 200 Hours
								</div>
							</div>
						</li>
						<li class="collection-item badge-teachers-assistant">
							<div class="row">
								<div class="col s12 m6 l6">
									<div class="row">
										<div class="col s2 m2 l2">
											<i class="fa fa-bolt"></i>
										</div>
										<div class="col s10 m10 l10">
											Teacher's Assistant
										</div>
									</div>
								</div>
								<div class="col s12 m6 l6">
									201 - 1,000 Hours
								</div>
							</div>
						</li>
						<li class="collection-item badge-teacher">
							<div class="row">
								<div class="col s12 m6 l6">

									<div class="row">
										<div class="col s2 m2 l2">
											<i class="fa fa-rocket"></i>
										</div>
										<div class="col s10 m10 l10">
											Teacher
										</div>
									</div>

								</div>
								<div class="col s12 m6 l6">
									1,001 - 2,000 Hours
								</div>
							</div>
						</li>
						<li class="collection-item badge-assistant-professor">
							<div class="row">
								<div class="col s12 m6 l6">

									<div class="row">
										<div class="col s2 m2 l2">
											<i class="fa fa-trophy"></i>
										</div>
										<div class="col s10 m10 l10">
											Assistant Professor
										</div>
									</div>

								</div>
								<div class="col s12 m6 l6">
									2,001 - 4,000 Hours
								</div>
							</div>
						</li>
						<li class="collection-item badge-associate-professor">
							<div class="row">
								<div class="col s12 m6 l6">

									<div class="row">
										<div class="col s2 m2 l2">
											<i class="fa fa-star"></i>
										</div>
										<div class="col s10 m10 l10">
											Associate Professor
										</div>
									</div>

								</div>
								<div class="col s12 m6 l6">
									4,001 - 6,000 Hours
								</div>
							</div>
						</li>
						<li class="collection-item badge-professor">
							<div class="row">
								<div class="col s12 m6 l6">

									<div class="row">
										<div class="col s2 m2 l2">
											<i class="fa fa-university"></i>
										</div>
										<div class="col s10 m10 l10">
											Professor
										</div>
									</div>

								</div>
								<div class="col s12 m6 l6">
									6,001 - 12,000 Hours
								</div>
							</div>
						</li>
						<li class="collection-item badge-mad-scientist">
							<div class="row">
								<div class="col s12 m6 l6">

									<div class="row">
										<div class="col s2 m2 l2">
											<i class="fa fa-flask"></i>
										</div>
										<div class="col s10 m10 l10">
											Mad Scientist
										</div>
									</div>

								</div>
								<div class="col s12 m6 l6">
									12,001+ Hours
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>

		</div>

		<div class="modal-footer">
			<a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">OK, Thanks</a>
		</div>
	</div>
<?php
// CDN JS
foreach($app->header->cdnjs as $cdnjs){
	echo "\t".'<script src="'.$cdnjs.'"></script>'."\n";
}

if(isset($app->minify)):
	echo "\t".'<script src="/js/final.'.$app->dependents->VERSION.'.js"></script>'."\n";
else:
	// Local JS
	foreach($app->header->localjs as $localjs){
		echo "\t".'<script src="/js/'.$localjs.'"></script>'."\n";
	}
endif;
?>
<?php if($app->dependents->DEBUG!=true): ?>
<script src="https://static.getclicky.com/js" type="text/javascript"></script>
<script type="text/javascript">try{ clicky.init(100807251); }catch(e){}</script>
<noscript><p><img alt="Clicky" width="1" height="1" src="https://in.getclicky.com/100807251ns.gif" /></p></noscript>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-62466709-1', 'auto');
  ga('send', 'pageview');
</script>
<?php endif; ?>
<noscript><link rel="stylesheet" href="/css/scripts-required.css"><div class="js-required">Javascript Is Required. Please Enable.</div></noscript>
</body>
</html>
