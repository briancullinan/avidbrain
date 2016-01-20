<?php
	
	$app->meta = new stdClass();
	$app->meta->title = 'Import Pre-Existing Job Requests';


	if(count($app->import)==0){
		$app->redirect('/jobs');
	}