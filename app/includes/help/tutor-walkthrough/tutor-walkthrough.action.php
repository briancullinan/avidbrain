<?php
	$app->meta = new stdClass();
	$app->meta->title = 'Tutor Walkthrough';
	$app->meta->h1 = 'Tutor Walkthrough';


	$stepsAllowed = array(NULL,1,2,3);
	
	if(isset($step) && !in_array($step, $stepsAllowed)){
		$app->redirect('/help/tutor-walkthrough');
	}