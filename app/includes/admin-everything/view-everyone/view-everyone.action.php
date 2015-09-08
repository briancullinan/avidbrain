<?php
	
	$sql = "SELECT * FROM avid___user WHERE usertype = :usertype ORDER BY first_name ASC";
	$prepeare = array(':usertype'=>'tutor');
	$app->viewtutors = $app->connect->executeQuery($sql,$prepeare)->fetchAll();
	
	$sql = "SELECT * FROM avid___user WHERE usertype = :usertype ORDER BY first_name ASC";
	$prepeare = array(':usertype'=>'student');
	$app->viewstudents = $app->connect->executeQuery($sql,$prepeare)->fetchAll();
	
	$sql = "SELECT * FROM avid___users_temp ORDER BY first_name ASC";
	$prepeare = array();
	$app->viewpending = $app->connect->executeQuery($sql,$prepeare)->fetchAll();
	
	$app->meta = new stdClass();
	$app->meta->title = 'View Everyone';

