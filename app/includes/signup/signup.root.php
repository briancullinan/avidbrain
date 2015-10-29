<?php

	$childen = array();
	$childen['student'] = (object) array('name'=>'Student','slug'=>'/signup/student');
	$childen['tutor'] = (object) array('name'=>'Tutor','slug'=>'/signup/tutor');
	if($app->request->getPath()=='/signup/qa/'){
		$childen['qa'] = (object) array('name'=>'Q&A','slug'=>'/signup/qa/');
	}

	$app->childen = $childen;
	$navtitle = (object)array('slug'=>'/signup','text'=>'Signup');
	$app->navtitle = $navtitle;
	
	if($app->target->key!='/signup/tutor'){
		$app->secondary = $app->target->secondaryNav;
	}
