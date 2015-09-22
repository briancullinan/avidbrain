<?php
	
	$app->howitworks = true;
	
	$app->meta = new stdClass();
	$app->meta->title = 'Find Me A Tutor';
	$app->meta->h1 = false;
	$app->meta->keywords = 'find,a,college,tutor,online,tutoring';
	$app->meta->description = 'Find a tutor';
	
	$jobOptions = array();
	$jobOptions['type'] = (object)array(
		'No Preference'=>'both',
		'Online'=>'online',
		'In Person'=>'offline'
	);
	$jobOptions['skill_level'] = (object)array(
		'Novice','Advanced Beginner','Competent','Proficient','Expert'
	);
	
	$app->jobOptions = $jobOptions;