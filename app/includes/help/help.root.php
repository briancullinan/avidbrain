<?php
	
	$childen = array();
	$childen['help-faqs'] = (object) array('name'=>'FAQs','slug'=>'/help/faqs');
	if($app->dependents->SITE_NAME=='amozek'){
		$childen['what-is-amozek'] = (object) array('name'=>'What is Amozek?','slug'=>'/help/what-is-amozek');	
	}
	$childen['help-how-to-videos'] = (object) array('name'=>'How To Videos','slug'=>'/help/how-to-videos');
	$childen['forgot-password'] = (object) array('name'=>'Forgot Password','slug'=>'/help/forgot-password');
	$childen['forgot-contact'] = (object) array('name'=>'Contact Us','slug'=>'/help/contact');
	$childen['safety-center'] = (object) array('name'=>'Safety Center','slug'=>'/help/safety-center');
	
	if($app->target->key=='/help/tutor-walkthrough'){
		$childen['tutor-walkthrough'] = (object) array('name'=>'Tutor Walkthrough','slug'=>'/help/tutor-walkthrough');
	}
	
	
	$app->childen = $childen;
	$navtitle = (object)array('slug'=>'/help','text'=>'Help');
	$app->navtitle = $navtitle;
	
	$app->secondary = $app->target->secondaryNav;