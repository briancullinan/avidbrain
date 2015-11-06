<?php

	$allowedPages = array(
		'student-signup',
		'tutor-signup',
		'find-me-a-tutor',
		'easy-signup',
		'new-tutor-signup'
	);

	$app->meta = new stdClass();
	$app->meta->title = 'Confirmation';
	$app->meta->h1 = 'Confirmation';


	if(!in_array($type, $allowedPages)){
		$app->redirect('/');
	}


	$app->target->include = str_replace('.include.','.'.$type.'.',$app->target->include);
	//notify($app->target->include);
