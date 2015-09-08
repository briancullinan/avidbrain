<?php
	
	$app->meta = new stdClass();
	$app->meta->title = 'Win an iPad Mini 3 from '.$app->dependents->SITE_NAME_PROPPER;
	$app->meta->h1 = $app->dependents->SITE_NAME_PROPPER.' iPad  Giveaway';
	$app->meta->keywords = 'ipad,ipad mini, ipad mini 3,contest,win,applea,avidbrain';
	$app->meta->description = 'Enter to win an iPad Mini 3 from Abvidbrain';


	if(isset($app->user->usertype) && $app->user->usertype=='student'){
		$app->redirect('/jobs');
	}