<?php
	$sql = "SELECT * FROM avid___admins";
	$prepeare = array();
	$results = $app->connect->executeQuery($sql,$prepeare)->fetchAll();
	
	$app->staff = $results;
	
	$app->meta = new stdClass();
	$app->meta->title = $app->dependents->SITE_NAME_PROPPER.' Staff';
	$app->meta->h1 = $app->dependents->SITE_NAME_PROPPER.' Staff';
	$app->meta->keywords = $app->dependents->SITE_NAME_PROPPER.' Tutoring';
	$app->meta->description = $app->dependents->SITE_NAME_PROPPER.' Tutoring';
