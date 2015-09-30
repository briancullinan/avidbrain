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
<body class="body <?php if(isset($app->secondary) && file_exists($app->secondary)){ echo 'sub-active';} if(isset($app->user->email)){ echo ' active-user ';} echo ' page--'.str_replace('-','',$app->target->css).' '; ?>">
<sidebar>
	
	<div class="sidebar-status">
		
		<div class="row">
			<div class="col s12 m6 l6">
				<div class="sidebar-close"><i class="fa fa-times"></i></div>
			</div>
			<div class="col s12 m6 l6 right-align">
				<div class="sidebar-login"><a href="/login">LOG IN</a></div>
			</div>
		</div>
		
	</div>
	
	<a class="sidebar-signup" href="/signup">Signup</a>
	
	<ul class="sidebar-main">
		<li>
			<a href="/">
				Home
			</a>
		</li>
		<li>
			<a href="/tutors">
				Tutors
			</a>
		</li>
		<li>
			<a href="/jobs">
				Jobs
			</a>
		</li>
	</ul>
	
	<ul class="sidebar-subs">
		<li>
			<a href="/help">
				Help
			</a>
		</li>
		<li>
			<a href="/how-it-works">
				How It Works
			</a>
		</li>
	</ul>
	
</sidebar>
<header class="grabber">
	
	<div class="left">
		<div class="left activate-menu" data-status="closed">		
			<i class="fa fa-bars"></i> <span>Menu</span>
		</div>
		
	</div>
	
	<div class="logo align-center">
		<a href="/"><img src="/images/avidbrain-logo.png" class="responsive-img" /></a>
	</div>
	
	<div class="right white-text">
		<ul class="header-nav">
			<li>
				<a href="/login">Login</a>
			</li>
			<li>
				<a href="/signup">Signup</a>
			</li>
		</ul>
	</div>
	
</header>
<main>
	
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
	
</main>
<footer>footer</footer>
	
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