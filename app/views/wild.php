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
	
	<div class="logo">
		<a href="/">avidbrain</a>
	</div>
	
	<div class="sidebar-status">
		
		<?php if(isset($app->user->email)): ?>
			<!-- Something Here -->
		<?php else: ?>
		<a class="sidebar-signup" href="/signup">Signup</a>
		<div class="row">
			<div class="col s6 m6 l6">
				<div class="sidebar-close"><i class="fa fa-times"></i></div>
			</div>
			<div class="col s6 m6 l6 right-align">
				<div class="sidebar-login"><a href="/login">LOG IN</a></div>
			</div>
		</div>
		<?php endif; ?>
		
	</div>
	
	<ul class="sidebar-main">
		<?php foreach($app->leftnav as $key=> $navitem): ?>
		<li>
			<a class="<?php if(myrootisyourroot($app->request->getPath(),$key)){ echo ' active ';} if(isset($navitem->class)){ echo $navitem->class; } ?>" href="<?php echo $key; ?>">
				<?php echo $navitem->name; ?>
			</a>
		</li>
		<?php endforeach; ?>
	</ul>
	
	<ul class="sidebar-subs">
		<?php foreach($app->leftnavsubs as $key=> $navitem): ?>
		<li>
			<a class="<?php if(myrootisyourroot($app->request->getPath(),$key)){ echo ' active ';} if(isset($navitem->class)){ echo $navitem->class; } ?>" href="<?php echo $key; ?>">
				<?php echo $navitem->name; ?>
			</a>
		</li>
		<?php endforeach; ?>
	</ul>
	
	
</sidebar>
<header class="itstheheader">
	
	<div class="left">
		<div class="left activate-menu" data-status="closed">		
			<i class="fa fa-bars"></i> <span>Menu</span> <?php if(isset($app->messsesscount)){ echo '<i class="fa fa-circle menu-new"></i>'; } ?>
		</div>
		
	</div>
	
	<div class="logo logo-main">
		<a href="/"><img src="/images/avidbrainlogo.png" /></a>
	</div>
	
	<div class="right-info">
		<?php if(isset($app->user->email)): ?>
			<?php include('user-dropdown.wild.php'); ?>
		<?php else: ?>
		<ul class="header-nav">
			<?php
				$links = array();
				$links[] = (object)array('text'=>'Log In','link'=>'#loginModule','class'=>'modal-trigger');
				$links[] = (object)array('text'=>'Signup','link'=>'/signup','class'=>'signup-link');
				$links[] = (object)array('text'=>'Help','link'=>'/help','class'=>NULL);
			?>
			<?php foreach($links as $link): ?>
			<li <?php if($app->request->getPath()==$link->link){ echo 'class="active"';} ?>>
				<a class="<?php echo $link->class; ?>" href="<?php echo $link->link; ?>"><?php echo $link->text; ?></a>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
	</div>
	
	
	<?php if(isset($app->notifications)): ?>
	<notifications class="<?php echo $app->notifications->status; ?>">
		<?php echo $app->notifications->message; ?>
	</notifications>
	<?php endif; ?>
	
</header>


<main>
	<div class="<?php if($app->target->key=='/homepage/homepage'){ echo 'homepage-container';}else{ echo 'container container-fluid';} if(isset($app->user->email)){ echo ' liu ';} if(isset($app->notifications)){ echo 'active-notification';} ?> ">
		
		<?php if(isset($app->howitworks)){ include($app->dependents->APP_PATH.'includes/how-it-works/how-it-works.php'); } ?>
		<?php if(isset($_SESSION['slim.flash']['error'])): ?>
			<div class="say-message"><div class="the-message show-message"><?php echo $_SESSION['slim.flash']['error']; ?></div></div>
		<?php endif; ?>
		
		<?php if(isset($app->secondary) && file_exists($app->secondary) || isset($app->tertiary) && file_exists($app->tertiary)): ?>
			
			<div class="row">
				<div class="col s12 m3 l3">
					<div class="left-navigation">
						<?php if(file_exists($app->secondary)){include($app->secondary);} ?>
						<?php if(file_exists($app->tertiary)){include($app->tertiary);} ?>
					</div>
				</div>
				<div class="col s12 m9 l9">
					<?php include('wild.pages.php'); ?>
				</div>
			</div>
		
		<?php else: ?>
		
			<?php include('wild.pages.php'); ?>
		
		<?php endif; ?>
		
	</div>
	

	<?php if(isset($pagename) && $pagename=='my-photos'): ?>
	<div class="container">
		<div class="row">
			<div class="col s12 m3 l3">
				&nbsp;
			</div>
			<div class="col s12 m9 l9">
				<div class="imagewidth">
					&nbsp;
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
	
</main>

<footer>
	<div class="container">
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
			<div class="col s12 m4 l4">
				<h5 class="white-text"><?php echo $app->dependents->SITE_NAME_PROPPER; ?> Headquarters</h5>
				<div class="grey-text">
					<a href="https://www.google.com/maps/place/Regus+Scottsdale/@33.495696,-111.924473,17z/data=!4m6!1m3!3m2!1s0x872b0bbf1d86c0fd:0xae8864ada3178e8f!2sRegus+Scottsdale!3m1!1s0x872b0bbf1d86c0fd:0xae8864ada3178e8f" target="_blank">7272 E. Indian School Rd. Suite 540  <br>
					Scottsdale, AZ 85251</a>
				</div>
			</div>
			<div class="col s12 m2 l2">
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
	</div>
</footer>

<?php include('modals.php'); ?>
	
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
<?php
	unset($_SESSION['slim.flash']['error']);
	$_SESSION['slim.flash']['error'] = NULL;
?>
</body>
</html>