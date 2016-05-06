<?php

	if(empty($app->user->usertype)){
		$app->tertiary = $app->target->secondary;
	}

	$childen = array();
	$childen['students'] = (object) array('name'=>'Students','slug'=>'/how-it-works/students');
	$childen['tutors'] = (object) array('name'=>'Tutors','slug'=>'/how-it-works/tutors');
	$childen['organizations'] = (object) array('name'=>'Organizations','slug'=>'/how-it-works/organizations');
	//$childen['a-message-from-our-ceo'] = (object) array('name'=>'A Message From Our CEO','slug'=>'/how-it-works/a-message-from-our-ceo');

	$app->childen = $childen;
	$navtitle = (object)array('slug'=>'/how-it-works','text'=>'How It Works');
	$app->navtitle = $navtitle;

	$app->secondary = $app->target->secondaryNav;

	$sql = "SELECT * FROM avid___howitworks WHERE newurl = :url ORDER BY `order` ASC";
	$prepeare = array(':url'=>$app->request->getPath());
	$app->howitworks = $app->connect->executeQuery($sql,$prepeare)->fetchAll();

	$sql = "SELECT * FROM avid___howitworks WHERE url = :url ";
	$prepeare = array(':url'=>'lookingformore');
	$app->lookingformore = $app->connect->executeQuery($sql,$prepeare)->fetchAll();

	$app->target->include = $app->target->base.'how-it-works.template.php';

//	printer($app->target->include,1);
