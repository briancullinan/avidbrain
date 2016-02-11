<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($app->meta->title)){ echo strip_tags($app->meta->title);}else{ echo SITENAME; } ?></title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="application-name" content="<?php echo SITENAME; ?>" />
	<meta name="description" content="<?php if(isset($app->meta->description)){echo $app->meta->description;}else{ echo SITENAME_PROPPER.' Tutoring. Find A Tutor. Become a Tutor.'; } ?>" />
	<meta name="keywords" content="<?php if(isset($app->meta->keywords)){echo $app->meta->keywords;}else{echo SITENAME_PROPPER.','.SITENAME.',avid,brain,tutor,tutoring,education';} ?>" />
	<meta name="author" content="<?php echo SITENAME_PROPPER; ?> inc." />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<link rel="icon" type="image/png" href="/images/favicon.ico" />



<?php

// CDN CSS
foreach($app->header->cdncss as $cdncss){
	echo "\t".'<link rel="stylesheet" href="'.$cdncss.'">'."\n";
}

if(isset($app->minify)):
	echo "\t".'<link rel="stylesheet" href="/css/final.'.VERSION.'.css">'."\n";
else:
	foreach($app->header->localcss as $localcss){
		echo "\t".'<link rel="stylesheet" href="/css/'.$localcss.'">'."\n";
	}
endif;

// Header JS
foreach($app->header->headjs as $localjs){
	echo "\t".'<script src="'.$localjs.'"></script>'."\n";
}

echo '	<script type="text/javascript">Stripe.setPublishableKey("'.STRIPE_PUBLIC.'");</script>'."\n";

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
<body class="body <?php if(isset($app->secondary) && file_exists($app->secondary)){ echo 'sub-active';} if(isset($app->user->email)){ echo ' active-user ';} echo ' page--'.str_replace('-','',$app->target->css).' '; ?>">

<header class="itstheheader">



	<div class="logo logo-affiliate">
		<a href="/"><img src="/images/avidbrainlogo.png" /></a>
	</div>

	<div class="right-info">
		<div class="right user-dropdown-container">
			<a class="dropdown-button left" href="#" data-activates="user-dropdown">
				<div class="dropdown-item">
					<span class="fa-stack fa-lg">
						<i class="fa fa-circle-thin fa-stack-2x"></i>
						<i class="fa fa-user fa-stack-1x"></i>
					</span>
					<span class="my-name"><?php echo $app->affiliate->email; ?></span>
				</div>
				<div class="dropdown-sort"><i class="fa fa-sort-down"></i> </div>
			</a>
		</div>

		<?php
			$affiliateDrop = array(
				'/'=>'Dashboard',
				'/affiliates/information'=>'Your Information'
			);
		?>

		<ul id="user-dropdown" class="dropdown-content">
			<?php foreach($affiliateDrop as $key => $value): ?>
				<li <?php if($app->request->getPath()==$key){ echo 'class="active"';} ?>>
					<a href="<?php echo $key; ?>">
						<?php echo $value; ?>
					</a>
				</li>
			<?php endforeach; ?>

			<li class="dll-logout">
				<a href="/logout">
					<i class="mdi-action-exit-to-app"></i> Logout
				</a>
			</li>
		</ul>

	</div>




</header>


<main>

	<div class="container">
		<?php include('wild.pages.php'); ?>
	</div>

</main>

<footer>
	<div class="container-fluid">
		<div class="row">

			<div class="col s12 m10 l10">
				<h5 class="white-text"><?php echo SITENAME_PROPPER; ?> Headquarters</h5>
				<div class="grey-text">
					<a href="https://www.google.com/maps/place/Regus+Scottsdale/@33.495696,-111.924473,17z/data=!4m6!1m3!3m2!1s0x872b0bbf1d86c0fd:0xae8864ada3178e8f!2sRegus+Scottsdale!3m1!1s0x872b0bbf1d86c0fd:0xae8864ada3178e8f" target="_blank">7272 E. Indian School Rd. Suite 540  <br>
					Scottsdale, AZ 85251</a>
				</div>
			</div>
			<div class="col s12 m2 l2">
				<h5 class="white-text">Follow Us</h5>
				<ul class="follow-us">
					<li>
						<a href="<?php echo socialFacebook; ?>" target="_blank"><i class="fa fa-facebook"></i></a>
					</li>
					<li>
						<a href="<?php echo socialTwitter; ?>" target="_blank"><i class="fa fa-twitter"></i></a>
					</li>
					<li>
						<a href="<?php echo socialLinkedin; ?>" target="_blank"><i class="fa fa-linkedin"></i></a>
					</li>
					<li>
						<a href="<?php echo socialPinterest; ?>" target="_blank"><i class="fa fa-pinterest"></i></a>
					</li>
				</ul>
			</div>
			</div>
			<div class="row">
				<div class="col s12 m6 l6">
					<div class="av-versioning">
						<?php echo SITENAME_PROPPER; ?> inc. &copy; All rights reserved <?php echo date('Y'); ?>
						<span class="version">Version <?php echo VERSION; ?></span>
					</div>
				</div>
				<div class="col s12 m6 l6 right-align">
					<span class="godaddy">
						<img src="/images/godaddy.gif"/>
					</span>
				</div>
			</div>
		</div>
	</div>
</footer>



<?php
// CDN JS
foreach($app->header->cdnjs as $cdnjs){
	echo "\t".'<script src="'.$cdnjs.'"></script>'."\n";
}

if(isset($app->minify)):
	echo "\t".'<script src="/js/final.'.VERSION.'.js"></script>'."\n";
else:
	// Local JS
	foreach($app->header->localjs as $localjs){
		echo "\t".'<script src="/js/'.$localjs.'"></script>'."\n";
	}
endif;
?>
<?php if(DEBUG!=true): ?>
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
<?php
	unset($_SESSION['slim.flash']['error']);
	$_SESSION['slim.flash']['error'] = NULL;
?>
</body>
</html>
