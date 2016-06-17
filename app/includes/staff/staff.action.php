<?php
	$sql = "SELECT * FROM avid___admins WHERE id <> 5";
	$prepeare = array();
	$results = $app->connect->executeQuery($sql,$prepeare)->fetchAll();

	$app->staff = $results;

	$app->meta = new stdClass();
	$app->meta->title = SITENAME_PROPPER.' Staff';
	$app->meta->h1 = SITENAME_PROPPER.' Staff';
	$app->meta->keywords = SITENAME_PROPPER.' Tutoring';
	$app->meta->description = SITENAME_PROPPER.' Tutoring';
