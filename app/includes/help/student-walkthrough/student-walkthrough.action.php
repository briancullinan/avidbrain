<?php
	$app->meta = new stdClass();
	$app->meta->title = 'Student Walkthrough';
	$app->meta->h1 = 'Student Walkthrough';


	$stepsAllowed = array(NULL,1,2,3);
	
	if(isset($step) && !in_array($step, $stepsAllowed)){
		$app->redirect('/help/student-walkthrough');
	}