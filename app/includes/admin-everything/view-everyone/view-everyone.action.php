<?php

	$sql = "SELECT first_name,last_name,url FROM avid___user WHERE  first_name IS NOT NULL AND url IS NOT NULL  ORDER BY id DESC";//WHERE Length(first_name) > 1
	//SELECT IFNULL( (SELECT field1 FROM table WHERE id = 123 LIMIT 1) ,'not found');
	$prepeare = array(':usertype'=>'tutor');
	$app->viewtutors = $app->connect->executeQuery($sql,$prepeare)->fetchAll();
	//printer($app->viewtutors,1);

	$sql = "SELECT * FROM avid___user WHERE usertype = :usertype ORDER BY first_name ASC";
	$prepeare = array(':usertype'=>'student');
	$app->viewstudents = $app->connect->executeQuery($sql,$prepeare)->fetchAll();

	$sql = "SELECT * FROM avid___users_temp ORDER BY first_name ASC";
	$prepeare = array();
	$app->viewpending = $app->connect->executeQuery($sql,$prepeare)->fetchAll();

	$app->meta = new stdClass();
	$app->meta->title = 'View Everyone';
