<?php
	
	$childen = array();
	$childen['privacy-policy'] = (object) array('name'=>'Privacy Policy','slug'=>'/terms-of-use/privacy-policy');
	$childen['student-payment-policy'] = (object) array('name'=>'Student Payment Policy','slug'=>'/terms-of-use/student-payment-policy');
	
	$app->childen = $childen;
	$navtitle = (object)array('slug'=>'/terms-of-use','text'=>'Terms of Use');
	$app->navtitle = $navtitle;
	
	$app->secondary = $app->target->secondaryNav;