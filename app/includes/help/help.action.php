<?php
	
	$app->meta = new stdClass();
	$app->meta->title = $app->dependents->SITE_NAME_PROPPER.' Help';
	$app->meta->keywords = 'get help with '.$app->dependents->SITE_NAME_PROPPER;


	if(isset($app->user->usertype)){
		if($app->user->usertype=='tutor'){
			$app->redirect('/help/faqs/tutors');
		}
		elseif($app->user->usertype=='student'){
			$app->redirect('/help/faqs/tutors');
			
		}
	}
	else{
		$app->redirect('/help/faqs');		
	}